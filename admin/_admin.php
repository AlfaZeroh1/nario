<?php
declare(strict_types=1);
/* Shared admin bootstrap: auth guard, layout and upload helper. */
require dirname(__DIR__) . '/includes/bootstrap.php';

header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');

function admin_user(): ?array
{
    return $_SESSION['admin'] ?? null;
}

function require_admin(): void
{
    if (!admin_user()) {
        header('Location: login.php');
        exit;
    }
    if (!db()) {
        exit('Database not reachable. Check config.php or run install.php.');
    }
}

function flash(?string $msg = null, string $type = 'ok'): ?array
{
    if ($msg !== null) {
        $_SESSION['flash'] = [$msg, $type];
        return null;
    }
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function redirect(string $to): never
{
    header('Location: ' . $to);
    exit;
}

function post_guard(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrf_ok()) {
        http_response_code(419);
        exit('Session expired. Go back, refresh and try again.');
    }
}

/**
 * Store an uploaded image. Returns the public path ("uploads/…") or '' when nothing was uploaded.
 * Throws RuntimeException with a friendly message on bad files.
 */
function handle_upload(string $field, string $folder): string
{
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return '';
    $f = $_FILES[$field];
    if ($f['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('Upload failed (code ' . $f['error'] . ').');
    $max = (int)config('max_upload_mb', 4) * 1024 * 1024;
    if ($f['size'] > $max) throw new RuntimeException('Image is larger than ' . config('max_upload_mb', 4) . ' MB.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $ext = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp', 'image/gif' => 'gif'][$mime] ?? null;
    if (!$ext) throw new RuntimeException('Only PNG, JPG, WEBP or GIF images are allowed.');
    if (!@getimagesize($f['tmp_name'])) throw new RuntimeException('That file is not a valid image.');
    $dir = ROOT . '/uploads/' . $folder;
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) throw new RuntimeException('Cannot create uploads/' . $folder . '. Make uploads/ writable.');
    $name = bin2hex(random_bytes(10)) . '.' . $ext;
    if (!move_uploaded_file($f['tmp_name'], $dir . '/' . $name)) throw new RuntimeException('Could not save the image. Make uploads/ writable.');
    return 'uploads/' . $folder . '/' . $name;
}

function delete_upload(string $path): void
{
    if (str_starts_with($path, 'uploads/') && !str_contains($path, '..')) {
        @unlink(ROOT . '/' . $path);
    }
}

function unread_count(): int
{
    try {
        return (int)db()->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();
    } catch (Throwable $e) {
        return 0;
    }
}

function admin_head(string $title, string $active): void
{
    $unread = unread_count();
    $links = ['index' => ['Dashboard', 'grid']];
    foreach (ITEM_TYPES as $t => $meta) $links['items.php?type=' . $t] = [$meta['label'], ['partner' => 'handshake', 'client' => 'users', 'product' => 'layers', 'game' => 'game'][$t]];
    $links['messages'] = ['Messages', 'mail'];
    $links['settings'] = ['Settings', 'cog'];
    ?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title) ?> · Nario Labs CMS</title>
<meta name="robots" content="noindex,nofollow">
<link rel="icon" href="../assets/img/favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@700;800&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<aside class="side">
  <a class="side-brand" href="index.php"><span data-monkey class="side-monkey"></span><span>NARIO <b>CMS</b></span></a>
  <nav>
    <?php foreach ($links as $href => [$label, $ic]):
        $url = str_contains($href, '.php') ? $href : $href . '.php';
        $is = $active === $href; ?>
      <a class="<?= $is ? 'on' : '' ?>" href="<?= e($url) ?>"><i class="ic ic-<?= $ic ?>"></i><?= e($label) ?><?php if ($href === 'messages' && $unread): ?><span class="badge"><?= $unread ?></span><?php endif; ?></a>
    <?php endforeach; ?>
  </nav>
  <div class="side-foot">
    <a href="../" target="_blank">View site ↗</a>
    <a href="logout.php">Log out (<?= e(admin_user()['username'] ?? '') ?>)</a>
  </div>
</aside>
<main class="content">
  <header class="top"><h1><?= e($title) ?></h1></header>
  <?php if ($f = flash()): ?><p class="note <?= e($f[1]) ?>"><?= e($f[0]) ?></p><?php endif; ?>
<?php
}

function admin_foot(): void
{
    ?>
</main>
<script src="../assets/js/monkey.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
<?php
}
