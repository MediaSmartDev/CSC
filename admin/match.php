<?php
/* Ajouter (match.php) ou modifier (match.php?id=...) un match du CSC */
require __DIR__ . '/inc/bootstrap.php';
$admin = require_login();
$pdo = db();
$CLUBS = require __DIR__ . '/../Data/clubs.php';

$id = (int)($_GET['id'] ?? 0);
$row = null;
if ($id) {
    $st = $pdo->prepare('SELECT * FROM matchs_csc WHERE id = ?'); $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) { flash('danger', tr('Match introuvable.')); redirect('matchs.php'); }
}
$nextJ = (int)$pdo->query('SELECT COALESCE(MAX(j), 0) + 1 FROM matchs_csc')->fetchColumn();
$v = $row ?: ['j' => $nextJ, 'dom' => 'CSC', 'ext' => '', 'date_match' => '', 'heure' => '', 'bd' => null, 'be' => null,
              'stade_fr' => '', 'stade_ar' => '', 'slogan_fr' => '', 'slogan_ar' => '', 'actu' => null];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $t = fn($k, $max) => mb_substr(trim((string)($_POST[$k] ?? '')), 0, $max);
    $v['j'] = $t('j', 3);
    if (!preg_match('/^\d{1,2}$/', $v['j']) || (int)$v['j'] < 1) $errors[] = tr('Numéro de journée invalide.');
    $v['dom'] = (string)($_POST['dom'] ?? ''); $v['ext'] = (string)($_POST['ext'] ?? '');
    if (!isset($CLUBS[$v['dom']]) || !isset($CLUBS[$v['ext']])) $errors[] = tr('Choisissez les deux équipes.');
    elseif ($v['dom'] === $v['ext']) $errors[] = tr('Les deux équipes doivent être différentes.');
    elseif ($v['dom'] !== 'CSC' && $v['ext'] !== 'CSC') $errors[] = tr('Le CSC doit être l’une des deux équipes.');

    $d = $t('date_match', 10);
    $dt = DateTime::createFromFormat('!Y-m-d', $d);
    if ($d !== '' && (!$dt || $dt->format('Y-m-d') !== $d)) $errors[] = tr('Date invalide.');
    $v['date_match'] = $d === '' ? null : $d;
    $h = $t('heure', 5);
    if ($h !== '' && !preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $h)) $errors[] = tr('Heure invalide (HH:MM).');
    $v['heure'] = $h === '' ? null : $h;

    $bd = $t('bd', 2); $be = $t('be', 2);
    if (($bd === '') !== ($be === '')) $errors[] = tr('Mettez les deux scores, ou laissez les deux vides si le match n’est pas encore joué.');
    elseif ($bd !== '' && (!ctype_digit($bd) || !ctype_digit($be))) $errors[] = tr('Score invalide.');
    $v['bd'] = $bd === '' ? null : (int)$bd; $v['be'] = $be === '' ? null : (int)$be;

    foreach (['stade_fr' => 150, 'stade_ar' => 150, 'slogan_fr' => 300, 'slogan_ar' => 300] as $k => $max) $v[$k] = $t($k, $max);
    $a = (int)($_POST['actu'] ?? 0);
    $v['actu'] = $a > 0 ? $a : null;

    if (!$errors) {
        $cols = ['j', 'dom', 'ext', 'date_match', 'heure', 'bd', 'be', 'stade_fr', 'stade_ar', 'slogan_fr', 'slogan_ar', 'actu'];
        $vals = array_map(fn($c) => $v[$c], $cols);
        $vals[0] = (int)$vals[0];
        if ($row) {
            $set = implode(', ', array_map(fn($c) => "`$c` = ?", $cols));
            $pdo->prepare("UPDATE matchs_csc SET $set WHERE id = ?")->execute([...$vals, $id]);
            flash('success', tr('Match enregistré.'));
        } else {
            $ph = implode(', ', array_fill(0, count($cols), '?'));
            $pdo->prepare('INSERT INTO matchs_csc (`' . implode('`, `', $cols) . "`) VALUES ($ph)")->execute($vals);
            flash('success', tr('Match ajouté.'));
        }
        redirect('matchs.php');
    }
}

try { $actus = $pdo->query('SELECT id, titre_fr, date_pub FROM actualites ORDER BY position DESC, id DESC LIMIT 40')->fetchAll(); }
catch (PDOException $e) { $actus = []; }
page_header($row ? tr('Modifier un match') : tr('Ajouter un match'), $admin);
$clubOptions = function ($sel) use ($CLUBS) {
    $o = '<option value="">' . e(tr('— choisir —')) . '</option>';
    foreach ($CLUBS as $c => $i) $o .= '<option value="' . e($c) . '"' . ($c === $sel ? ' selected' : '') . '>' . e(admin_lang() === 'ar' ? $i['ar'] : $i['nom_fr']) . '</option>';
    return $o;
};
?>
<div class="adm-head">
  <h1 class="adm-h1"><?= $row ? '<i class="fas fa-pen"></i> ' . e(tr('Modifier le match')) : '<i class="fas fa-plus"></i> ' . e(tr('Nouveau match')) ?></h1>
  <a class="btn btn-light" href="matchs.php"><i class="fas fa-arrow-left"></i> <?= e(tr('Retour à la liste')) ?></a>
</div>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b><?= e(tr('À corriger :')) ?></b><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" class="adm-form">
  <?= csrf_field() ?>
  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Le match')) ?></h2>
    <div class="form-row">
      <div class="form-group col-md-2"><label><?= e(tr('Journée')) ?> *</label>
        <input type="number" class="form-control" name="j" min="1" max="99" value="<?= e($v['j']) ?>" required></div>
      <div class="form-group col-md-5"><label><?= e(tr('À domicile')) ?> *</label>
        <select class="form-control" name="dom" id="dom" required><?= $clubOptions($v['dom']) ?></select></div>
      <div class="form-group col-md-5"><label><?= e(tr('À l’extérieur')) ?> *</label>
        <select class="form-control" name="ext" id="ext" required><?= $clubOptions($v['ext']) ?></select></div>
    </div>
    <button type="button" class="btn btn-sm btn-light mb-3" id="swap"><i class="fas fa-exchange-alt"></i> <?= e(tr('Inverser domicile / extérieur')) ?></button>
    <div class="form-row">
      <div class="form-group col-md-4"><label><?= e(tr('Date')) ?></label>
        <input type="date" class="form-control" name="date_match" value="<?= e($v['date_match'] ?? '') ?>">
        <small class="text-muted"><?= e(tr('Vide = « Date à confirmer ».')) ?></small></div>
      <div class="form-group col-md-3"><label><?= e(tr('Heure')) ?></label>
        <input type="time" class="form-control" name="heure" value="<?= e($v['heure'] ? substr($v['heure'], 0, 5) : '') ?>"></div>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Score')) ?> <span class="text-muted small"><?= e(tr('(laisser vide tant que le match n’est pas joué)')) ?></span></h2>
    <div class="d-flex align-items-center" style="gap:12px">
      <input type="number" class="form-control" style="width:90px" name="bd" min="0" max="99" value="<?= $v['bd'] === null ? '' : (int)$v['bd'] ?>" id="bd">
      <b>-</b>
      <input type="number" class="form-control" style="width:90px" name="be" min="0" max="99" value="<?= $v['be'] === null ? '' : (int)$v['be'] ?>" id="be">
      <span class="small text-muted" id="scoreLabel"></span>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Stade')) ?> <span class="text-muted small"><?= e(tr('(facultatif)')) ?></span></h2>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Stade (FR)')) ?></label>
        <input class="form-control" dir="ltr" name="stade_fr" value="<?= e($v['stade_fr']) ?>" maxlength="150" placeholder="<?= e(tr('ex. Stade Amar Hamam, Khenchela')) ?>"></div>
      <div class="form-group col-md-6" dir="rtl"><label>الملعب (AR)</label>
        <input class="form-control" name="stade_ar" value="<?= e($v['stade_ar']) ?>" maxlength="150"></div>
    </div>
    <small class="text-muted"><?= e(tr('Vide : « Stade Chahid Hamlaoui, Constantine » à domicile, la ville de l’adversaire à l’extérieur (traduits automatiquement).')) ?>
    <?= e(tr('Si seul le français est rempli, la version arabe du site affiche le texte français.')) ?></small>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Quand c’est le prochain match')) ?> <span class="text-muted small"><?= e(tr('(facultatif, carte en grand)')) ?></span></h2>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Phrase (FR)')) ?></label>
        <input class="form-control" dir="ltr" name="slogan_fr" value="<?= e($v['slogan_fr']) ?>" maxlength="300" placeholder="Dans le silence du tunnel..."></div>
      <div class="form-group col-md-6" dir="rtl"><label>العبارة (AR)</label>
        <input class="form-control" name="slogan_ar" value="<?= e($v['slogan_ar']) ?>" maxlength="300"></div>
    </div>
    <div class="form-group"><label><?= e(tr('Affiche : actualité liée (« Voir l’affiche »)')) ?></label>
      <select class="form-control" name="actu">
        <option value=""><?= e(tr('— aucune —')) ?></option>
        <?php foreach ($actus as $a): ?><option value="<?= (int)$a['id'] ?>" <?= (int)$v['actu'] === (int)$a['id'] ? 'selected' : '' ?>><?= e(($a['date_pub'] ? date('d/m', strtotime($a['date_pub'])) . ' · ' : '') . $a['titre_fr']) ?></option><?php endforeach; ?>
      </select></div>
  </div>

  <div class="adm-submit">
    <button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> <?= e(tr('Enregistrer')) ?></button>
    <a class="btn btn-link" href="matchs.php"><?= e(tr('Annuler')) ?></a>
  </div>
</form>
<script>
(function () {
  var dom = document.getElementById('dom'), ext = document.getElementById('ext');
  function label() {
    var a = dom.selectedOptions[0], b = ext.selectedOptions[0];
    document.getElementById('scoreLabel').textContent = (a && a.value ? a.text : '?') + '  –  ' + (b && b.value ? b.text : '?');
  }
  document.getElementById('swap').addEventListener('click', function () { var t = dom.value; dom.value = ext.value; ext.value = t; label(); });
  dom.addEventListener('change', label); ext.addEventListener('change', label); label();
})();
</script>
<?php page_footer();
