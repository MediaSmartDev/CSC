<?php
/* Catégories jeunes : une catégorie à la fois (onglets), joueurs puis staff */
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/jeunes_common.php';
$admin = require_login();
$pdo = db();

try { $pdo->query('SELECT 1 FROM jeunes LIMIT 1'); }
catch (PDOException $e) {
    page_header(tr('Jeunes'), $admin); ?>
    <div class="adm-card"><h1 class="adm-h1"><?= e(tr('Jeunes')) ?></h1>
      <p><?= tr('La table %1$s n’existe pas encore. Dans <b>phpMyAdmin</b>, importez %2$s, puis rechargez cette page.', tr('des jeunes'), '<code>database/maj_2026-11-22_admin_jeunes.sql</code>') ?></p></div>
    <?php page_footer(); exit;
}

$cat = (string)($_GET['cat'] ?? 'U21');
if (!isset(CSC_JEUNES_CATEGORIES[$cat])) $cat = 'U21';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $action = (string)($_POST['action'] ?? '');
    $st = $pdo->prepare('SELECT * FROM jeunes WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) { flash('danger', tr('Membre introuvable.')); redirect('jeunes.php?cat=' . $cat); }
    $back = 'jeunes.php?cat=' . urlencode($row['categorie']);

    if ($action === 'delete') {
        $pdo->prepare('DELETE FROM jeunes WHERE id = ?')->execute([$id]);
        delete_uploaded_image($row['img']);
        flash('success', tr('Supprimé : %s', $row['nom']));
    } elseif ($action === 'toggle') {
        $pdo->prepare('UPDATE jeunes SET publie = 1 - publie WHERE id = ?')->execute([$id]);
        flash('success', $row['publie'] ? tr('%s est masqué du site.', $row['nom']) : tr('%s est affiché sur le site.', $row['nom']));
    } elseif ($action === 'up' || $action === 'down') {
        $l = $pdo->prepare('SELECT id FROM jeunes WHERE categorie = ? AND type = ? ORDER BY ordre ASC, id ASC');
        $l->execute([$row['categorie'], $row['type']]);
        $ids = array_map('intval', $l->fetchAll(PDO::FETCH_COLUMN));
        $i = array_search($id, $ids, true);
        $j = $action === 'up' ? $i - 1 : $i + 1;
        if ($i !== false && isset($ids[$j])) {
            [$ids[$i], $ids[$j]] = [$ids[$j], $ids[$i]];
            $pdo->beginTransaction();
            $u = $pdo->prepare('UPDATE jeunes SET ordre = ? WHERE id = ?');
            foreach ($ids as $k => $pid) $u->execute([$k + 1, $pid]);
            $pdo->commit();
        }
        redirect($back . '#y' . $id);
    }
    redirect($back);
}

$counts = $pdo->query('SELECT categorie, COUNT(*) n FROM jeunes GROUP BY categorie')->fetchAll(PDO::FETCH_KEY_PAIR);
$st = $pdo->prepare('SELECT * FROM jeunes WHERE categorie = ? ORDER BY type ASC, ordre ASC, id ASC');
$st->execute([$cat]);
$byType = [];
foreach ($st->fetchAll() as $r) $byType[(int)$r['type']][] = $r;
$visible = count(array_filter(array_merge(...array_values($byType ?: [[]])), fn($r) => $r['publie']));
page_header(tr('Jeunes'), $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><i class="fas fa-child"></i> <?= e(tr('Catégories jeunes')) ?></h1>
  <a class="btn btn-light" href="../jeunes.php" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> <?= e(tr('Voir sur le site')) ?></a>
</div>
<p class="text-muted small"><?= e(tr('Tant qu’une catégorie n’a personne d’affiché, le site montre « Effectif bientôt disponible » avec le bouton « Contacter le club ».')) ?></p>

<div class="adm-tabs">
  <?php foreach (CSC_JEUNES_CATEGORIES as $code => $_): ?>
    <a href="jeunes.php?cat=<?= $code ?>" class="<?= $code === $cat ? 'active' : '' ?>"><?= $code ?> <span class="adm-count"><?= (int)($counts[$code] ?? 0) ?></span></a>
  <?php endforeach; ?>
</div>

<div class="adm-card adm-cat-head">
  <div><b><?= e(jeune_cat_label($cat)) ?></b>
    <div class="small text-muted"><?= $visible ? e(tr('Sur le site : %s carte(s).', $visible)) : e(tr('Sur le site : « Effectif bientôt disponible ».')) ?></div></div>
</div>

<?php foreach (JEUNE_TYPES as $t => $tLabel): $list = $byType[$t] ?? []; ?>
  <h2 class="adm-h2 mt-4"><?= e(tr($tLabel)) ?> <span class="adm-count"><?= count($list) ?></span>
    <a class="btn btn-sm btn-light adm-ms" href="jeune.php?cat=<?= $cat ?>&amp;type=<?= $t ?>"><i class="fas fa-plus"></i> <?= e(tr('Ajouter ici')) ?></a></h2>
  <?php if (!$list): ?><div class="adm-card text-muted small"><?= e(tr('Personne pour l’instant.')) ?></div><?php endif; ?>
  <div class="adm-list">
  <?php foreach ($list as $i => $r): ?>
    <div class="adm-item<?= $r['publie'] ? '' : ' is-hidden' ?>" id="y<?= (int)$r['id'] ?>">
      <div class="adm-num"><?= $r['num'] !== null ? (int)$r['num'] : '–' ?></div>
      <img class="adm-thumb adm-thumb-player" src="<?= e(admin_img($r['img'] ?: 'images/player-default.png')) ?>" alt="" loading="lazy">
      <div class="adm-item-body">
        <div class="adm-item-title" dir="ltr"><?= e($r['nom']) ?></div>
        <div class="adm-item-title-ar" dir="rtl"><?= e($r['nom_ar'] ?? '') ?></div>
        <div class="adm-item-meta">
          <?php if (jeune_poste($r) !== ''): ?><span class="adm-tag"><?= e(jeune_poste($r)) ?></span><?php endif; ?>
          <?php if (!$r['publie']): ?><span class="adm-badge-hidden"><i class="fas fa-eye-slash"></i> <?= e(tr('Masqué')) ?></span><?php endif; ?>
        </div>
      </div>
      <div class="adm-actions">
        <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button name="action" value="up" class="btn btn-sm btn-light" title="<?= e(tr('Monter')) ?>" <?= $i === 0 ? 'disabled' : '' ?>><i class="fas fa-arrow-up"></i></button>
          <button name="action" value="down" class="btn btn-sm btn-light" title="<?= e(tr('Descendre')) ?>" <?= $i === count($list) - 1 ? 'disabled' : '' ?>><i class="fas fa-arrow-down"></i></button>
          <button name="action" value="toggle" class="btn btn-sm btn-light" title="<?= e($r['publie'] ? tr('Masquer du site') : tr('Afficher sur le site')) ?>"><i class="fas <?= $r['publie'] ? 'fa-eye-slash' : 'fa-eye' ?>"></i></button>
        </form>
        <a class="btn btn-sm adm-btn" href="jeune.php?id=<?= (int)$r['id'] ?>"><i class="fas fa-pen"></i> <?= e(tr('Modifier')) ?></a>
        <form method="post" onsubmit="return confirm(<?= trjs('Supprimer définitivement %s ?', $r['nom']) ?>);"><?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button name="action" value="delete" class="btn btn-sm btn-outline-danger" title="<?= e(tr('Supprimer')) ?>"><i class="fas fa-trash"></i></button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
<?php endforeach; ?>
<?php page_footer();
