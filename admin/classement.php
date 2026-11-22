<?php
/* Modifier le classement Ligue 1 (affiché sur classement.php et l'accueil) */
require __DIR__ . '/inc/bootstrap.php';
$admin = require_login();
$pdo = db();
$CLUBS = require __DIR__ . '/../Data/clubs.php';
const CL_COLS = ['j' => 'J', 'g' => 'G', 'n' => 'N', 'p' => 'P', 'bp' => 'BP', 'bc' => 'BC', 'points' => 'Pts'];

try {
    $rows = $pdo->query('SELECT * FROM classement_l1 ORDER BY pos ASC')->fetchAll();
    $info = $pdo->query('SELECT * FROM classement_l1_info WHERE id = 1')->fetch() ?: ['saison' => '', 'journee' => 0, 'mise_a_jour' => date('Y-m-d H:i:s')];
} catch (PDOException $e) {
    page_header('Classement', $admin); ?>
    <div class="adm-card"><h1 class="adm-h1">Classement</h1>
      <p>Les tables du classement n’existent pas encore. Dans <b>phpMyAdmin</b>, importez le fichier
      <code>database/maj_2026-11-18_admin_classement.sql</code>, puis rechargez cette page.</p></div>
    <?php page_footer(); exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codes = (array)($_POST['code'] ?? []);
    $new = [];
    foreach ($codes as $i => $code) {
        $code = (string)$code;
        if (!isset($CLUBS[$code])) { $errors[] = 'Ligne ' . ($i + 1) . ' : club inconnu.'; continue; }
        $r = ['code' => $code];
        foreach (CL_COLS as $k => $lab) {
            $v = trim((string)($_POST[$k][$i] ?? ''));
            if (!preg_match('/^\d{1,3}$/', $v)) { $errors[] = $CLUBS[$code]['fr'] . " : la colonne $lab doit être un nombre (0 ou plus)."; $v = 0; }
            $r[$k] = (int)$v;
        }
        $new[] = $r;
    }
    $dup = array_diff_assoc(array_column($new, 'code'), array_unique(array_column($new, 'code')));
    foreach (array_unique($dup) as $d) $errors[] = 'Le club ' . $CLUBS[$d]['fr'] . ' apparaît deux fois.';
    if (count($new) < 2) $errors[] = 'Le classement doit contenir au moins 2 clubs.';

    $saison = trim((string)($_POST['saison'] ?? ''));
    if (!preg_match('#^\d{4}/\d{4}$#', $saison)) $errors[] = 'Saison au format 2026/2027.';
    $journee = trim((string)($_POST['journee'] ?? ''));
    if (!preg_match('/^\d{1,2}$/', $journee)) $errors[] = 'Journée invalide.';
    $maj = trim((string)($_POST['mise_a_jour'] ?? ''));
    $dt = DateTime::createFromFormat('Y-m-d\TH:i', $maj);
    if (!$dt) $errors[] = 'Date de mise à jour invalide.';

    if (!$errors) {
        $pdo->beginTransaction();
        $pdo->exec('DELETE FROM classement_l1');
        $ins = $pdo->prepare('INSERT INTO classement_l1 (code, pos, j, g, n, p, bp, bc, points) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        foreach ($new as $i => $r) $ins->execute([$r['code'], $i + 1, $r['j'], $r['g'], $r['n'], $r['p'], $r['bp'], $r['bc'], $r['points']]);
        $pdo->prepare('REPLACE INTO classement_l1_info (id, saison, journee, mise_a_jour) VALUES (1, ?, ?, ?)')
            ->execute([$saison, (int)$journee, $dt->format('Y-m-d H:i:00')]);
        $pdo->commit();
        flash('success', 'Classement enregistré (' . (int)$journee . 'e journée). Il est déjà à jour sur le site.');
        redirect('classement.php');
    }
    // On réaffiche ce qui a été saisi
    $rows = array_map(fn($r) => $r, $new);
    $info = ['saison' => $saison, 'journee' => $journee, 'mise_a_jour' => $dt ? $dt->format('Y-m-d H:i:s') : date('Y-m-d H:i:s')];
}

page_header('Classement', $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><i class="fas fa-list-ol"></i> Classement Ligue 1</h1>
  <a class="btn btn-light" href="../classement.php" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> Voir sur le site</a>
</div>
<p class="text-muted small">Recopiez les chiffres de <a href="https://lfp.dz/fr/ranking" target="_blank" rel="noopener">lfp.dz</a>.
L’ordre des lignes est l’ordre du classement : utilisez les flèches, ou « Trier par points ». La différence de buts est calculée toute seule.</p>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b>À corriger :</b><ul class="mb-0"><?php foreach (array_unique($errors) as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" id="clForm">
  <?= csrf_field() ?>
  <div class="adm-card">
    <div class="form-row">
      <div class="form-group col-md-3"><label>Saison</label>
        <input class="form-control" name="saison" value="<?= e($info['saison']) ?>" placeholder="2026/2027" required></div>
      <div class="form-group col-md-2"><label>Journée</label>
        <input type="number" class="form-control" name="journee" min="0" max="99" value="<?= e($info['journee']) ?>" required></div>
      <div class="form-group col-md-4"><label>Dernière mise à jour</label>
        <input type="datetime-local" class="form-control" name="mise_a_jour" id="maj" value="<?= e(date('Y-m-d\TH:i', strtotime((string)$info['mise_a_jour']))) ?>" required></div>
      <div class="form-group col-md-3 d-flex align-items-end">
        <button type="button" class="btn btn-light btn-block" id="majNow"><i class="far fa-clock"></i> Maintenant</button></div>
    </div>
  </div>

  <div class="adm-card adm-table-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2" style="gap:8px">
      <h2 class="adm-h2 mb-0">Tableau</h2>
      <button type="button" class="btn btn-sm btn-light" id="sortBtn"><i class="fas fa-sort-amount-down"></i> Trier par points</button>
    </div>
    <div class="table-responsive">
    <table class="table table-sm adm-cl">
      <thead><tr><th>#</th><th>Club</th><?php foreach (CL_COLS as $lab): ?><th><?= e($lab) ?></th><?php endforeach; ?><th>Diff</th><th></th></tr></thead>
      <tbody id="clBody">
      <?php foreach ($rows as $r): ?>
        <tr class="<?= $r['code'] === 'CSC' ? 'is-csc' : '' ?>">
          <td class="pos"></td>
          <td><select name="code[]" class="form-control form-control-sm">
            <?php foreach ($CLUBS as $code => $c): ?><option value="<?= e($code) ?>" <?= $code === $r['code'] ? 'selected' : '' ?>><?= e($c['nom_fr']) ?></option><?php endforeach; ?>
          </select></td>
          <?php foreach (CL_COLS as $k => $lab): ?>
            <td><input type="number" min="0" max="999" class="form-control form-control-sm" name="<?= $k ?>[]" value="<?= (int)$r[$k] ?>" data-k="<?= $k ?>" required></td>
          <?php endforeach; ?>
          <td class="diff"></td>
          <td class="text-nowrap">
            <button type="button" class="btn btn-sm btn-light up" title="Monter"><i class="fas fa-arrow-up"></i></button>
            <button type="button" class="btn btn-sm btn-light down" title="Descendre"><i class="fas fa-arrow-down"></i></button>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <div id="clWarn" class="small text-warning-dark"></div>
  </div>

  <div class="adm-submit">
    <button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> Enregistrer le classement</button>
    <a class="btn btn-link" href="classement.php">Annuler</a>
  </div>
</form>

<script>
(function () {
  var body = document.getElementById('clBody');
  function val(tr, k) { return parseInt(tr.querySelector('[data-k="' + k + '"]').value, 10) || 0; }
  function refresh() {
    var warns = [];
    Array.from(body.rows).forEach(function (tr, i) {
      tr.querySelector('.pos').textContent = i + 1;
      var d = val(tr, 'bp') - val(tr, 'bc');
      tr.querySelector('.diff').textContent = (d > 0 ? '+' : '') + d;
      var name = tr.querySelector('select').selectedOptions[0].text;
      tr.classList.toggle('is-csc', tr.querySelector('select').value === 'CSC');
      if (val(tr, 'g') + val(tr, 'n') + val(tr, 'p') !== val(tr, 'j')) warns.push(name + ' : G + N + P ne fait pas J.');
      if (val(tr, 'g') * 3 + val(tr, 'n') !== val(tr, 'points')) warns.push(name + ' : 3×G + N ne fait pas les points (normal seulement en cas de pénalité).');
    });
    document.getElementById('clWarn').innerHTML = warns.length ? '<b>À vérifier :</b><br>' + warns.map(function (w) { return w.replace(/</g, '&lt;'); }).join('<br>') : '';
  }
  body.addEventListener('click', function (e) {
    var b = e.target.closest('button'); if (!b) return;
    var tr = b.closest('tr');
    if (b.classList.contains('up') && tr.previousElementSibling) body.insertBefore(tr, tr.previousElementSibling);
    if (b.classList.contains('down') && tr.nextElementSibling) body.insertBefore(tr.nextElementSibling, tr);
    refresh();
  });
  body.addEventListener('input', refresh);
  body.addEventListener('change', refresh);
  document.getElementById('sortBtn').addEventListener('click', function () {
    Array.from(body.rows).sort(function (a, b) {
      return (val(b, 'points') - val(a, 'points')) || ((val(b, 'bp') - val(b, 'bc')) - (val(a, 'bp') - val(a, 'bc'))) || (val(b, 'bp') - val(a, 'bp'));
    }).forEach(function (tr) { body.appendChild(tr); });
    refresh();
  });
  document.getElementById('majNow').addEventListener('click', function () {
    var d = new Date(); d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
    document.getElementById('maj').value = d.toISOString().slice(0, 16);
  });
  refresh();
})();
</script>
<?php page_footer();
