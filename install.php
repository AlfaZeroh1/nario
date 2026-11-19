<?php
declare(strict_types=1);
/**
 * Nario Labs installer.
 * 1. Creates config.php with your database details.
 * 2. Creates the tables and your admin account.
 * 3. Optionally loads the demo content.
 * It refuses to run again once an admin exists. Delete this file after installing.
 */
require __DIR__ . '/includes/bootstrap.php';

$locked = false;
if (file_exists(__DIR__ . '/config.php') && ($pdo = db())) {
    try {
        $locked = (int)$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn() > 0;
    } catch (Throwable $e) {
    }
}

$errors = [];
$done = false;
$v = fn(string $k, string $d = '') => trim((string)($_POST[$k] ?? $d));

if (!$locked && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_ok()) {
        $errors[] = 'Session expired, please try again.';
    }
    $dbc = [
        'host' => $v('db_host', '127.0.0.1'), 'port' => (int)$v('db_port', '3306'),
        'name' => $v('db_name', 'nario_labs'), 'user' => $v('db_user', 'root'),
        'pass' => (string)($_POST['db_pass'] ?? ''), 'charset' => 'utf8mb4',
    ];
    $user = $v('admin_user');
    $pass = (string)($_POST['admin_pass'] ?? '');
    if (!preg_match('/^[a-zA-Z0-9_.-]{3,60}$/', $user)) $errors[] = 'Username: 3–60 letters, numbers, dot, dash or underscore.';
    if (strlen($pass) < 10) $errors[] = 'Password must be at least 10 characters.';
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $dbc['name'])) $errors[] = 'Database name may only contain letters, numbers and underscores.';

    if (!$errors) {
        try {
            $pdo = new PDO("mysql:host={$dbc['host']};port={$dbc['port']};charset=utf8mb4", $dbc['user'], $dbc['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbc['name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$dbc['name']}`");
            foreach (array_filter(array_map('trim', explode(';', (string)file_get_contents(__DIR__ . '/data/schema.sql')))) as $sql) {
                if (preg_match('/^\s*(--.*\n\s*)*$/', $sql)) continue;
                $pdo->exec($sql);
            }
            $st = $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)');
            $st->execute([$user, password_hash($pass, PASSWORD_DEFAULT)]);

            $st = $pdo->prepare('INSERT IGNORE INTO settings (skey, svalue) VALUES (?, ?)');
            foreach (DEFAULT_SETTINGS as $k => $val) $st->execute([$k, $val]);

            if (!empty($_POST['seed'])) {
                $ins = $pdo->prepare('INSERT INTO items (type, name, url, logo, tagline, status, category, size, accent, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?)');
                foreach (demo_data() as $type => $rows) {
                    foreach ($rows as $i => $r) {
                        $ins->execute([$type, $r['name'], $r['url'] ?? '', '', $r['tagline'] ?? '', $r['status'] ?? '', $r['category'] ?? '', $r['size'] ?? 'sm', $r['accent'] ?? '', $i]);
                    }
                }
            }

            $cfg = "<?php\nreturn " . var_export([
                'db' => $dbc, 'send_mail' => false, 'max_upload_mb' => 4,
            ], true) . ";\n";
            if (file_put_contents(__DIR__ . '/config.php', $cfg) === false) {
                $errors[] = 'Tables were created, but config.php could not be written. Copy config.sample.php to config.php and enter the same database details.';
            }
            $done = !$errors;
        } catch (Throwable $ex) {
            $errors[] = 'Database error: ' . $ex->getMessage();
        }
    }
}
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Install — Nario Labs</title>
<link rel="icon" href="assets/img/favicon.svg">
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="auth">
<main class="auth-card wide">
  <div class="auth-brand"><div data-monkey class="auth-monkey"></div><h1>Install Nario Labs</h1></div>
  <?php if ($locked): ?>
    <p class="note">Nario Labs is already installed. Delete <code>install.php</code> from the server.</p>
    <a class="btn" href="admin/">Go to the admin</a>
  <?php elseif ($done): ?>
    <p class="note ok">All set. Your site and admin are ready.</p>
    <p class="note warn">Delete <code>install.php</code> from the server now.</p>
    <a class="btn" href="admin/">Open the admin</a> <a class="btn ghost" href="./">View the site</a>
  <?php else: ?>
    <?php foreach ($errors as $err): ?><p class="note err"><?= e($err) ?></p><?php endforeach; ?>
    <form method="post" class="form">
      <?= csrf_field() ?>
      <h2>Database</h2>
      <div class="grid2">
        <label>Host<input name="db_host" value="<?= e($v('db_host', '127.0.0.1')) ?>"></label>
        <label>Port<input name="db_port" value="<?= e($v('db_port', '3306')) ?>"></label>
        <label>Database name<input name="db_name" value="<?= e($v('db_name', 'nario_labs')) ?>"></label>
        <label>User<input name="db_user" value="<?= e($v('db_user', 'root')) ?>"></label>
        <label class="span2">Password<input type="password" name="db_pass" autocomplete="off"></label>
      </div>
      <h2>Admin account</h2>
      <div class="grid2">
        <label>Username<input name="admin_user" value="<?= e($v('admin_user', 'admin')) ?>" required></label>
        <label>Password (10+ characters)<input type="password" name="admin_pass" minlength="10" required autocomplete="new-password"></label>
      </div>
      <label class="check"><input type="checkbox" name="seed" value="1" checked> Load demo partners, clients, products and games (edit or delete them later)</label>
      <button class="btn" type="submit">Install</button>
    </form>
  <?php endif; ?>
</main>
<script src="assets/js/monkey.js"></script>
</body>
</html>
