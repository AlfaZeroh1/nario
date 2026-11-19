<?php
declare(strict_types=1);
require __DIR__ . '/_admin.php';
require_admin();
post_guard();

$type = (string)($_GET['type'] ?? 'partner');
if (!isset(ITEM_TYPES[$type])) $type = 'partner';
$meta = ITEM_TYPES[$type];
$pdo = db();
$self = 'items.php?type=' . $type;

$isShowcase = in_array($type, ['partner', 'client'], true); // spiral carousels
$fields = [
    'description' => $type === 'product',
    'status'      => in_array($type, ['product', 'game'], true),
    'category'    => in_array($type, ['product', 'game'], true),
    'size'        => $type === 'product',
    'preview'     => $isShowcase,
    'embed'       => $isShowcase,
];
$labels = [
    'logo'     => $type === 'game' ? 'Cover image (portrait, 3:4 works best)' : 'Logo (transparent PNG works best)',
    'url'      => $type === 'game' ? 'Store / trailer link' : 'Website URL',
    'category' => $type === 'game' ? 'Platforms (e.g. "PC · Steam")' : 'Category (used for filters)',
    'tagline'  => $isShowcase ? 'Short caption (optional)' : 'Tagline',
];

/* ---------- Actions ---------- */
$action = $_POST['action'] ?? '';
try {
    if ($action === 'delete') {
        $st = $pdo->prepare('SELECT logo, preview FROM items WHERE id = ? AND type = ?');
        $st->execute([(int)$_POST['id'], $type]);
        if ($row = $st->fetch()) {
            delete_upload($row['logo']); delete_upload($row['preview']);
            $pdo->prepare('DELETE FROM items WHERE id = ?')->execute([(int)$_POST['id']]);
            flash($meta['single'] . ' deleted.');
        }
        redirect($self);
    }
    if ($action === 'toggle') {
        $pdo->prepare('UPDATE items SET is_active = 1 - is_active WHERE id = ? AND type = ?')->execute([(int)$_POST['id'], $type]);
        redirect($self);
    }
    if ($action === 'reorder') {
        $st = $pdo->prepare('UPDATE items SET sort_order = ? WHERE id = ? AND type = ?');
        foreach ((array)($_POST['order'] ?? []) as $i => $id) $st->execute([(int)$i, (int)$id, $type]);
        header('Content-Type: application/json');
        exit('{"ok":true}');
    }
    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $current = ['logo' => '', 'preview' => ''];
        if ($id) {
            $st = $pdo->prepare('SELECT logo, preview FROM items WHERE id = ? AND type = ?');
            $st->execute([$id, $type]);
            $current = $st->fetch() ?: throw new RuntimeException('Item not found.');
        }
        $name = trim((string)($_POST['name'] ?? ''));
        if ($name === '') throw new RuntimeException('Name is required.');
        $url = trim((string)($_POST['url'] ?? ''));
        if ($url !== '' && !preg_match('~^https?://~i', $url)) $url = 'https://' . $url;
        if ($url !== '' && !filter_var($url, FILTER_VALIDATE_URL)) throw new RuntimeException('That website URL does not look valid.');

        $logo = $current['logo'];
        if (!empty($_POST['remove_logo'])) { delete_upload($logo); $logo = ''; }
        if ($new = handle_upload('logo', $type)) { delete_upload($logo); $logo = $new; }
        $preview = $current['preview'];
        if (!empty($_POST['remove_preview'])) { delete_upload($preview); $preview = ''; }
        if ($new = handle_upload('preview', $type . '/previews')) { delete_upload($preview); $preview = $new; }

        $data = [
            'name'        => mb_substr($name, 0, 150),
            'url'         => mb_substr($url, 0, 255),
            'logo'        => $logo,
            'preview'     => $preview,
            'tagline'     => mb_substr(trim((string)($_POST['tagline'] ?? '')), 0, 255),
            'description' => trim((string)($_POST['description'] ?? '')),
            'status'      => mb_substr(trim((string)($_POST['status'] ?? '')), 0, 40),
            'category'    => mb_substr(trim((string)($_POST['category'] ?? '')), 0, 80),
            'size'        => in_array($_POST['size'] ?? '', ['sm', 'wide', 'tall', 'lg'], true) ? $_POST['size'] : 'sm',
            'accent'      => safe_color($_POST['accent'] ?? '') ?: '',
            'embed'       => !empty($_POST['embed']) ? 1 : 0,
            'sort_order'  => (int)($_POST['sort_order'] ?? 0),
            'is_active'   => !empty($_POST['is_active']) ? 1 : 0,
        ];
        if ($id) {
            $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
            $pdo->prepare("UPDATE items SET $set WHERE id = :id AND type = :type")->execute($data + ['id' => $id, 'type' => $type]);
            flash($meta['single'] . ' updated.');
        } else {
            $cols = implode(', ', array_keys($data));
            $vals = ':' . implode(', :', array_keys($data));
            $pdo->prepare("INSERT INTO items (type, $cols) VALUES (:type, $vals)")->execute($data + ['type' => $type]);
            flash($meta['single'] . ' added.');
        }
        redirect($self);
    }
} catch (RuntimeException $ex) {
    flash($ex->getMessage(), 'err');
    redirect($self . (!empty($_POST['id']) ? '&edit=' . (int)$_POST['id'] : '&new=1'));
}

/* ---------- View ---------- */
$editing = null;
if (isset($_GET['edit'])) {
    $st = $pdo->prepare('SELECT * FROM items WHERE id = ? AND type = ?');
    $st->execute([(int)$_GET['edit'], $type]);
    $editing = $st->fetch() ?: null;
} elseif (isset($_GET['new'])) {
    $editing = ['id' => 0, 'name' => '', 'url' => '', 'logo' => '', 'preview' => '', 'tagline' => '', 'description' => '', 'status' => '', 'category' => '', 'size' => 'sm', 'accent' => '#f4c542', 'embed' => 1, 'sort_order' => 0, 'is_active' => 1];
}

$st = $pdo->prepare('SELECT * FROM items WHERE type = ? ORDER BY sort_order, id');
$st->execute([$type]);
$rows = $st->fetchAll();

admin_head($meta['label'], 'items.php?type=' . $type);
?>

<?php if ($editing !== null): ?>
  <form method="post" enctype="multipart/form-data" class="panel form">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= (int)$editing['id'] ?>">
    <h2><?= $editing['id'] ? 'Edit ' . e($editing['name']) : 'Add ' . strtolower($meta['single']) ?></h2>
    <div class="grid2">
      <label>Name *<input name="name" value="<?= e($editing['name']) ?>" required maxlength="150"></label>
      <label><?= e($labels['url']) ?><input name="url" value="<?= e($editing['url']) ?>" placeholder="https://"></label>

      <div class="upload">
        <span class="lbl"><?= e($labels['logo']) ?></span>
        <?php if ($editing['logo']): ?><img src="../<?= e($editing['logo']) ?>" alt="" class="thumb lg"><label class="check"><input type="checkbox" name="remove_logo" value="1"> Remove</label><?php endif; ?>
        <input type="file" name="logo" accept="image/png,image/jpeg,image/webp,image/gif">
      </div>
      <?php if ($fields['preview']): ?>
      <div class="upload">
        <span class="lbl">Website screenshot (optional, replaces the live iframe)</span>
        <?php if ($editing['preview']): ?><img src="../<?= e($editing['preview']) ?>" alt="" class="thumb lg"><label class="check"><input type="checkbox" name="remove_preview" value="1"> Remove</label><?php endif; ?>
        <input type="file" name="preview" accept="image/png,image/jpeg,image/webp">
      </div>
      <?php endif; ?>

      <label class="span2"><?= e($labels['tagline']) ?><input name="tagline" value="<?= e($editing['tagline']) ?>" maxlength="255"></label>
      <?php if ($fields['description']): ?><label class="span2">Description<textarea name="description" rows="4"><?= e($editing['description']) ?></textarea></label><?php endif; ?>
      <?php if ($fields['status']): ?><label>Status badge<input name="status" value="<?= e($editing['status']) ?>" list="statuses" placeholder="Live, Beta, R&D…"></label>
        <datalist id="statuses"><option>Live</option><option>Beta</option><option>In build</option><option>R&amp;D</option><option>Concept</option><option>In development</option><option>Prototype</option><option>Coming soon</option></datalist><?php endif; ?>
      <?php if ($fields['category']): ?><label><?= e($labels['category']) ?><input name="category" value="<?= e($editing['category']) ?>" maxlength="80"></label><?php endif; ?>
      <?php if ($fields['size']): ?>
        <label>Bento tile size
          <select name="size">
            <?php foreach (['sm' => 'Small (1×1)', 'wide' => 'Wide (2×1)', 'tall' => 'Tall (1×2)', 'lg' => 'Large (2×2)'] as $k => $l): ?>
              <option value="<?= $k ?>"<?= $editing['size'] === $k ? ' selected' : '' ?>><?= $l ?></option>
            <?php endforeach; ?>
          </select>
        </label>
      <?php endif; ?>
      <label>Accent colour<span class="color-row"><input type="color" name="accent" value="<?= e($editing['accent'] ?: '#f4c542') ?>">
        <?php foreach (['#f4c542', '#22e3c9', '#ff4fa3', '#8c6bff', '#4fc3ff', '#ff9f1c', '#c6ff4f'] as $c): ?><button type="button" class="swatch" style="background:<?= $c ?>" data-color="<?= $c ?>" aria-label="Use <?= $c ?>"></button><?php endforeach; ?></span></label>
      <label>Sort order<input type="number" name="sort_order" value="<?= (int)$editing['sort_order'] ?>"></label>
      <?php if ($fields['embed']): ?><label class="check span2"><input type="checkbox" name="embed" value="1"<?= $editing['embed'] ? ' checked' : '' ?>> Show the live website in the spiral (turn off for sites that refuse to load in frames)</label><?php endif; ?>
      <label class="check span2"><input type="checkbox" name="is_active" value="1"<?= $editing['is_active'] ? ' checked' : '' ?>> Visible on the website</label>
    </div>
    <div class="actions">
      <button class="btn" type="submit">Save</button>
      <a class="btn ghost" href="<?= e($self) ?>">Cancel</a>
    </div>
  </form>
<?php else: ?>
  <div class="bar">
    <p class="muted"><?= count($rows) ?> <?= strtolower($meta['label']) ?>. Drag rows to reorder. <?= $isShowcase ? 'These appear in the spiral carousel.' : ($type === 'product' ? 'These appear in the products bento.' : '') ?></p>
    <a class="btn" href="<?= e($self) ?>&new=1">+ Add <?= strtolower($meta['single']) ?></a>
  </div>
  <?php if (!$rows): ?>
    <div class="panel empty"><div data-monkey class="empty-monkey"></div><p>No <?= strtolower($meta['label']) ?> yet.</p><a class="btn" href="<?= e($self) ?>&new=1">Add the first one</a></div>
  <?php else: ?>
  <table class="table" data-sortable data-type="<?= e($type) ?>" data-csrf="<?= csrf_token() ?>">
    <thead><tr><th></th><th>Logo</th><th>Name</th><th>Link</th><?= $fields['status'] ? '<th>Status</th>' : '' ?><th>Visible</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr draggable="true" data-id="<?= (int)$r['id'] ?>">
        <td class="grip" title="Drag to reorder">⋮⋮</td>
        <td><?php if ($r['logo']): ?><img class="thumb" src="../<?= e($r['logo']) ?>" alt=""><?php else: ?><span class="mono" style="background:<?= e($r['accent'] ?: '#f4c542') ?>"><?= e(mb_strtoupper(mb_substr($r['name'], 0, 2))) ?></span><?php endif; ?></td>
        <td><b><?= e($r['name']) ?></b><?php if ($r['tagline']): ?><br><small class="muted"><?= e(mb_strimwidth($r['tagline'], 0, 70, '…')) ?></small><?php endif; ?></td>
        <td><?php if ($r['url']): ?><a href="<?= e($r['url']) ?>" target="_blank" rel="noopener"><?= e(parse_url($r['url'], PHP_URL_HOST) ?: $r['url']) ?> ↗</a><?php else: ?><span class="muted">—</span><?php endif; ?></td>
        <?= $fields['status'] ? '<td>' . e($r['status']) . '</td>' : '' ?>
        <td>
          <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
            <button class="pill <?= $r['is_active'] ? 'on' : '' ?>" type="submit"><?= $r['is_active'] ? 'Visible' : 'Hidden' ?></button></form>
        </td>
        <td class="row-actions">
          <a class="btn sm ghost" href="<?= e($self) ?>&edit=<?= (int)$r['id'] ?>">Edit</a>
          <form method="post" onsubmit="return confirm('Delete <?= e(addslashes($r['name'])) ?>? This cannot be undone.')"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><button class="btn sm danger" type="submit">Delete</button></form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
<?php endif; ?>

<?php admin_foot(); ?>
