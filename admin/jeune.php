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
    if (!$row) { flash('danger', tr('Membre introuvable.')); redirect('jeunes.php'); }
}
$catDefault = (string)($_GET['cat'] ?? 'U21');
if (!isset(CSC_JEUNES_CATEGORIES[$catDefault])) $catDefault = 'U21';
$typeDefault = (int)($_GET['type'] ?? 1) === 2 ? 2 : 1;

$v = $row ?: ['categorie' => $catDefault, 'type' => $typeDefault, 'nom' => '', 'nom_ar' => '', 'num' => null,
              'poste' => $typeDefault === 2 ? 'Entraîneur' : '', 'poste_ar' => '', 'img' => '', 'publie' => 1];
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
    if ($v['nom'] === '') $errors[] = tr('Le nom est obligatoire.');
    if (!isset(CSC_JEUNES_CATEGORIES[$v['categorie']])) $errors[] = tr('Catégorie invalide.');
    if (!isset(JEUNE_TYPES[$v['type']])) $errors[] = tr('Groupe invalide.');

    $n = trim((string)($_POST['num'] ?? ''));
    if ($n === '') $v['num'] = null;
    elseif (!ctype_digit($n) || (int)$n < 1 || (int)$n > 99) $errors[] = tr('Le numéro doit être entre 1 et 99.');
    else $v['num'] = (int)$n;
    if ($v['num'] !== null && $v['type'] === 1 && $v['publie'] && !$errors) {
        $q = $pdo->prepare('SELECT nom FROM jeunes WHERE categorie = ? AND type = 1 AND num = ? AND publie = 1 AND id <> ?');
        $q->execute([$v['categorie'], $v['num'], $id]);
        if ($o = $q->fetch()) $errors[] = tr('Le numéro %1$s est déjà porté par %2$s. Masquez ou modifiez ce joueur d’abord.', $v['num'], $o['nom']);
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
            flash('success', tr('Enregistré : %s', $v['nom']));
        } else {
            $ph = implode(', ', array_fill(0, count($cols), '?'));
            $pdo->prepare('INSERT INTO jeunes (`' . implode('`, `', $cols) . "`) VALUES ($ph)")->execute($vals);
            $id = (int)$pdo->lastInsertId();
            flash('success', $v['publie'] ? tr('Ajouté : %s (visible sur le site)', $v['nom']) : tr('Ajouté : %s (masqué pour l’instant)', $v['nom']));
        }
        redirect('jeunes.php?cat=' . urlencode($v['categorie']) . '#y' . $id);
    }
}

$postes = array_unique(array_merge(JEUNE_POSTES, JEUNE_POSTES_STAFF,
          $pdo->query("SELECT DISTINCT poste FROM jeunes WHERE poste <> ''")->fetchAll(PDO::FETCH_COLUMN)));
$back = 'jeunes.php?cat=' . urlencode($v['categorie']);
page_header($row ? tr('Modifier : %s', $row['nom']) : tr('Ajouter un jeune'), $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><?= $row ? '<i class="fas fa-pen"></i> ' . e(tr('Modifier : %s', $row['nom'])) : '<i class="fas fa-plus"></i> ' . e(tr('Nouveau membre (jeunes)')) ?></h1>
  <a class="btn btn-light" href="<?= e($back) ?>"><i class="fas fa-arrow-left"></i> <?= e(tr('Retour à la liste')) ?></a>
</div>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b><?= e(tr('À corriger :')) ?></b><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="adm-form">
  <?= csrf_field() ?>
  <div class="adm-card">
    <div class="adm-img-row">
      <div class="text-center">
        <img id="imgPreview" class="adm-preview-player" src="<?= e(admin_img($v['img'] ?: 'images/player-default.png')) ?>" alt="">
      </div>
      <div style="flex:1;min-width:260px">
        <h2 class="adm-h2"><?= e(tr('Photo')) ?> <span class="text-muted small"><?= e(tr('(facultatif)')) ?></span></h2>
        <input type="file" name="img" id="imgInput" accept="image/jpeg,image/png,image/webp" class="form-control-file">
        <small class="text-muted d-block mt-1"><?= e(tr('JPG, PNG ou WEBP, max %s. La photo est recadrée automatiquement au format portrait 600×750 (comme les photos officielles), en gardant le haut de l’image.', upload_limit_label())) ?></small>
        <?php if ($v['img']): ?><label class="mt-2 small"><input type="checkbox" name="img_remove" value="1"> <?= e(tr('Retirer la photo')) ?></label><?php endif; ?>
      </div>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Identité')) ?></h2>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Nom et prénom')) ?> *</label>
        <input class="form-control" dir="ltr" name="nom" value="<?= e($v['nom']) ?>" required maxlength="150" placeholder="ex. BENALI Yacine"></div>
      <div class="form-group col-md-6" dir="rtl"><label>الاسم بالعربية</label>
        <input class="form-control" name="nom_ar" value="<?= e($v['nom_ar'] ?? '') ?>" maxlength="150" placeholder="بن علي ياسين"></div>
    </div>
    <small class="text-muted"><?= e(tr('Sans nom en arabe, la version arabe du site affiche le nom latin.')) ?></small>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Dans l’équipe')) ?></h2>
    <div class="form-row">
      <div class="form-group col-md-4"><label><?= e(tr('Catégorie')) ?> *</label>
        <select class="form-control" name="categorie">
          <?php foreach (CSC_JEUNES_CATEGORIES as $code => $_): ?>
            <option value="<?= $code ?>" <?= $v['categorie'] === $code ? 'selected' : '' ?>><?= e(jeune_cat_label($code)) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div class="form-group col-md-4"><label><?= e(tr('Groupe')) ?> *</label>
        <select class="form-control" name="type" id="type">
          <?php foreach (JEUNE_TYPES as $t => $lab): ?>
            <option value="<?= $t ?>" <?= (int)$v['type'] === $t ? 'selected' : '' ?>><?= e(tr($lab)) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div class="form-group col-md-4"><label><?= e(tr('Numéro (maillot)')) ?></label>
        <input type="number" class="form-control" name="num" min="1" max="99" value="<?= e($v['num'] ?? '') ?>"></div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Poste (en français)')) ?></label>
        <input class="form-control" dir="ltr" name="poste" list="postes" value="<?= e($v['poste']) ?>" maxlength="60">
        <datalist id="postes"><?php foreach ($postes as $p): ?><option value="<?= e($p) ?>"><?php endforeach; ?></datalist>
        <small class="text-muted"><?= e(tr('Les postes proposés dans la liste sont traduits en arabe automatiquement.')) ?></small></div>
      <div class="form-group col-md-6" dir="rtl"><label>المنصب بالعربية <small class="text-muted"><?= e(tr('(facultatif)')) ?></small></label>
        <input class="form-control" name="poste_ar" value="<?= e($v['poste_ar'] ?? '') ?>" maxlength="80"></div>
    </div>
    <small class="text-muted d-block mb-2"><?= e(tr('Le premier membre du staff est affiché comme « Entraîneur » en haut de la catégorie.')) ?></small>
    <label class="adm-switch"><input type="checkbox" name="publie" value="1" <?= $v['publie'] ? 'checked' : '' ?>> <?= e(tr('Affiché sur le site')) ?></label>
  </div>

  <div class="adm-submit">
    <button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> <?= e(tr('Enregistrer')) ?></button>
    <a class="btn btn-link" href="<?= e($back) ?>"><?= e(tr('Annuler')) ?></a>
  </div>
</form>
<script>
document.getElementById('imgInput').addEventListener('change', function () {
  if (this.files && this.files[0]) document.getElementById('imgPreview').src = URL.createObjectURL(this.files[0]);
});
</script>
<?php page_footer();
