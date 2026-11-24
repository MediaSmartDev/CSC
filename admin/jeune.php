<?php
/* Ajouter (jeune.php?cat=U19) ou modifier (jeune.php?id=...) un joueur / membre du staff d'une catégorie jeunes */
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/jeunes_common.php';
$admin = require_login();
$pdo = db();

$id = (int)($_GET['id'] ?? 0);
$row = null;
if ($id) {
    $st = $pdo->prepare('SELECT * FROM jeunes WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) { flash('danger', tr('Member not found.')); redirect('jeunes.php'); }
}
$catDefault = (string)($_GET['cat'] ?? 'U21');
if (!isset(CSC_JEUNES_CATEGORIES[$catDefault])) $catDefault = 'U21';
$typeDefault = (int)($_GET['type'] ?? 1) === 2 ? 2 : 1;

$v = $row ?: ['categorie' => $catDefault, 'type' => $typeDefault, 'nom' => '', 'nom_ar' => '', 'num' => null,
              'poste' => $typeDefault === 2 ? 'Coach' : '', 'poste_ar' => '', 'img' => '', 'publie' => 1];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $txt = fn($k, $max) => mb_substr(trim(preg_replace('/\s+/u', ' ', (string)($_POST[$k] ?? ''))), 0, $max);
    $v['nom'] = $txt('nom', 150);
    $v['nom_ar'] = $txt('nom_ar', 150);
    $v['poste'] = $txt('poste', 60);
    $v['poste_ar'] = $txt('poste_ar', 80);
    $v['categorie'] = (string)($_POST['categorie'] ?? '');
    $v['type'] = (int)($_POST['type'] ?? 0);
    $v['publie'] = isset($_POST['publie']) ? 1 : 0;
    if ($v['nom'] === '') $errors[] = tr('The name is required.');
    if (!isset(CSC_JEUNES_CATEGORIES[$v['categorie']])) $errors[] = tr('Invalid category.');
    if (!isset(JEUNE_TYPES[$v['type']])) $errors[] = tr('Invalid group.');

    $n = trim((string)($_POST['num'] ?? ''));
    if ($n === '') $v['num'] = null;
    elseif (!ctype_digit($n) || (int)$n < 1 || (int)$n > 99) $errors[] = tr('The number must be between 1 and 99.');
    else $v['num'] = (int)$n;
    if ($v['num'] !== null && $v['type'] === 1 && $v['publie'] && !$errors) {
        $q = $pdo->prepare('SELECT nom FROM jeunes WHERE categorie = ? AND type = 1 AND num = ? AND publie = 1 AND id <> ?');
        $q->execute([$v['categorie'], $v['num'], $id]);
        if ($o = $q->fetch()) $errors[] = tr('Number %1$s is already worn by %2$s. Hide or edit that player first.', $v['num'], $o['nom']);
    }

    $oldImg = $row['img'] ?? '';
    if (!$errors) {
        try {
            $img = !empty($_FILES['img']) ? save_uploaded_image($_FILES['img'], ADMIN_UPLOAD_JEUNES, JEUNE_PHOTO_SIZE) : null;
            if ($img) $v['img'] = $img;
            elseif (isset($_POST['img_remove'])) $v['img'] = null;
        } catch (RuntimeException $ex) {
            $errors[] = $ex->getMessage();
        }
    }

    if (!$errors) {
        $cols = ['categorie', 'type', 'nom', 'nom_ar', 'num', 'poste', 'poste_ar', 'img', 'publie'];
        $vals = array_map(fn($c) => $v[$c] === '' && in_array($c, ['nom_ar', 'poste_ar', 'img'], true) ? null : $v[$c], $cols);
        $moved = !$row || $row['categorie'] !== $v['categorie'] || (int)$row['type'] !== $v['type'];
        if ($moved) {                                   // nouveau, ou changé de catégorie / groupe : à la fin
            $o = $pdo->prepare('SELECT COALESCE(MAX(ordre), 0) + 1 FROM jeunes WHERE categorie = ? AND type = ?');
            $o->execute([$v['categorie'], $v['type']]);
            $cols[] = 'ordre'; $vals[] = (int)$o->fetchColumn();
        }
        if ($row) {
            $set = implode(', ', array_map(fn($c) => "`$c` = ?", $cols));
            $pdo->prepare("UPDATE jeunes SET $set WHERE id = ?")->execute([...$vals, $id]);
            if ($oldImg !== ($v['img'] ?? '')) delete_uploaded_image($oldImg);
            flash('success', tr('Saved: %s', $v['nom']));
        } else {
            $ph = implode(', ', array_fill(0, count($cols), '?'));
            $pdo->prepare('INSERT INTO jeunes (`' . implode('`, `', $cols) . "`) VALUES ($ph)")->execute($vals);
            $id = (int)$pdo->lastInsertId();
            flash('success', $v['publie'] ? tr('Added: %s (visible on the site)', $v['nom']) : tr('Added: %s (hidden for now)', $v['nom']));
        }
        redirect('jeunes.php?cat=' . urlencode($v['categorie']) . '#y' . $id);
    }
}

$postes = array_unique(array_merge(JEUNE_POSTES, JEUNE_POSTES_STAFF,
          $pdo->query("SELECT DISTINCT poste FROM jeunes WHERE poste <> ''")->fetchAll(PDO::FETCH_COLUMN)));
$back = 'jeunes.php?cat=' . urlencode($v['categorie']);
page_header($row ? tr('Edit: %s', $row['nom']) : tr('Add a youth player'), $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><?= $row ? '<i class="fas fa-pen"></i> ' . e(tr('Edit: %s', $row['nom'])) : '<i class="fas fa-plus"></i> ' . e(tr('New member (youth)')) ?></h1>
  <a class="btn btn-light" href="<?= e($back) ?>"><i class="fas fa-arrow-left"></i> <?= e(tr('Back to the list')) ?></a>
</div>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b><?= e(tr('Please fix:')) ?></b><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="adm-form">
  <?= csrf_field() ?>
  <div class="adm-card">
    <div class="adm-img-row">
      <div class="text-center">
        <img id="imgPreview" class="adm-preview-player" src="<?= e(admin_img($v['img'] ?: 'images/player-default.png')) ?>" alt="">
      </div>
      <div style="flex:1;min-width:260px">
        <h2 class="adm-h2"><?= e(tr('Photo')) ?> <span class="text-muted small"><?= e(tr('(optional)')) ?></span></h2>
        <input type="file" name="img" id="imgInput" accept="image/jpeg,image/png,image/webp" class="form-control-file">
        <small class="text-muted d-block mt-1"><?= e(tr('JPG, PNG or WEBP, max %s. The photo is cropped automatically to a 600×750 portrait (like the official photos), keeping the top of the image.', upload_limit_label())) ?></small>
        <?php if ($v['img']): ?><label class="mt-2 small"><input type="checkbox" name="img_remove" value="1"> <?= e(tr('Remove the photo')) ?></label><?php endif; ?>
      </div>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Identity')) ?></h2>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Full name')) ?> *</label>
        <input class="form-control" dir="ltr" name="nom" value="<?= e($v['nom']) ?>" required maxlength="150" placeholder="e.g. BENALI Yacine"></div>
      <div class="form-group col-md-6" dir="rtl"><label>الاسم بالعربية</label>
        <input class="form-control" name="nom_ar" value="<?= e($v['nom_ar'] ?? '') ?>" maxlength="150" placeholder="بن علي ياسين"></div>
    </div>
    <small class="text-muted"><?= e(tr('Without an Arabic name, the Arabic site shows the Latin name.')) ?></small>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('In the team')) ?></h2>
    <div class="form-row">
      <div class="form-group col-md-4"><label><?= e(tr('Category')) ?> *</label>
        <select class="form-control" name="categorie">
          <?php foreach (CSC_JEUNES_CATEGORIES as $code => $_): ?>
            <option value="<?= $code ?>" <?= $v['categorie'] === $code ? 'selected' : '' ?>><?= e(jeune_cat_label($code)) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div class="form-group col-md-4"><label><?= e(tr('Group')) ?> *</label>
        <select class="form-control" name="type" id="type">
          <?php foreach (JEUNE_TYPES as $t => $lab): ?>
            <option value="<?= $t ?>" <?= (int)$v['type'] === $t ? 'selected' : '' ?>><?= e(tr($lab)) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div class="form-group col-md-4"><label><?= e(tr('Shirt number')) ?></label>
        <input type="number" class="form-control" name="num" min="1" max="99" value="<?= e($v['num'] ?? '') ?>"></div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Position (in English)')) ?></label>
        <input class="form-control" dir="ltr" name="poste" list="postes" value="<?= e($v['poste']) ?>" maxlength="60">
        <datalist id="postes"><?php foreach ($postes as $p): ?><option value="<?= e($p) ?>"><?php endforeach; ?></datalist>
        <small class="text-muted"><?= e(tr('Positions suggested in the list are translated into Arabic automatically.')) ?></small></div>
      <div class="form-group col-md-6" dir="rtl"><label>المنصب بالعربية <small class="text-muted"><?= e(tr('(optional)')) ?></small></label>
        <input class="form-control" name="poste_ar" value="<?= e($v['poste_ar'] ?? '') ?>" maxlength="80"></div>
    </div>
    <small class="text-muted d-block mb-2"><?= e(tr('The first staff member is shown as “Coach” at the top of the category.')) ?></small>
    <label class="adm-switch"><input type="checkbox" name="publie" value="1" <?= $v['publie'] ? 'checked' : '' ?>> <?= e(tr('Shown on the site')) ?></label>
  </div>

  <div class="adm-submit">
    <button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> <?= e(tr('Save')) ?></button>
    <a class="btn btn-link" href="<?= e($back) ?>"><?= e(tr('Cancel')) ?></a>
  </div>
</form>
<script>
document.getElementById('imgInput').addEventListener('change', function () {
  if (this.files && this.files[0]) document.getElementById('imgPreview').src = URL.createObjectURL(this.files[0]);
});
</script>
<?php page_footer();
