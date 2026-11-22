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
    if (!$row) { flash('danger', 'Membre introuvable.'); redirect('feminine.php'); }
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
    if (!isset(FEM_GROUPES[$v['groupe']])) $errors[] = 'Groupe invalide.';
    // Rôle identique au rôle par défaut du groupe : inutile de le stocker
    if (isset(FEM_GROUPES[$v['groupe']]) && $v['role_fr'] === FEM_GROUPES[$v['groupe']][1] && $v['role_ar'] === '') $v['role_fr'] = '';

    $n = trim((string)($_POST['num'] ?? ''));
    if ($n === '') $v['num'] = null;
    elseif (!ctype_digit($n) || (int)$n < 1 || (int)$n > 99) $errors[] = 'Le numéro doit être entre 1 et 99.';
    else $v['num'] = (int)$n;

    // Numéro déjà porté par une autre joueuse affichée (staff non concerné)
    if ($v['num'] !== null && $v['groupe'] !== 3 && $v['publie']) {
        $q = $pdo->prepare('SELECT nom FROM equipe_feminine WHERE num = ? AND groupe IN (1, 2) AND publie = 1 AND id <> ?');
        $q->execute([$v['num'], $id]);
        if ($o = $q->fetch()) $errors[] = 'Le numéro ' . $v['num'] . ' est déjà porté par ' . fem_nom($o) . '. Masquez ou modifiez cette joueuse d’abord.';
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
    if (!$errors && !$row && empty($v['img'])) $errors[] = 'Ajoutez une photo : sur le site, chaque carte est une photo.';

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
            flash('success', 'Enregistré : ' . fem_nom($v));
        } else {
            $o = $pdo->prepare('SELECT COALESCE(MAX(ordre), 0) + 1 FROM equipe_feminine WHERE groupe = ?'); $o->execute([$v['groupe']]);
            $cols[] = 'ordre'; $vals[] = (int)$o->fetchColumn();
            $ph = implode(', ', array_fill(0, count($cols), '?'));
            $pdo->prepare('INSERT INTO equipe_feminine (`' . implode('`, `', $cols) . "`) VALUES ($ph)")->execute($vals);
            $id = (int)$pdo->lastInsertId();
            flash('success', 'Ajoutée : ' . fem_nom($v) . ($v['publie'] ? ' (visible sur le site)' : ' (masquée pour l’instant)'));
        }
        redirect('feminine.php#f' . $id);
    }
}

$roles = array_unique(array_merge(['Entraîneuse principale', 'Entraîneuse adjointe', 'Entraîneur', 'Entraîneur adjoint', 'Entraîneur des gardiennes', 'Préparatrice physique', 'Médecin', 'Kinésithérapeute', 'Intendante'],
          $pdo->query("SELECT DISTINCT role_fr FROM equipe_feminine WHERE role_fr <> ''")->fetchAll(PDO::FETCH_COLUMN)));
page_header($row ? 'Modifier une joueuse' : 'Ajouter une joueuse', $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><?= $row ? '<i class="fas fa-pen"></i> Modifier : ' . e(fem_nom($row)) : '<i class="fas fa-plus"></i> Nouveau membre (équipe féminine)' ?></h1>
  <a class="btn btn-light" href="feminine.php"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
</div>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b>À corriger :</b><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="adm-form">
  <?= csrf_field() ?>
  <div class="adm-card">
    <div class="adm-img-row">
      <div class="text-center">
        <img id="imgPreview" class="adm-preview-fem" src="<?= e(admin_img($v['img'] ?: 'images/player-default.png')) ?>" alt="">
      </div>
      <div style="flex:1;min-width:260px">
        <h2 class="adm-h2">Photo<?= $row ? '' : ' *' ?></h2>
        <input type="file" name="img" id="imgInput" accept="image/jpeg,image/png,image/webp" class="form-control-file">
        <small class="text-muted d-block mt-1">JPG, PNG ou WEBP, max <?= e(upload_limit_label()) ?>. La photo est recadrée automatiquement au format portrait 800×1200 (comme les photos actuelles de la page), en gardant le haut de l’image.</small>
        <?php if ($row && $v['img']): ?><label class="mt-2 small"><input type="checkbox" name="img_remove" value="1"> Retirer la photo</label><?php endif; ?>
      </div>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2">Identité <span class="text-muted small">(facultatif : vide = rien d’affiché sur la carte)</span></h2>
    <div class="form-row">
      <div class="form-group col-md-6"><label>Nom et prénom</label>
        <input class="form-control" name="nom" value="<?= e($v['nom']) ?>" maxlength="150" placeholder="ex. Amina BENALI"></div>
      <div class="form-group col-md-6" dir="rtl"><label>الاسم بالعربية</label>
        <input class="form-control" name="nom_ar" value="<?= e($v['nom_ar'] ?? '') ?>" maxlength="150" placeholder="أمينة بن علي"></div>
    </div>
    <small class="text-muted">Sans nom en arabe, la version arabe du site affiche le nom latin.</small>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2">Dans l’équipe</h2>
    <div class="form-row">
      <div class="form-group col-md-4"><label>Groupe *</label>
        <select class="form-control" name="groupe">
          <?php foreach (FEM_GROUPES as $g => [$lab]): ?>
            <option value="<?= $g ?>" <?= (int)$v['groupe'] === $g ? 'selected' : '' ?>><?= e($lab) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div class="form-group col-md-3"><label>Numéro (maillot)</label>
        <input type="number" class="form-control" name="num" min="1" max="99" value="<?= e($v['num'] ?? '') ?>"></div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6"><label>Rôle affiché <small class="text-muted">(facultatif)</small></label>
        <input class="form-control" name="role_fr" list="roles" value="<?= e($v['role_fr']) ?>" maxlength="80" placeholder="Vide = Gardienne / Joueuse / Staff">
        <datalist id="roles"><?php foreach ($roles as $p): ?><option value="<?= e($p) ?>"><?php endforeach; ?></datalist>
        <small class="text-muted">Utile surtout pour le staff (ex. Entraîneuse principale).</small></div>
      <div class="form-group col-md-6" dir="rtl"><label>الدور بالعربية</label>
        <input class="form-control" name="role_ar" value="<?= e($v['role_ar'] ?? '') ?>" maxlength="80" placeholder="مثال : المدربة الرئيسية"></div>
    </div>
    <label class="adm-switch"><input type="checkbox" name="publie" value="1" <?= $v['publie'] ? 'checked' : '' ?>> Affichée sur le site</label>
  </div>

  <div class="adm-submit">
    <button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> Enregistrer</button>
    <a class="btn btn-link" href="feminine.php">Annuler</a>
  </div>
</form>
<script>
document.getElementById('imgInput').addEventListener('change', function () {
  if (this.files && this.files[0]) document.getElementById('imgPreview').src = URL.createObjectURL(this.files[0]);
});
</script>
<?php page_footer();
