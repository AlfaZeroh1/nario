<?php
declare(strict_types=1);
require __DIR__ . '/_admin.php';

if (admin_user()) redirect('index.php');

$error = '';
$_SESSION['login_fails'] ??= 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    post_guard();
    if ($_SESSION['login_fails'] >= 5 && time() - ($_SESSION['login_last'] ?? 0) < 300) {
        $error = 'Too many attempts. Wait 5 minutes and try again.';
    } elseif (!db()) {
        $error = 'Database not reachable. Run install.php first.';
    } else {
        $st = db()->prepare('SELECT id, username, password_hash FROM admins WHERE username = ?');
        $st->execute([trim((string)($_POST['username'] ?? ''))]);
        $u = $st->fetch();
        if ($u && password_verify((string)($_POST['password'] ?? ''), $u['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin'] = ['id' => (int)$u['id'], 'username' => $u['username']];
            $_SESSION['login_fails'] = 0;
            db()->prepare('UPDATE admins SET last_login = NOW() WHERE id = ?')->execute([$u['id']]);
            if (password_needs_rehash($u['password_hash'], PASSWORD_DEFAULT)) {
                db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')->execute([password_hash((string)$_POST['password'], PASSWORD_DEFAULT), $u['id']]);
            }
            redirect('index.php');
        }
        $_SESSION['login_fails']++;
        $_SESSION['login_last'] = time();
        usleep(400000);
        $error = 'Wrong username or password.';
    }
}
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Log in · Nario Labs CMS</title>
<meta name="robots" content="noindex,nofollow">
<link rel="icon" href="../assets/img/favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@700;800&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="auth">
<main class="auth-card">
  <div class="auth-brand"><div data-monkey class="auth-monkey"></div><h1>NARIO <b>CMS</b></h1></div>
  <?php if ($error): ?><p class="note err"><?= e($error) ?></p><?php endif; ?>
  <form method="post" class="form">
    <?= csrf_field() ?>
    <label>Username<input name="username" autocomplete="username" required autofocus></label>
    <label>Password<input type="password" name="password" autocomplete="current-password" required></label>
    <button class="btn" type="submit">Enter the forge</button>
  </form>
</main>
<script src="../assets/js/monkey.js"></script>
</body>
</html>
