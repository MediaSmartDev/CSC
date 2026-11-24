<?php
/* Sponsors du bandeau de l'accueil : ajouter, modifier, ordre, masquer, supprimer */
require __DIR__ . '/inc/bootstrap.php';
$admin = require_login();
$pdo = db();

try { $pdo->query('SELECT 1 FROM sponsors LIMIT 1'); }
catch (PDOException $e) {
    page_header(tr('Sponsors'), $admin); ?>
    <div class="adm-card"><h1 class="adm-h1"><?= e(tr('Sponsors')) ?></h1>
      <p><?= tr('The %1$s table does not exist yet. In <b>phpMyAdmin</b>, import %2$s, then reload this page.', tr('sponsors'), '<code>database/maj_2026-11-18_admin_sponsors.sql</code>') ?></p></div>
    <?php page_footer(); exit;
}

$editId = (int)($_GET['id'] ?? 0);
$edit = null;
if ($editId) {
    $st = $pdo->prepare('SELECT * FROM sponsors WHERE id = ?'); $st->execute([$editId]);
    $edit = $st->fetch() ?: null;
}
$errors = [];
$form = $edit ?: ['nom' => '', 'lien' => '', 'publie' => 1, 'logo' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string)($_POST['action'] ?? 'save');
    $id = (int)($_POST['id'] ?? 0);

    if ($action === 'save') {
        $form['nom'] = mb_substr(trim((string)($_POST['nom'] ?? '')), 0, 100);
        $form['lien'] = trim((string)($_POST['lien'] ?? ''));
        $form['publie'] = isset($_POST['publie']) ? 1 : 0;
        if ($form['nom'] === '') $errors[] = tr('The sponsor name is required.');
        if ($form['lien'] !== '' && !preg_match('#^https?://[^\s<>"]+$#i', $form['lien'])) $errors[] = tr('The link must start with https://');
        $row = null;
        if ($id) { $st = $pdo->prepare('SELECT * FROM sponsors WHERE id = ?'); $st->execute([$id]); $row = $st->fetch(); }
        $logo = $row['logo'] ?? '';
        if (!$errors) {
            try {
                $up = !empty($_FILES['logo']) ? save_sponsor_logo($_FILES['logo']) : null;
                if ($up) $logo = $up;
            } catch (RuntimeException $ex) { $errors[] = $ex->getMessage(); }
        }
        if (!$errors && $logo === '') $errors[] = tr('Choose the sponsor logo.');
        if (!$errors) {
            if ($row) {
                $pdo->prepare('UPDATE sponsors SET nom = ?, logo = ?, lien = ?, publie = ? WHERE id = ?')->execute([$form['nom'], $logo, $form['lien'], $form['publie'], $id]);
                if ($row['logo'] !== $logo) delete_uploaded_image($row['logo']);
                flash('success', tr('Sponsor saved: %s', $form['nom']));
            } else {
                $pos = (int)$pdo->query('SELECT COALESCE(MAX(position), 0) + 1 FROM sponsors')->fetchColumn();
                $pdo->prepare('INSERT INTO sponsors (nom, logo, lien, position, publie) VALUES (?, ?, ?, ?, ?)')->execute([$form['nom'], $logo, $form['lien'], $pos, $form['publie']]);
                flash('success', tr('Sponsor added: %s (at the end of the strip).', $form['nom']));
            }
            redirect('sponsors.php');
        }
        if ($up ?? null) delete_uploaded_image($up);
    } else {
        $st = $pdo->prepare('SELECT * FROM sponsors WHERE id = ?'); $st->execute([$id]);
        $row = $st->fetch();
        if (!$row) { flash('danger', tr('Sponsor not found.')); redirect('sponsors.php'); }
        if ($action === 'delete') {
            $pdo->prepare('DELETE FROM sponsors WHERE id = ?')->execute([$id]);
            delete_uploaded_image($row['logo']);
            flash('success', tr('Sponsor deleted: %s', $row['nom']));
        } elseif ($action === 'toggle') {
            $pdo->prepare('UPDATE sponsors SET publie = 1 - publie WHERE id = ?')->execute([$id]);
            flash('success', $row['publie'] ? tr('%s is hidden from the strip.', $row['nom']) : tr('%s is shown in the strip.', $row['nom']));
        } elseif ($action === 'up' || $action === 'down') {
            $ids = array_map('intval', $pdo->query('SELECT id FROM sponsors ORDER BY position ASC, id ASC')->fetchAll(PDO::FETCH_COLUMN));
            $i = array_search($id, $ids, true); $j = $action === 'up' ? $i - 1 : $i + 1;
            if ($i !== false && isset($ids[$j])) {
                [$ids[$i], $ids[$j]] = [$ids[$j], $ids[$i]];
                $pdo->beginTransaction();
                $u = $pdo->prepare('UPDATE sponsors SET position = ? WHERE id = ?');
                foreach ($ids as $k => $sid) $u->execute([$k + 1, $sid]);
                $pdo->commit();
            }
        }
        redirect('sponsors.php');
    }
}

$list = $pdo->query('SELECT * FROM sponsors ORDER BY position ASC, id ASC')->fetchAll();
page_header(tr('Sponsors'), $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><i class="fas fa-handshake"></i> <?= e(tr('Sponsors')) ?> <span class="adm-count"><?= count($list) ?></span></h1>
  <a class="btn btn-light" href="../index.php#sponsors-section" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> <?= e(tr('View the strip')) ?></a>
</div>
<p class="text-muted small"><?= e(tr('Logos scroll on the home page in this order. Each uploaded logo is automatically put in the same format as the others (white square, centred logo, margins removed).')) ?></p>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b><?= e(tr('Please fix:')) ?></b><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="adm-card" id="form">
  <h2 class="adm-h2"><?= $edit ? e(tr('Edit: %s', $edit['nom'])) : e(tr('Add a sponsor')) ?></h2>
  <form method="post" enctype="multipart/form-data" action="sponsors.php<?= $edit ? '?id=' . (int)$edit['id'] : '' ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= (int)($edit['id'] ?? 0) ?>">
    <div class="adm-img-row">
      <div class="adm-sp-preview"><img id="logoPreview" src="<?= e($form['logo'] ? admin_img($form['logo']) : '../images/advertisehere.jpg') ?>" alt=""></div>
      <div style="flex:1;min-width:260px">
        <div class="form-row">
          <div class="form-group col-md-5"><label><?= e(tr('Last name')) ?> *</label>
            <input class="form-control" name="nom" value="<?= e($form['nom']) ?>" required maxlength="100" placeholder="e.g. Ooredoo"></div>
          <div class="form-group col-md-7"><label><?= e(tr('Website link')) ?> <small class="text-muted"><?= e(tr('(optional)')) ?></small></label>
            <input class="form-control" name="lien" value="<?= e($form['lien']) ?>" placeholder="https://..."></div>
        </div>
        <div class="form-group"><label><?= e(tr('Logo')) ?> <?= $edit ? '<small class="text-muted">' . e(tr('(leave empty to keep the current one)')) . '</small>' : '*' ?></label>
          <input type="file" name="logo" id="logoInput" accept="image/jpeg,image/png,image/webp" class="form-control-file" <?= $edit ? '' : 'required' ?>>
          <small class="text-muted d-block mt-1"><?= e(tr('JPG, PNG or WEBP, max %s. A PNG with a transparent background gives the best result.', upload_limit_label())) ?></small></div>
        <label class="adm-switch"><input type="checkbox" name="publie" value="1" <?= $form['publie'] ? 'checked' : '' ?>> <?= e(tr('Shown in the strip')) ?></label>
        <div class="mt-2">
          <button class="btn adm-btn" type="submit"><i class="fas fa-save"></i> <?= e($edit ? tr('Save') : tr('Add')) ?></button>
          <?php if ($edit): ?><a class="btn btn-link" href="sponsors.php"><?= e(tr('Cancel')) ?></a><?php endif; ?>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="adm-list">
<?php foreach ($list as $i => $s): ?>
  <div class="adm-item<?= $s['publie'] ? '' : ' is-hidden' ?>">
    <div class="adm-sp-box"><img src="<?= e(admin_img($s['logo'])) ?>" alt=""></div>
    <div class="adm-item-body">
      <div class="adm-item-title"><?= e($s['nom']) ?></div>
      <div class="adm-item-meta">
        <?php if ($s['lien']): ?><a href="<?= e($s['lien']) ?>" target="_blank" rel="noopener"><?= e($s['lien']) ?></a><?php else: ?><span><?= e(tr('no link')) ?></span><?php endif; ?>
        <?php if (!$s['publie']): ?><span class="adm-badge-hidden"><i class="fas fa-eye-slash"></i> <?= e(tr('Hidden')) ?></span><?php endif; ?>
      </div>
    </div>
    <div class="adm-actions">
      <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
        <button name="action" value="up" class="btn btn-sm btn-light" title="<?= e(tr('Move up')) ?>" <?= $i === 0 ? 'disabled' : '' ?>><i class="fas fa-arrow-up"></i></button>
        <button name="action" value="down" class="btn btn-sm btn-light" title="<?= e(tr('Move down')) ?>" <?= $i === count($list) - 1 ? 'disabled' : '' ?>><i class="fas fa-arrow-down"></i></button>
        <button name="action" value="toggle" class="btn btn-sm btn-light" title="<?= e($s['publie'] ? tr('Hide') : tr('Show')) ?>"><i class="fas <?= $s['publie'] ? 'fa-eye-slash' : 'fa-eye' ?>"></i></button>
      </form>
      <a class="btn btn-sm adm-btn" href="sponsors.php?id=<?= (int)$s['id'] ?>#form"><i class="fas fa-pen"></i> <?= e(tr('Edit')) ?></a>
      <form method="post" onsubmit="return confirm(<?= trjs('Delete this sponsor?') ?>);"><?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
        <button name="action" value="delete" class="btn btn-sm btn-outline-danger" title="<?= e(tr('Delete')) ?>"><i class="fas fa-trash"></i></button>
      </form>
    </div>
  </div>
<?php endforeach; ?>
</div>
<script>
document.getElementById('logoInput').addEventListener('change', function () {
  if (this.files && this.files[0]) document.getElementById('logoPreview').src = URL.createObjectURL(this.files[0]);
});
</script>
<?php page_footer();
