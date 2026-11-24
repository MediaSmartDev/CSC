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
    if (!$row) { flash('danger', tr('Match not found.')); redirect('matchs.php'); }
}
$nextJ = (int)$pdo->query('SELECT COALESCE(MAX(j), 0) + 1 FROM matchs_csc')->fetchColumn();
$v = $row ?: ['j' => $nextJ, 'dom' => 'CSC', 'ext' => '', 'date_match' => '', 'heure' => '', 'bd' => null, 'be' => null,
              'stade_fr' => '', 'stade_ar' => '', 'slogan_fr' => '', 'slogan_ar' => '', 'actu' => null];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $t = fn($k, $max) => mb_substr(trim((string)($_POST[$k] ?? '')), 0, $max);
    $v['j'] = $t('j', 3);
    if (!preg_match('/^\d{1,2}$/', $v['j']) || (int)$v['j'] < 1) $errors[] = tr('Invalid matchday number.');
    $v['dom'] = (string)($_POST['dom'] ?? ''); $v['ext'] = (string)($_POST['ext'] ?? '');
    if (!isset($CLUBS[$v['dom']]) || !isset($CLUBS[$v['ext']])) $errors[] = tr('Choose both teams.');
    elseif ($v['dom'] === $v['ext']) $errors[] = tr('The two teams must be different.');
    elseif ($v['dom'] !== 'CSC' && $v['ext'] !== 'CSC') $errors[] = tr('CSC must be one of the two teams.');

    $d = $t('date_match', 10);
    $dt = DateTime::createFromFormat('!Y-m-d', $d);
    if ($d !== '' && (!$dt || $dt->format('Y-m-d') !== $d)) $errors[] = tr('Invalid date.');
    $v['date_match'] = $d === '' ? null : $d;
    $h = $t('heure', 5);
    if ($h !== '' && !preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $h)) $errors[] = tr('Invalid time (HH:MM).');
    $v['heure'] = $h === '' ? null : $h;

    $bd = $t('bd', 2); $be = $t('be', 2);
    if (($bd === '') !== ($be === '')) $errors[] = tr('Enter both scores, or leave both empty if the match has not been played yet.');
    elseif ($bd !== '' && (!ctype_digit($bd) || !ctype_digit($be))) $errors[] = tr('Invalid score.');
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
            flash('success', tr('Match saved.'));
        } else {
            $ph = implode(', ', array_fill(0, count($cols), '?'));
            $pdo->prepare('INSERT INTO matchs_csc (`' . implode('`, `', $cols) . "`) VALUES ($ph)")->execute($vals);
            flash('success', tr('Match added.'));
        }
        redirect('matchs.php');
    }
}

try { $actus = $pdo->query('SELECT id, titre_fr, date_pub FROM actualites ORDER BY position DESC, id DESC LIMIT 40')->fetchAll(); }
catch (PDOException $e) { $actus = []; }
page_header($row ? tr('Edit a match') : tr('Add a match'), $admin);
$clubOptions = function ($sel) use ($CLUBS) {
    $o = '<option value="">' . e(tr('— choose —')) . '</option>';
    foreach ($CLUBS as $c => $i) $o .= '<option value="' . e($c) . '"' . ($c === $sel ? ' selected' : '') . '>' . e(admin_lang() === 'ar' ? $i['ar'] : $i['nom_fr']) . '</option>';
    return $o;
};
?>
<div class="adm-head">
  <h1 class="adm-h1"><?= $row ? '<i class="fas fa-pen"></i> ' . e(tr('Edit the match')) : '<i class="fas fa-plus"></i> ' . e(tr('New match')) ?></h1>
  <a class="btn btn-light" href="matchs.php"><i class="fas fa-arrow-left"></i> <?= e(tr('Back to the list')) ?></a>
</div>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b><?= e(tr('Please fix:')) ?></b><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" class="adm-form">
  <?= csrf_field() ?>
  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('The match')) ?></h2>
    <div class="form-row">
      <div class="form-group col-md-2"><label><?= e(tr('Matchday')) ?> *</label>
        <input type="number" class="form-control" name="j" min="1" max="99" value="<?= e($v['j']) ?>" required></div>
      <div class="form-group col-md-5"><label><?= e(tr('Home')) ?> *</label>
        <select class="form-control" name="dom" id="dom" required><?= $clubOptions($v['dom']) ?></select></div>
      <div class="form-group col-md-5"><label><?= e(tr('Away')) ?> *</label>
        <select class="form-control" name="ext" id="ext" required><?= $clubOptions($v['ext']) ?></select></div>
    </div>
    <button type="button" class="btn btn-sm btn-light mb-3" id="swap"><i class="fas fa-exchange-alt"></i> <?= e(tr('Swap home / away')) ?></button>
    <div class="form-row">
      <div class="form-group col-md-4"><label><?= e(tr('Date')) ?></label>
        <input type="date" class="form-control" name="date_match" value="<?= e($v['date_match'] ?? '') ?>">
        <small class="text-muted"><?= e(tr('Empty = “Date to be confirmed”.')) ?></small></div>
      <div class="form-group col-md-3"><label><?= e(tr('Time')) ?></label>
        <input type="time" class="form-control" name="heure" value="<?= e($v['heure'] ? substr($v['heure'], 0, 5) : '') ?>"></div>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Score')) ?> <span class="text-muted small"><?= e(tr('(leave empty until the match is played)')) ?></span></h2>
    <div class="d-flex align-items-center" style="gap:12px">
      <input type="number" class="form-control" style="width:90px" name="bd" min="0" max="99" value="<?= $v['bd'] === null ? '' : (int)$v['bd'] ?>" id="bd">
      <b>-</b>
      <input type="number" class="form-control" style="width:90px" name="be" min="0" max="99" value="<?= $v['be'] === null ? '' : (int)$v['be'] ?>" id="be">
      <span class="small text-muted" id="scoreLabel"></span>
    </div>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Stadium')) ?> <span class="text-muted small"><?= e(tr('(optional)')) ?></span></h2>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Stadium (EN)')) ?></label>
        <input class="form-control" dir="ltr" name="stade_fr" value="<?= e($v['stade_fr']) ?>" maxlength="150" placeholder="<?= e(tr('e.g. Amar Hamam Stadium, Khenchela')) ?>"></div>
      <div class="form-group col-md-6" dir="rtl"><label>الملعب (AR)</label>
        <input class="form-control" name="stade_ar" value="<?= e($v['stade_ar']) ?>" maxlength="150"></div>
    </div>
    <small class="text-muted"><?= e(tr('Empty: “Chahid Hamlaoui Stadium, Constantine” at home, the opponent’s city away (translated automatically).')) ?>
    <?= e(tr('If only the English is filled in, the Arabic site shows the English text.')) ?></small>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('When it is the next match')) ?> <span class="text-muted small"><?= e(tr('(optional, large card)')) ?></span></h2>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Tagline (EN)')) ?></label>
        <input class="form-control" dir="ltr" name="slogan_fr" value="<?= e($v['slogan_fr']) ?>" maxlength="300" placeholder="In the silence of the tunnel..."></div>
      <div class="form-group col-md-6" dir="rtl"><label>العبارة (AR)</label>
        <input class="form-control" name="slogan_ar" value="<?= e($v['slogan_ar']) ?>" maxlength="300"></div>
    </div>
    <div class="form-group"><label><?= e(tr('Poster: linked article (“See the poster”)')) ?></label>
      <select class="form-control" name="actu">
        <option value=""><?= e(tr('— none —')) ?></option>
        <?php foreach ($actus as $a): ?><option value="<?= (int)$a['id'] ?>" <?= (int)$v['actu'] === (int)$a['id'] ? 'selected' : '' ?>><?= e(($a['date_pub'] ? date('d/m', strtotime($a['date_pub'])) . ' · ' : '') . $a['titre_fr']) ?></option><?php endforeach; ?>
      </select></div>
  </div>

  <div class="adm-submit">
    <button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> <?= e(tr('Save')) ?></button>
    <a class="btn btn-link" href="matchs.php"><?= e(tr('Cancel')) ?></a>
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
