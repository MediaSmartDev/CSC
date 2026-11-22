<?php
/* Matchs du CSC : à venir (accueil) + score rapide + historique des matchs joués */
require __DIR__ . '/inc/bootstrap.php';
$admin = require_login();
$pdo = db();
$CLUBS = require __DIR__ . '/../Data/clubs.php';

try { $pdo->query('SELECT 1 FROM matchs_csc LIMIT 1'); }
catch (PDOException $e) {
    page_header(tr('Matchs'), $admin); ?>
    <div class="adm-card"><h1 class="adm-h1"><?= e(tr('Matchs')) ?></h1>
      <p><?= tr('La table %1$s n’existe pas encore. Dans <b>phpMyAdmin</b>, importez %2$s, puis rechargez cette page.', tr('des matchs'), '<code>database/maj_2026-11-18_admin_matchs.sql</code>') ?></p></div>
    <?php page_footer(); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $action = (string)($_POST['action'] ?? '');
    $st = $pdo->prepare('SELECT * FROM matchs_csc WHERE id = ?'); $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) { flash('danger', tr('Match introuvable.')); redirect('matchs.php'); }
    $label = admin_club($CLUBS, $row['dom']) . ' – ' . admin_club($CLUBS, $row['ext']);
    if ($action === 'score') {
        $bd = trim((string)($_POST['bd'] ?? '')); $be = trim((string)($_POST['be'] ?? ''));
        if (!preg_match('/^\d{1,2}$/', $bd) || !preg_match('/^\d{1,2}$/', $be)) {
            flash('danger', tr('Score invalide pour %s : mettez deux nombres.', $label));
        } else {
            $pdo->prepare('UPDATE matchs_csc SET bd = ?, be = ? WHERE id = ?')->execute([(int)$bd, (int)$be, $id]);
            flash('success', tr('Score enregistré : %1$s %2$s. Le match passe dans l’historique et l’accueil affiche le match suivant.', $label, "$bd-$be"));
        }
    } elseif ($action === 'unscore') {
        $pdo->prepare('UPDATE matchs_csc SET bd = NULL, be = NULL WHERE id = ?')->execute([$id]);
        flash('success', tr('Score retiré : %s est de nouveau « à venir ».', $label));
    } elseif ($action === 'delete') {
        $pdo->prepare('DELETE FROM matchs_csc WHERE id = ?')->execute([$id]);
        flash('success', tr('Match supprimé : %s', $label));
    }
    redirect('matchs.php');
}

// Même règle que l'accueil (Data/calendrier.php) pour savoir ce qui est affiché
$all = $pdo->query('SELECT * FROM matchs_csc ORDER BY j ASC, date_match IS NULL, date_match ASC, id ASC')->fetchAll();
$joues = array_values(array_filter($all, fn($m) => $m['bd'] !== null && $m['be'] !== null));
$jDernier = $joues ? max(array_map(fn($m) => (int)$m['j'], $joues)) : 0;
$auj = date('Y-m-d');
$attente = []; $avenir = [];
foreach ($all as $m) {
    if ($m['bd'] !== null && $m['be'] !== null) continue;
    $ok = $m['date_match'] ? $m['date_match'] >= $auj : (int)$m['j'] > $jDernier;
    if ($ok) $avenir[] = $m; else $attente[] = $m;
}
$cn = fn($c) => admin_club($CLUBS, $c);
$logo = fn($c) => isset($CLUBS[$c]) ? (preg_match('#^https?://#', $CLUBS[$c]['logo']) ? $CLUBS[$c]['logo'] : '../' . $CLUBS[$c]['logo']) : '../images/logo-dark.png';
$quand = fn($m) => ($m['date_match'] ? date('d/m/Y', strtotime($m['date_match'])) : tr('date à confirmer')) . ($m['heure'] ? ' · ' . substr($m['heure'], 0, 5) : '');

function match_line(array $m, callable $cn, callable $logo, callable $quand, string $mode, string $badge = ''): void { ?>
  <div class="adm-item adm-match<?= $mode === 'joue' ? ' is-played' : '' ?>">
    <div class="adm-mj">J<?= (int)$m['j'] ?></div>
    <div class="adm-item-body">
      <div class="adm-teams">
        <img src="<?= e($logo($m['dom'])) ?>" alt=""><b><?= e($cn($m['dom'])) ?></b>
        <?php if ($mode === 'joue'): ?><span class="adm-score"><?= (int)$m['bd'] ?> - <?= (int)$m['be'] ?></span><?php else: ?><span class="adm-vs"><?= e(tr('vs')) ?></span><?php endif; ?>
        <b><?= e($cn($m['ext'])) ?></b><img src="<?= e($logo($m['ext'])) ?>" alt="">
      </div>
      <div class="adm-item-meta"><span><i class="far fa-calendar-alt"></i> <?= e($quand($m)) ?></span><?= $badge ?></div>
    </div>
    <div class="adm-actions">
      <?php if ($mode !== 'joue'): ?>
      <form method="post" class="adm-scoreform"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$m['id'] ?>"><input type="hidden" name="action" value="score">
        <input type="number" name="bd" min="0" max="99" class="form-control form-control-sm" placeholder="<?= e($m['dom']) ?>" required>
        <span>-</span>
        <input type="number" name="be" min="0" max="99" class="form-control form-control-sm" placeholder="<?= e($m['ext']) ?>" required>
        <button class="btn btn-sm btn-success" title="<?= e(tr('Enregistrer le score')) ?>"><i class="fas fa-check"></i> <?= e(tr('Score')) ?></button>
      </form>
      <?php else: ?>
      <form method="post" onsubmit="return confirm(<?= trjs('Retirer le score ? Le match redeviendra « à venir ».') ?>);"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
        <button name="action" value="unscore" class="btn btn-sm btn-light" title="<?= e(tr('Retirer le score')) ?>"><i class="fas fa-undo"></i></button></form>
      <?php endif; ?>
      <a class="btn btn-sm adm-btn" href="match.php?id=<?= (int)$m['id'] ?>"><i class="fas fa-pen"></i> <?= e(tr('Modifier')) ?></a>
      <form method="post" onsubmit="return confirm(<?= trjs('Supprimer ce match ?') ?>);"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
        <button name="action" value="delete" class="btn btn-sm btn-outline-danger" title="<?= e(tr('Supprimer')) ?>"><i class="fas fa-trash"></i></button></form>
    </div>
  </div>
<?php }

page_header(tr('Matchs'), $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><i class="fas fa-futbol"></i> <?= e(tr('Matchs du CSC')) ?></h1>
  <a class="btn adm-btn" href="match.php"><i class="fas fa-plus"></i> <?= e(tr('Ajouter un match')) ?></a>
</div>
<p class="text-muted small"><?= e(tr('L’accueil montre les 4 prochains matchs : le 1er en grand (« Prochain match »), les 3 suivants à droite.')) ?>
<?= e(tr('Dès que vous mettez le score, le match passe dans l’historique et le suivant monte tout seul.')) ?></p>

<?php if ($attente): ?>
  <h2 class="adm-h2 mt-4 text-warning-dark"><i class="fas fa-exclamation-triangle"></i> <?= e(tr('En attente du score')) ?> <span class="adm-count" style="background:#c98a00"><?= count($attente) ?></span></h2>
  <p class="small text-muted"><?= e(tr('Ces matchs sont passés (ou plus anciens que le dernier match joué) mais n’ont pas de score : ils ne sont plus affichés comme « prochain match ».')) ?></p>
  <div class="adm-list"><?php foreach ($attente as $m) match_line($m, $cn, $logo, $quand, 'attente'); ?></div>
<?php endif; ?>

<h2 class="adm-h2 mt-4"><?= e(tr('À venir')) ?> <span class="adm-count"><?= count($avenir) ?></span></h2>
<div class="adm-list">
  <?php if (!$avenir): ?><div class="adm-card text-muted small"><?= e(tr('Aucun match à venir. Ajoutez le prochain match pour remplir l’accueil.')) ?></div><?php endif; ?>
  <?php foreach ($avenir as $i => $m) match_line($m, $cn, $logo, $quand, 'avenir',
      $i === 0 ? '<span class="adm-tag">' . e(tr('Prochain match (en grand)')) . '</span>' : ($i < 4 ? '<span class="adm-tag adm-tag-light">' . e(tr('Accueil, à droite')) . '</span>' : '')); ?>
</div>

<h2 class="adm-h2 mt-4"><?= e(tr('Matchs joués')) ?> <span class="adm-count"><?= count($joues) ?></span></h2>
<p class="small text-muted"><?= e(tr('Le plus récent sert de « Dernier match » et les 5 derniers donnent la forme récente sur l’accueil.')) ?></p>
<div class="adm-list"><?php foreach (array_reverse($joues) as $m) match_line($m, $cn, $logo, $quand, 'joue'); ?></div>
<?php page_footer();
