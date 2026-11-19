<?php
declare(strict_types=1);
require __DIR__ . '/_admin.php';
require_admin();

$pdo = db();
$counts = array_fill_keys(array_keys(ITEM_TYPES), 0);
foreach ($pdo->query('SELECT type, COUNT(*) c FROM items GROUP BY type') as $r) $counts[$r['type']] = (int)$r['c'];
$recent = $pdo->query('SELECT id, name, email, interest, is_read, created_at FROM messages ORDER BY id DESC LIMIT 6')->fetchAll();
$colors = ['partner' => '#f4c542', 'client' => '#22e3c9', 'product' => '#8c6bff', 'game' => '#ff9f1c'];

admin_head('Dashboard', 'index');
?>
<section class="hello panel">
  <div data-monkey class="hello-monkey"></div>
  <div>
    <h2>Karibu back, <?= e(admin_user()['username']) ?>.</h2>
    <p class="muted">Add partners, clients, products and games, and they appear on the site straight away.</p>
  </div>
</section>

<div class="stats">
  <?php foreach (ITEM_TYPES as $t => $m): ?>
    <a class="stat panel" href="items.php?type=<?= $t ?>" style="--c:<?= $colors[$t] ?>">
      <b><?= $counts[$t] ?></b><span><?= e($m['label']) ?></span><em>Manage →</em>
    </a>
  <?php endforeach; ?>
  <a class="stat panel" href="messages.php" style="--c:#ff4fa3"><b><?= unread_count() ?></b><span>Unread messages</span><em>Open inbox →</em></a>
</div>

<section class="panel">
  <div class="bar"><h2>Latest messages</h2><a href="messages.php">All messages →</a></div>
  <?php if (!$recent): ?><p class="muted">No messages yet. They appear here when someone uses the contact form.</p><?php else: ?>
  <table class="table">
    <thead><tr><th>From</th><th>Interest</th><th>Received</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($recent as $m): ?>
      <tr class="<?= $m['is_read'] ? '' : 'unread' ?>">
        <td><b><?= e($m['name']) ?></b><br><small class="muted"><?= e($m['email']) ?></small></td>
        <td><?= e($m['interest'] ?: '—') ?></td>
        <td><?= e(date('d M Y, H:i', strtotime($m['created_at']))) ?></td>
        <td><a class="btn sm ghost" href="messages.php?view=<?= (int)$m['id'] ?>">Read</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</section>
<?php admin_foot(); ?>
