<?php
declare(strict_types=1);
require __DIR__ . '/_admin.php';
require_admin();
post_guard();
$pdo = db();

$groups = [
    'Brand' => [
        'site_name' => 'Site name', 'tagline' => 'Tagline', 'meta_description' => 'SEO description',
        'founded' => 'Year founded', 'location' => 'Location',
    ],
    'Contact' => [
        'email' => 'Email', 'phone' => 'Phone (international, e.g. +254…)', 'phone_display' => 'Phone as displayed',
        'whatsapp' => 'WhatsApp number (digits only, e.g. 2547…)', 'whatsapp_message' => 'WhatsApp pre-filled message',
    ],
    'Socials' => [
        'handle' => 'Handle', 'instagram' => 'Instagram URL', 'x' => 'X / Twitter URL', 'tiktok' => 'TikTok URL',
        'linkedin' => 'LinkedIn URL', 'youtube' => 'YouTube URL', 'facebook' => 'Facebook URL', 'github' => 'GitHub URL',
    ],
];

$action = $_POST['action'] ?? '';
if ($action === 'settings') {
    $st = $pdo->prepare('INSERT INTO settings (skey, svalue) VALUES (?, ?) ON DUPLICATE KEY UPDATE svalue = VALUES(svalue)');
    foreach ($groups as $fields) {
        foreach ($fields as $k => $_) {
            $val = trim((string)($_POST[$k] ?? ''));
            if (in_array($k, ['instagram', 'x', 'tiktok', 'linkedin', 'youtube', 'facebook', 'github'], true) && $val !== '' && !preg_match('~^https?://~i', $val)) {
                $val = 'https://' . $val;
            }
            if ($k === 'whatsapp') $val = preg_replace('/\D/', '', $val);
            $st->execute([$k, mb_substr($val, 0, 2000)]);
        }
    }
    flash('Settings saved.');
    redirect('settings.php');
}
if ($action === 'password') {
    $st = $pdo->prepare('SELECT password_hash FROM admins WHERE id = ?');
    $st->execute([admin_user()['id']]);
    $hash = (string)$st->fetchColumn();
    $new = (string)($_POST['new_password'] ?? '');
    if (!password_verify((string)($_POST['current_password'] ?? ''), $hash)) flash('Current password is wrong.', 'err');
    elseif (strlen($new) < 10) flash('New password must be at least 10 characters.', 'err');
    elseif ($new !== ($_POST['confirm_password'] ?? '')) flash('New passwords do not match.', 'err');
    else {
        $pdo->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')->execute([password_hash($new, PASSWORD_DEFAULT), admin_user()['id']]);
        flash('Password changed.');
    }
    redirect('settings.php');
}

admin_head('Settings', 'settings');
?>
<form method="post" class="panel form">
  <?= csrf_field() ?><input type="hidden" name="action" value="settings">
  <?php foreach ($groups as $title => $fields): ?>
    <h2><?= e($title) ?></h2>
    <div class="grid2">
      <?php foreach ($fields as $k => $label): ?>
        <label class="<?= in_array($k, ['meta_description', 'whatsapp_message'], true) ? 'span2' : '' ?>"><?= e($label) ?>
          <?php if ($k === 'meta_description'): ?><textarea name="<?= $k ?>" rows="3"><?= e(S($k)) ?></textarea>
          <?php else: ?><input name="<?= $k ?>" value="<?= e(S($k)) ?>"><?php endif; ?>
        </label>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
  <div class="actions"><button class="btn" type="submit">Save settings</button></div>
</form>

<form method="post" class="panel form">
  <?= csrf_field() ?><input type="hidden" name="action" value="password">
  <h2>Change password</h2>
  <div class="grid2">
    <label class="span2">Current password<input type="password" name="current_password" autocomplete="current-password" required></label>
    <label>New password (10+ characters)<input type="password" name="new_password" minlength="10" autocomplete="new-password" required></label>
    <label>Confirm new password<input type="password" name="confirm_password" minlength="10" autocomplete="new-password" required></label>
  </div>
  <div class="actions"><button class="btn" type="submit">Change password</button></div>
</form>
<?php admin_foot(); ?>
