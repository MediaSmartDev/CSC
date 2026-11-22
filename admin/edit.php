<?php
/* Ajouter (edit.php) ou modifier (edit.php?id=...) une actualité */
require __DIR__ . '/inc/bootstrap.php';
$admin = require_login();
$pdo = db();

$id = (int)($_GET['id'] ?? 0);
$row = null;
if ($id) {
    $st = $pdo->prepare('SELECT * FROM actualites WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) { flash('danger', tr('Actualité introuvable.')); redirect('index.php'); }
}

$TEXT = ['label_fr' => 120, 'label_ar' => 120, 'titre_fr' => 255, 'titre_ar' => 255, 'resume_fr' => 2000, 'resume_ar' => 2000,
         'contenu_fr' => 60000, 'contenu_ar' => 60000, 'bouton_fr' => 120, 'bouton_ar' => 120];
$v = $row ?: array_fill_keys(array_keys($TEXT), '') + ['date_pub' => date('Y-m-d'), 'image' => '', 'tags' => '#TheDean1898 #DimaCsc',
                                                        'galerie' => '', 'bouton_lien' => '', 'publie' => 1];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($TEXT as $k => $max) {
        $s = str_replace("\r\n", "\n", trim((string)($_POST[$k] ?? '')));
        if (mb_strlen($s) > $max) $errors[] = tr('Le champ « %1$s » est trop long (max %2$s caractères).', $k, $max);
        $v[$k] = $s;
    }
    if ($v['titre_fr'] === '') $errors[] = tr('Le titre en français est obligatoire.');
    if ($v['resume_fr'] === '') $errors[] = tr('Le résumé en français est obligatoire.');

    $d = trim((string)($_POST['date_pub'] ?? ''));
    $dt = DateTime::createFromFormat('!Y-m-d', $d);
    if ($d !== '' && (!$dt || $dt->format('Y-m-d') !== $d)) $errors[] = tr('Date invalide.');
    $v['date_pub'] = $d === '' ? null : $d;

    // Hashtags : "#TheDean1898 #DimaCsc" (le # est ajouté si oublié)
    $tags = [];
    foreach (preg_split('/[\s,]+/u', (string)($_POST['tags'] ?? ''), -1, PREG_SPLIT_NO_EMPTY) as $t) {
        $t = '#' . ltrim($t, '#');
        if (preg_match('/^#[\p{L}\p{N}_]{1,40}$/u', $t)) $tags[] = $t;
    }
    $v['tags'] = implode(' ', array_slice(array_unique($tags), 0, 10));

    $lien = trim((string)($_POST['bouton_lien'] ?? ''));
    if ($lien !== '' && !preg_match('#^(https?://[^\s<>"]+|[A-Za-z0-9_./?=&%\#-]+)$#', $lien)) $errors[] = tr('Lien du bouton invalide (il doit commencer par https://).');
    if (preg_match('#^[a-z]+:#i', $lien) && !preg_match('#^https?://#i', $lien)) $errors[] = tr('Lien du bouton invalide.');
    $v['bouton_lien'] = $lien;
    $v['publie'] = isset($_POST['publie']) ? 1 : 0;

    // Galerie : on garde les photos non cochées "retirer"
    $oldGal = array_values(array_filter(array_map('trim', preg_split('/\R/', (string)($row['galerie'] ?? '')))));
    $remove = array_map('strval', (array)($_POST['gal_remove'] ?? []));
    $gal = array_values(array_filter($oldGal, fn($g) => !in_array($g, $remove, true)));

    $newFiles = [];
    $oldImage = $row['image'] ?? '';
    if (!$errors) {
        try {
            if (!empty($_FILES['image'])) {
                $img = save_uploaded_image($_FILES['image']);
                if ($img) { $newFiles[] = $img; $v['image'] = $img; }
            }
            foreach (array_slice(files_list('galerie_new'), 0, 15) as $f) {
                $g = save_uploaded_image($f);
                if ($g) { $newFiles[] = $g; $gal[] = $g; }
            }
        } catch (RuntimeException $ex) {
            $errors[] = $ex->getMessage();
            foreach ($newFiles as $nf) @unlink(dirname(__DIR__) . '/' . $nf);
            $v['image'] = $oldImage;
        }
    }
    if (isset($_POST['image_remove']) && empty($img ?? null)) $v['image'] = '';
    $v['galerie'] = implode("\n", $gal);

    if (!$errors) {
        $cols = array_keys($TEXT);
        $data = array_map(fn($k) => $v[$k], $cols);
        $extra = ['date_pub' => $v['date_pub'], 'image' => $v['image'], 'tags' => $v['tags'], 'galerie' => $v['galerie'],
                  'bouton_lien' => $v['bouton_lien'], 'publie' => $v['publie']];
        $allCols = array_merge($cols, array_keys($extra));
        $allVals = array_merge($data, array_values($extra));
        if ($row) {
            $set = implode(', ', array_map(fn($c) => "`$c` = ?", $allCols));
            $pdo->prepare("UPDATE actualites SET $set WHERE id = ?")->execute([...$allVals, $id]);
            // Anciennes images remplacées / retirées
            if ($oldImage !== $v['image']) delete_uploaded_image($oldImage);
            foreach (array_diff($oldGal, $gal) as $g) delete_uploaded_image($g);
            flash('success', tr('Actualité enregistrée.'));
        } else {
            $pos = (int)$pdo->query('SELECT COALESCE(MAX(position), 0) + 1 FROM actualites')->fetchColumn();
            $allCols[] = 'position'; $allVals[] = $pos;
            $ph = implode(', ', array_fill(0, count($allCols), '?'));
            $pdo->prepare('INSERT INTO actualites (`' . implode('`, `', $allCols) . "`) VALUES ($ph)")->execute($allVals);
            $id = (int)$pdo->lastInsertId();
            flash('success', $v['publie'] ? tr('Actualité ajoutée et publiée en tête du site.') : tr('Actualité ajoutée (masquée pour l’instant).'));
        }
        redirect('index.php#n' . $id);
    }
}

$labels = $pdo->query("SELECT label_fr, MAX(label_ar) AS label_ar FROM actualites WHERE label_fr <> '' GROUP BY label_fr ORDER BY COUNT(*) DESC LIMIT 20")->fetchAll();
$galList = array_values(array_filter(array_map('trim', preg_split('/\R/', (string)$v['galerie']))));
page_header($row ? tr('Modifier l’actualité') : tr('Nouvelle actualité'), $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><?= $row ? '<i class="fas fa-pen"></i> ' . e(tr('Modifier l’actualité')) : '<i class="fas fa-plus"></i> ' . e(tr('Nouvelle actualité')) ?></h1>
  <a class="btn btn-light" href="index.php"><i class="fas fa-arrow-left"></i> <?= e(tr('Retour à la liste')) ?></a>
</div>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b><?= e(tr('À corriger :')) ?></b><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="adm-form">
  <?= csrf_field() ?>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Image principale')) ?></h2>
    <div class="adm-img-row">
      <img id="imgPreview" class="adm-preview" src="<?= e(admin_img($v['image'])) ?>" alt="">
      <div>
        <input type="file" name="image" id="imgInput" accept="image/jpeg,image/png,image/webp" class="form-control-file">
        <small class="text-muted d-block mt-1"><?= e(tr('JPG, PNG ou WEBP, max %s. Les grandes images sont réduites automatiquement.', upload_limit_label())) ?></small>
        <?php if ($v['image']): ?>
          <label class="mt-2 small"><input type="checkbox" name="image_remove" value="1"> <?= e(tr('Retirer l’image (l’image par défaut du club sera affichée)')) ?></label>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Informations')) ?></h2>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label><?= e(tr('Date')) ?></label>
        <input type="date" class="form-control" name="date_pub" value="<?= e($v['date_pub'] ?? '') ?>">
        <small class="text-muted"><?= e(tr('Laisser vide pour ne pas afficher de date.')) ?></small>
      </div>
      <div class="form-group col-md-8">
        <label><?= e(tr('Hashtags')) ?></label>
        <input class="form-control" name="tags" value="<?= e($v['tags']) ?>" placeholder="#TheDean1898 #DimaCsc">
        <small class="text-muted"><?= e(tr('Séparés par des espaces.')) ?></small>
      </div>
    </div>
    <label class="adm-switch"><input type="checkbox" name="publie" value="1" <?= $v['publie'] ? 'checked' : '' ?>> <?= e(tr('Publiée sur le site')) ?></label>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Texte')) ?> <span class="text-muted small"><?= e(tr('en français et en arabe')) ?></span></h2>
    <div class="row">
      <div class="col-md-6" dir="ltr">
        <div class="adm-lang">🇫🇷 Français</div>
        <div class="form-group"><label><?= e(tr('Étiquette')) ?> <small class="text-muted"><?= e(tr('(ex. ⚽ Résultat)')) ?></small></label>
          <input class="form-control" name="label_fr" id="label_fr" list="labelsFr" value="<?= e($v['label_fr']) ?>" maxlength="120"></div>
        <div class="form-group"><label><?= e(tr('Titre')) ?> *</label>
          <input class="form-control" name="titre_fr" value="<?= e($v['titre_fr']) ?>" required maxlength="255"></div>
        <div class="form-group"><label><?= e(tr('Résumé')) ?> * <small class="text-muted"><?= e(tr('(affiché sur la carte de l’accueil)')) ?></small></label>
          <textarea class="form-control" name="resume_fr" rows="3" required maxlength="2000"><?= e($v['resume_fr']) ?></textarea></div>
        <div class="form-group"><label><?= e(tr('Article complet')) ?> <small class="text-muted"><?= e(tr('(un paragraphe par ligne ; vide = le résumé)')) ?></small></label>
          <textarea class="form-control" name="contenu_fr" rows="9"><?= e($v['contenu_fr']) ?></textarea></div>
      </div>
      <div class="col-md-6" dir="rtl">
        <div class="adm-lang">🇩🇿 العربية</div>
        <div class="form-group"><label>التصنيف</label>
          <input class="form-control" name="label_ar" id="label_ar" value="<?= e($v['label_ar']) ?>" maxlength="120"></div>
        <div class="form-group"><label>العنوان</label>
          <input class="form-control" name="titre_ar" value="<?= e($v['titre_ar']) ?>" maxlength="255"></div>
        <div class="form-group"><label>الملخص</label>
          <textarea class="form-control" name="resume_ar" rows="3" maxlength="2000"><?= e($v['resume_ar']) ?></textarea></div>
        <div class="form-group"><label>النص الكامل</label>
          <textarea class="form-control" name="contenu_ar" rows="9"><?= e($v['contenu_ar']) ?></textarea></div>
      </div>
    </div>
    <small class="text-muted"><?= e(tr('Si un champ arabe est vide, le site affiche le texte français à la place.')) ?></small>
    <datalist id="labelsFr"><?php foreach ($labels as $l): ?><option value="<?= e($l['label_fr']) ?>" data-ar="<?= e($l['label_ar']) ?>"><?php endforeach; ?></datalist>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Galerie photos')) ?> <span class="text-muted small"><?= e(tr('(facultatif : affichée sous l’article à partir de 2 photos)')) ?></span></h2>
    <?php if ($galList): ?>
      <div class="adm-gal">
        <?php foreach ($galList as $g): ?>
          <label class="adm-gal-item"><img src="<?= e(admin_img($g)) ?>" alt="" loading="lazy">
            <span><input type="checkbox" name="gal_remove[]" value="<?= e($g) ?>"> <?= e(tr('retirer')) ?></span></label>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <input type="file" name="galerie_new[]" multiple accept="image/jpeg,image/png,image/webp" class="form-control-file">
    <small class="text-muted"><?= e(tr('Vous pouvez choisir plusieurs photos à la fois (15 max par envoi).')) ?></small>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Bouton')) ?> <span class="text-muted small"><?= e(tr('(facultatif, ex. billetterie)')) ?></span></h2>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Lien')) ?></label>
        <input class="form-control" name="bouton_lien" value="<?= e($v['bouton_lien']) ?>" placeholder="https://..."></div>
      <div class="form-group col-md-3"><label><?= e(tr('Texte (FR)')) ?></label>
        <input class="form-control" name="bouton_fr" value="<?= e($v['bouton_fr']) ?>" placeholder="Acheter un billet"></div>
      <div class="form-group col-md-3" dir="rtl"><label>النص (AR)</label>
        <input class="form-control" name="bouton_ar" value="<?= e($v['bouton_ar']) ?>"></div>
    </div>
    <small class="text-muted"><?= e(tr('Laisser le lien vide pour ne pas afficher de bouton.')) ?></small>
  </div>

  <div class="adm-submit">
    <button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> <?= e(tr('Enregistrer')) ?></button>
    <a class="btn btn-link" href="index.php"><?= e(tr('Annuler')) ?></a>
  </div>
</form>

<script>
// Aperçu de l'image choisie
document.getElementById('imgInput').addEventListener('change', function () {
  if (this.files && this.files[0]) document.getElementById('imgPreview').src = URL.createObjectURL(this.files[0]);
});
// Étiquette déjà utilisée : remplit l'arabe automatiquement
document.getElementById('label_fr').addEventListener('change', function () {
  var o = document.querySelector('#labelsFr option[value="' + CSS.escape(this.value) + '"]');
  var ar = document.getElementById('label_ar');
  if (o && o.dataset.ar && !ar.value) ar.value = o.dataset.ar;
});
</script>
<?php page_footer();
