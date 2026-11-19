<?php
declare(strict_types=1);
require __DIR__ . '/_admin.php';
require_admin();
post_guard();
$pdo = db();

if (($_POST['action'] ?? '') === 'delete') {
    $pdo->prepare('DELETE FROM messages WHERE id = ?')->execute([(int)$_POST['id']]);
    flash('Message deleted.');
    redirect('messages.php');
}
if (($_POST['action'] ?? '') === 'unread') {
    $pdo->prepare('UPDATE messages SET is_read = 0 WHERE id = ?')->execute([(int)$_POST['id']]);
    redirect('messages.php');
}

$view = null;
if (isset($_GET['view'])) {
    $st = $pdo->prepare('SELECT * FROM messages WHERE id = ?');
    $st->execute([(int)$_GET['view']]);
    if ($view = $st->fetch()) $pdo->prepare('UPDATE messages SET is_read = 1 WHERE id = ?')->execute([$view['id']]);
}

$filter = $_GET['interest'] ?? '';
$sql = 'SELECT id, name, email, company, interest, is_read, created_at FROM messages';
$args = [];
if ($filter !== '') { $sql .= ' WHERE interest = ?'; $args[] = $filter; }
$st = $pdo->prepare($sql . ' ORDER BY id DESC LIMIT 300');
$st->execute($args);
$rows = $st->fetchAll();

admin_head('Messages', 'messages');
?>
<?php if ($view): ?>
  <section class="panel message">
    <div class="bar"><a href="messages.php">← All messages</a><small class="muted"><?= e(date('l d M Y, H:i', strtotime($view['created_at']))) ?></small></div>
    <h2><?= e($view['name']) ?><?= $view['company'] ? ' · ' . e($view['company']) : '' ?></h2>
    <dl class="meta">
      <dt>Email</dt><dd><a href="mailto:<?= e($view['email']) ?>"><?= e($view['email']) ?></a></dd>
      <?php if ($view['phone']): ?><dt>Phone</dt><dd><a href="tel:<?= e($view['phone']) ?>"><?= e($view['phone']) ?></a> · <a href="https://wa.me/<?= e(preg_replace('/\D/', '', $view['phone'])) ?>" target="_blank" rel="noopener">WhatsApp</a></dd><?php endif; ?>
      <dt>Interest</dt><dd><?= e($view['interest'] ?: '—') ?></dd>
      <dt>Budget</dt><dd><?= e($view['budget'] ?: '—') ?></dd>
    </dl>
    <div class="msg-body"><?= nl2br(e($view['message'])) ?></div>
    <div class="actions">
      <a class="btn" href="mailto:<?= e($view['email']) ?>?subject=<?= rawurlencode('Re: your message to Nario Labs') ?>">Reply by email</a>
      <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="unread"><input type="hidden" name="id" value="<?= (int)$view['id'] ?>"><button class="btn ghost" type="submit">Mark unread</button></form>
      <form method="post" onsubmit="return confirm('Delete this message permanently?')"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$view['id'] ?>"><button class="btn danger" type="submit">Delete</button></form>
    </div>
  </section>
<?php else: ?>
  <div class="bar">
    <div class="chips">
      <?php foreach (['' => 'All', 'partner' => 'Partnership', 'custom' => 'Custom', 'saas' => 'SaaS', 'rnd' => 'R&D', 'games' => 'Games', 'other' => 'Other'] as $k => $l): ?>
        <a class="chip <?= $filter === $k ? 'on' : '' ?>" href="messages.php<?= $k ? '?interest=' . $k : '' ?>"><?= e($l) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
  <?php if (!$rows): ?>
    <div class="panel empty"><div data-monkey class="empty-monkey"></div><p>Inbox is empty.</p></div>
  <?php else: ?>
  <table class="table">
    <thead><tr><th>From</th><th>Company</th><th>Interest</th><th>Received</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $m): ?>
      <tr class="<?= $m['is_read'] ? '' : 'unread' ?>">
        <td><b><?= e($m['name']) ?></b><br><small class="muted"><?= e($m['email']) ?></small></td>
        <td><?= e($m['company'] ?: '—') ?></td>
        <td><?= e($m['interest'] ?: '—') ?></td>
        <td><?= e(date('d M Y, H:i', strtotime($m['created_at']))) ?></td>
        <td><a class="btn sm ghost" href="messages.php?view=<?= (int)$m['id'] ?>">Read</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
<?php endif; ?>
<?php admin_foot(); ?>
