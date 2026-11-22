<?php
/* Ajouter (joueur.php) ou modifier (joueur.php?id=...) un joueur / membre du staff */
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/joueurs_common.php';
$admin = require_login();
$pdo = db();

$id = (int)($_GET['id'] ?? 0);
$row = null;
if ($id) {
    $st = $pdo->prepare('SELECT * FROM joueurs WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) { flash('danger', 'Joueur introuvable.'); redirect('joueurs.php'); }
}
$catDefault = (int)($_GET['categorie'] ?? 1);
if (!isset(JOUEUR_CATEGORIES[$catDefault])) $catDefault = 1;

$v = $row ?: ['nom' => '', 'prenom' => '', 'nom_ar' => '', 'dossard' => '', 'categorie' => $catDefault,
              'poste' => JOUEUR_CATEGORIES[$catDefault][1], 'date_naissance' => '', 'age' => '',
              'nationalite' => 'Algérie', 'img' => '', 'published' => 1];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $txt = fn($k, $max) => mb_substr(trim(preg_replace('/\s+/u', ' ', (string)($_POST[$k] ?? ''))), 0, $max);
    $v['nom'] = $txt('nom', 100);
    $v['prenom'] = $txt('prenom', 100);
    $v['nom_ar'] = $txt('nom_ar', 150);
    $v['poste'] = $txt('poste', 50);
    $v['nationalite'] = $txt('nationalite', 50) ?: 'Algérie';
    $v['categorie'] = (int)($_POST['categorie'] ?? 0);
    $v['published'] = isset($_POST['published']) ? 1 : 0;
    if ($v['nom'] === '') $errors[] = 'Le nom est obligatoire.';
    if (!isset(JOUEUR_CATEGORIES[$v['categorie']])) $errors[] = 'Catégorie invalide.';
    if ($v['poste'] === '' && isset(JOUEUR_CATEGORIES[$v['categorie']])) $v['poste'] = JOUEUR_CATEGORIES[$v['categorie']][1];

    $d = trim((string)($_POST['dossard'] ?? ''));
    if ($d === '') $v['dossard'] = null;
    elseif (!ctype_digit($d) || (int)$d < 1 || (int)$d > 99) $errors[] = 'Le numéro doit être entre 1 et 99.';
    else $v['dossard'] = (int)$d;

    // Numéro déjà pris par un autre joueur affiché (staff non concerné)
    if ($v['dossard'] !== null && $v['categorie'] !== 5 && $v['published']) {
        $q = $pdo->prepare('SELECT nom, prenom FROM joueurs WHERE dossard = ? AND categorie BETWEEN 1 AND 4 AND published = 1 AND id <> ?');
        $q->execute([$v['dossard'], $id]);
        if ($o = $q->fetch()) $errors[] = 'Le numéro ' . $v['dossard'] . ' est déjà porté par ' . joueur_nom($o) . '. Masquez ou modifiez ce joueur d’abord.';
    }

    $dn = trim((string)($_POST['date_naissance'] ?? ''));
    $dt = DateTime::createFromFormat('!Y-m-d', $dn);
    if ($dn !== '' && (!$dt || $dt->format('Y-m-d') !== $dn || $dt > new DateTime() || (int)$dt->format('Y') < 1940)) $errors[] = 'Date de naissance invalide.';
    $v['date_naissance'] = $dn === '' ? null : $dn;
    $a = trim((string)($_POST['age'] ?? ''));
    if ($a !== '' && (!ctype_digit($a) || (int)$a < 10 || (int)$a > 90)) $errors[] = 'Âge invalide.';
    $v['age'] = $a === '' ? null : (int)$a;

    $oldImg = $row['img'] ?? '';
    if (!$errors) {
        try {
            $img = !empty($_FILES['img']) ? save_uploaded_image($_FILES['img'], ADMIN_UPLOAD_JOUEURS, JOUEUR_PHOTO_SIZE) : null;
            if ($img) $v['img'] = $img;
            elseif (isset($_POST['img_remove'])) $v['img'] = null;
        } catch (RuntimeException $ex) {
            $errors[] = $ex->getMessage();
        }
    }

    if (!$errors) {
        $cols = ['nom', 'prenom', 'nom_ar', 'dossard', 'poste', 'categorie', 'date_naissance', 'age', 'nationalite', 'img', 'published'];
        $vals = array_map(fn($c) => $v[$c] === '' && in_array($c, ['nom_ar', 'img'], true) ? null : $v[$c], $cols);
        if ($row) {
            if ((int)$row['categorie'] !== $v['categorie']) {        // changement de catégorie : à la fin de la nouvelle
                $cols[] = 'ordre';
                $o = $pdo->prepare('SELECT COALESCE(MAX(ordre), 0) + 1 FROM joueurs WHERE categorie = ?'); $o->execute([$v['categorie']]);
                $vals[] = (int)$o->fetchColumn();
            }
            $set = implode(', ', array_map(fn($c) => "`$c` = ?", $cols));
            $pdo->prepare("UPDATE joueurs SET $set WHERE id = ?")->execute([...$vals, $id]);
            if ($oldImg !== ($v['img'] ?? '')) delete_uploaded_image($oldImg);
            flash('success', 'Enregistré : ' . joueur_nom($v));
        } else {
            $o = $pdo->prepare('SELECT COALESCE(MAX(ordre), 0) + 1 FROM joueurs WHERE categorie = ?'); $o->execute([$v['categorie']]);
            $cols[] = 'ordre'; $vals[] = (int)$o->fetchColumn();
            $ph = implode(', ', array_fill(0, count($cols), '?'));
            $pdo->prepare('INSERT INTO joueurs (`' . implode('`, `', $cols) . "`) VALUES ($ph)")->execute($vals);
            $id = (int)$pdo->lastInsertId();
            flash('success', 'Ajouté : ' . joueur_nom($v) . ($v['published'] ? ' (visible sur le site)' : ' (masqué pour l’instant)'));
        }
        redirect('joueurs.php#j' . $id);
    }
}

$nats = $pdo->query("SELECT DISTINCT nationalite FROM joueurs WHERE nationalite <> '' ORDER BY nationalite")->fetchAll(PDO::FETCH_COLUMN);
$postes = array_unique(array_merge(array_column(JOUEUR_CATEGORIES, 1),
          ['Entraîneur adjoint', 'Entraîneur des gardiens', 'Préparateur physique', 'Directeur technique', 'Médecin', 'Kinésithérapeute', 'Analyste vidéo', 'Intendant'],
          $pdo->query("SELECT DISTINCT poste FROM joueurs WHERE poste <> ''")->fetchAll(PDO::FETCH_COLUMN)));
page_header($row ? 'Modifier un joueur' : 'Ajouter un joueur', $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><?= $row ? '<i class="fas fa-pen"></i> Modifier : ' . e(joueur_nom($row)) : '<i class="fas fa-plus"></i> Nouveau joueur' ?></h1>
  <a class="btn btn-light" href="joueurs.php"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
</div>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b>À corriger :</b><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="adm-form">
  <?= csrf_field() ?>
  <div class="adm-card">
    <div class="adm-img-row">
      <div class="text-center">
        <img id="imgPreview" class="adm-preview-player" src="<?= e(admin_img($v['img'] ?: 'images/player-default.png')) ?>" alt="">
      </div>
      <div style="flex:1;min-width:260px">
        <h2 class="adm-h2">Photo</h2>
        <input type="file" name="img" id="imgInput" accept="image/jpeg,image/png,image/webp" class="form-control-file">
        <small class="text-muted d-block mt-1">JPG, PNG ou WEBP, max <?= e(upload_limit_label()) ?>. La photo est recadrée automatiquement au format portrait 600×750 (comme les photos officielles), en gardant le haut de l’image.</small>
        <?php if ($v['img']): ?><label class="mt-2 small"><input type="checkbox" name="img_remove" value="1"> Retirer la photo</label><?php endif; ?>
      </div>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2">Identité</h2>
    <div class="form-row">
      <div class="form-group col-md-5"><label>Nom * <small class="text-muted">(en lettres latines)</small></label>
        <input class="form-control" name="nom" value="<?= e($v['nom']) ?>" required maxlength="100" placeholder="ex. BAKIR Mohamed Islam"></div>
      <div class="form-group col-md-3"><label>Prénom <small class="text-muted">(facultatif)</small></label>
        <input class="form-control" name="prenom" value="<?= e($v['prenom']) ?>" maxlength="100"></div>
      <div class="form-group col-md-4" dir="rtl"><label>الاسم بالعربية</label>
        <input class="form-control" name="nom_ar" value="<?= e($v['nom_ar'] ?? '') ?>" maxlength="150" placeholder="بكير محمد إسلام"></div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3"><label>Nationalité</label>
        <input class="form-control" name="nationalite" list="nats" value="<?= e($v['nationalite']) ?>" maxlength="50">
        <datalist id="nats"><?php foreach ($nats as $n): ?><option value="<?= e($n) ?>"><?php endforeach; ?></datalist></div>
      <div class="form-group col-md-3"><label>Date de naissance</label>
        <input type="date" class="form-control" name="date_naissance" value="<?= e($v['date_naissance'] ?? '') ?>"></div>
      <div class="form-group col-md-2"><label>ou âge</label>
        <input type="number" class="form-control" name="age" min="10" max="90" value="<?= e($v['age'] ?? '') ?>"></div>
      <div class="col-md-4 small text-muted d-flex align-items-center">Avec la date de naissance, l’âge se met à jour tout seul chaque année.</div>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2">Dans l’équipe</h2>
    <div class="form-row">
      <div class="form-group col-md-4"><label>Catégorie *</label>
        <select class="form-control" name="categorie" id="cat">
          <?php foreach (JOUEUR_CATEGORIES as $c => [$lab, $poste]): ?>
            <option value="<?= $c ?>" data-poste="<?= e($poste) ?>" <?= (int)$v['categorie'] === $c ? 'selected' : '' ?>><?= e($lab) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div class="form-group col-md-5"><label>Poste</label>
        <input class="form-control" name="poste" id="poste" list="postes" value="<?= e($v['poste']) ?>" maxlength="50">
        <datalist id="postes"><?php foreach ($postes as $p): ?><option value="<?= e($p) ?>"><?php endforeach; ?></datalist>
        <small class="text-muted">Gardien, Défenseur, Milieu, Attaquant et Entraîneur sont traduits en arabe automatiquement.</small></div>
      <div class="form-group col-md-3"><label>Numéro (maillot)</label>
        <input type="number" class="form-control" name="dossard" min="1" max="99" value="<?= e($v['dossard'] ?? '') ?>"></div>
    </div>
    <label class="adm-switch"><input type="checkbox" name="published" value="1" <?= $v['published'] ? 'checked' : '' ?>> Affiché sur le site</label>
  </div>

  <div class="adm-submit">
    <button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> Enregistrer</button>
    <a class="btn btn-link" href="joueurs.php">Annuler</a>
  </div>
</form>
<script>
document.getElementById('imgInput').addEventListener('change', function () {
  if (this.files && this.files[0]) document.getElementById('imgPreview').src = URL.createObjectURL(this.files[0]);
});
// Changer de catégorie propose le poste correspondant
var cat = document.getElementById('cat'), poste = document.getElementById('poste');
var defaults = Array.from(cat.options).map(function (o) { return o.dataset.poste; });
cat.addEventListener('change', function () {
  if (poste.value === '' || defaults.indexOf(poste.value) !== -1) poste.value = cat.options[cat.selectedIndex].dataset.poste;
});
</script>
<?php page_footer();
