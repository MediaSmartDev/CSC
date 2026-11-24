<?php
/* Ajouter (feminine_edit.php) ou modifier (feminine_edit.php?id=...) un membre de l'équipe féminine */
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/feminine_common.php';
$admin = require_login();
$pdo = db();

$id = (int)($_GET['id'] ?? 0);
$row = null;
if ($id) {
    $st = $pdo->prepare('SELECT * FROM equipe_feminine WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) { flash('danger', tr('Member not found.')); redirect('feminine.php'); }
}
$gDefault = (int)($_GET['groupe'] ?? 2);
if (!isset(FEM_GROUPES[$gDefault])) $gDefault = 2;

$v = $row ?: ['groupe' => $gDefault, 'nom' => '', 'nom_ar' => '', 'num' => null, 'role_fr' => '', 'role_ar' => '', 'img' => '', 'publie' => 1];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $txt = fn($k, $max) => mb_substr(trim(preg_replace('/\s+/u', ' ', (string)($_POST[$k] ?? ''))), 0, $max);
    $v['nom'] = $txt('nom', 150);
    $v['nom_ar'] = $txt('nom_ar', 150);
    $v['role_fr'] = $txt('role_fr', 80);
    $v['role_ar'] = $txt('role_ar', 80);
    $v['groupe'] = (int)($_POST['groupe'] ?? 0);
    $v['publie'] = isset($_POST['publie']) ? 1 : 0;
    if (!isset(FEM_GROUPES[$v['groupe']])) $errors[] = tr('Invalid group.');
    // Rôle identique au rôle par défaut du groupe : inutile de le stocker
    if (isset(FEM_GROUPES[$v['groupe']]) && $v['role_fr'] === FEM_GROUPES[$v['groupe']][1] && $v['role_ar'] === '') $v['role_fr'] = '';

    $n = trim((string)($_POST['num'] ?? ''));
    if ($n === '') $v['num'] = null;
    elseif (!ctype_digit($n) || (int)$n < 1 || (int)$n > 99) $errors[] = tr('The number must be between 1 and 99.');
    else $v['num'] = (int)$n;

    // Numéro déjà porté par une autre joueuse affichée (staff non concerné)
    if ($v['num'] !== null && $v['groupe'] !== 3 && $v['publie']) {
        $q = $pdo->prepare('SELECT nom FROM equipe_feminine WHERE num = ? AND groupe IN (1, 2) AND publie = 1 AND id <> ?');
        $q->execute([$v['num'], $id]);
        if ($o = $q->fetch()) $errors[] = tr('Number %1$s is already worn by %2$s. Hide or edit her first.', $v['num'], fem_nom($o));
    }

    $oldImg = $row['img'] ?? '';
    $hasFile = !empty($_FILES['img']) && ($_FILES['img']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
    if (!$errors) {
        try {
            $img = $hasFile ? save_uploaded_image($_FILES['img'], ADMIN_UPLOAD_FEMININE, FEM_PHOTO_SIZE) : null;
            if ($img) $v['img'] = $img;
            elseif (isset($_POST['img_remove'])) $v['img'] = null;
        } catch (RuntimeException $ex) {
            $errors[] = $ex->getMessage();
        }
    }
    if (!$errors && !$row && empty($v['img'])) $errors[] = tr('Add a photo: on the site, each card is a photo.');

    if (!$errors) {
        $cols = ['groupe', 'nom', 'nom_ar', 'num', 'role_fr', 'role_ar', 'img', 'publie'];
        $vals = array_map(fn($c) => $v[$c] === '' && in_array($c, ['nom_ar', 'role_ar', 'img'], true) ? null : $v[$c], $cols);
        if ($row) {
            if ((int)$row['groupe'] !== $v['groupe']) {        // changement de groupe : à la fin du nouveau
                $cols[] = 'ordre';
                $o = $pdo->prepare('SELECT COALESCE(MAX(ordre), 0) + 1 FROM equipe_feminine WHERE groupe = ?'); $o->execute([$v['groupe']]);
                $vals[] = (int)$o->fetchColumn();
            }
            $set = implode(', ', array_map(fn($c) => "`$c` = ?", $cols));
            $pdo->prepare("UPDATE equipe_feminine SET $set WHERE id = ?")->execute([...$vals, $id]);
            if ($oldImg !== ($v['img'] ?? '')) delete_uploaded_image($oldImg);
            flash('success', tr('Saved: %s', fem_nom($v)));
        } else {
            $o = $pdo->prepare('SELECT COALESCE(MAX(ordre), 0) + 1 FROM equipe_feminine WHERE groupe = ?'); $o->execute([$v['groupe']]);
            $cols[] = 'ordre'; $vals[] = (int)$o->fetchColumn();
            $ph = implode(', ', array_fill(0, count($cols), '?'));
            $pdo->prepare('INSERT INTO equipe_feminine (`' . implode('`, `', $cols) . "`) VALUES ($ph)")->execute($vals);
            $id = (int)$pdo->lastInsertId();
            flash('success', $v['publie'] ? tr('Added to the women’s team: %s (visible on the site)', fem_nom($v)) : tr('Added to the women’s team: %s (hidden for now)', fem_nom($v)));
        }
        redirect('feminine.php#f' . $id);
    }
}

$roles = array_unique(array_merge(['Head coach', 'Assistant coach', 'Coach', 'Goalkeeper coach', 'Fitness coach', 'Doctor', 'Physiotherapist', 'Kit manager'],
          $pdo->query("SELECT DISTINCT role_fr FROM equipe_feminine WHERE role_fr <> ''")->fetchAll(PDO::FETCH_COLUMN)));
page_header($row ? tr('Edit a women’s team player') : tr('Add a women’s team player'), $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><?= $row ? '<i class="fas fa-pen"></i> ' . e(tr('Edit: %s', fem_nom($row))) : '<i class="fas fa-plus"></i> ' . e(tr('New member (women\'s team)')) ?></h1>
  <a class="btn btn-light" href="feminine.php"><i class="fas fa-arrow-left"></i> <?= e(tr('Back to the list')) ?></a>
</div>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b><?= e(tr('Please fix:')) ?></b><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="adm-form">
  <?= csrf_field() ?>
  <div class="adm-card">
    <div class="adm-img-row">
      <div class="text-center">
        <img id="imgPreview" class="adm-preview-fem" src="<?= e(admin_img($v['img'] ?: 'images/player-default.png')) ?>" alt="">
      </div>
      <div style="flex:1;min-width:260px">
        <h2 class="adm-h2"><?= e(tr('Photo')) ?><?= $row ? '' : ' *' ?></h2>
        <input type="file" name="img" id="imgInput" accept="image/jpeg,image/png,image/webp" class="form-control-file">
        <small class="text-muted d-block mt-1"><?= e(tr('JPG, PNG or WEBP, max %s. The photo is cropped automatically to an 800×1200 portrait (like the current photos on the page), keeping the top of the image.', upload_limit_label())) ?></small>
        <?php if ($row && $v['img']): ?><label class="mt-2 small"><input type="checkbox" name="img_remove" value="1"> <?= e(tr('Remove the photo')) ?></label><?php endif; ?>
      </div>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Identity')) ?> <span class="text-muted small"><?= e(tr('(optional: empty = nothing shown on the card)')) ?></span></h2>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Full name')) ?></label>
        <input class="form-control" dir="ltr" name="nom" value="<?= e($v['nom']) ?>" maxlength="150" placeholder="e.g. Amina BENALI"></div>
      <div class="form-group col-md-6" dir="rtl"><label>الاسم بالعربية</label>
        <input class="form-control" name="nom_ar" value="<?= e($v['nom_ar'] ?? '') ?>" maxlength="150" placeholder="أمينة بن علي"></div>
    </div>
    <small class="text-muted"><?= e(tr('Without an Arabic name, the Arabic site shows the Latin name.')) ?></small>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('In the team')) ?></h2>
    <div class="form-row">
      <div class="form-group col-md-4"><label><?= e(tr('Group')) ?> *</label>
        <select class="form-control" name="groupe">
          <?php foreach (FEM_GROUPES as $g => [$lab]): ?>
            <option value="<?= $g ?>" <?= (int)$v['groupe'] === $g ? 'selected' : '' ?>><?= e(tr($lab)) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div class="form-group col-md-3"><label><?= e(tr('Shirt number')) ?></label>
        <input type="number" class="form-control" name="num" min="1" max="99" value="<?= e($v['num'] ?? '') ?>"></div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Displayed role (in English)')) ?> <small class="text-muted"><?= e(tr('(optional)')) ?></small></label>
        <input class="form-control" dir="ltr" name="role_fr" list="roles" value="<?= e($v['role_fr']) ?>" maxlength="80" placeholder="<?= e(tr('Empty = Goalkeeper / Player / Staff')) ?>">
        <datalist id="roles"><?php foreach ($roles as $p): ?><option value="<?= e($p) ?>"><?php endforeach; ?></datalist>
        <small class="text-muted"><?= e(tr('Mostly useful for staff (e.g. Head coach).')) ?></small></div>
      <div class="form-group col-md-6" dir="rtl"><label>الدور بالعربية</label>
        <input class="form-control" name="role_ar" value="<?= e($v['role_ar'] ?? '') ?>" maxlength="80" placeholder="مثال : المدربة الرئيسية"></div>
    </div>
    <label class="adm-switch"><input type="checkbox" name="publie" value="1" <?= $v['publie'] ? 'checked' : '' ?>> <?= e(tr('Visible on the site')) ?></label>
  </div>

  <div class="adm-submit">
    <button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> <?= e(tr('Save')) ?></button>
    <a class="btn btn-link" href="feminine.php"><?= e(tr('Cancel')) ?></a>
  </div>
</form>
<script>
document.getElementById('imgInput').addEventListener('change', function () {
  if (this.files && this.files[0]) document.getElementById('imgPreview').src = URL.createObjectURL(this.files[0]);
});
</script>
<?php page_footer();
