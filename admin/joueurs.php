<?php
/* Liste des joueurs par catégorie + actions rapides (ordre, afficher/masquer, supprimer) */
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/joueurs_common.php';
$admin = require_login();
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $action = (string)($_POST['action'] ?? '');
    $st = $pdo->prepare('SELECT * FROM joueurs WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) { flash('danger', tr('Joueur introuvable.')); redirect('joueurs.php'); }

    if ($action === 'delete') {
        $pdo->prepare('DELETE FROM joueurs WHERE id = ?')->execute([$id]);
        delete_uploaded_image($row['img']);
        flash('success', tr('Supprimé : %s', joueur_nom($row)));
    } elseif ($action === 'toggle') {
        $pdo->prepare('UPDATE joueurs SET published = 1 - published WHERE id = ?')->execute([$id]);
        flash('success', $row['published'] ? tr('%s est masqué du site.', joueur_nom($row)) : tr('%s est affiché sur le site.', joueur_nom($row)));
    } elseif ($action === 'up' || $action === 'down') {
        // On renumérote la catégorie (1, 2, 3...) puis on échange avec le voisin
        $l = $pdo->prepare('SELECT id FROM joueurs WHERE categorie = ? ORDER BY ordre ASC, dossard ASC, nom ASC');
        $l->execute([$row['categorie']]);
        $ids = array_map('intval', $l->fetchAll(PDO::FETCH_COLUMN));
        $i = array_search($id, $ids, true);
        $j = $action === 'up' ? $i - 1 : $i + 1;
        if ($i !== false && isset($ids[$j])) {
            [$ids[$i], $ids[$j]] = [$ids[$j], $ids[$i]];
            $pdo->beginTransaction();
            $u = $pdo->prepare('UPDATE joueurs SET ordre = ? WHERE id = ?');
            foreach ($ids as $k => $pid) $u->execute([$k + 1, $pid]);
            $pdo->commit();
        }
        redirect('joueurs.php#j' . $id);
    }
    redirect('joueurs.php#cat' . (int)$row['categorie']);
}

$all = $pdo->query('SELECT * FROM joueurs ORDER BY categorie ASC, ordre ASC, dossard ASC, nom ASC')->fetchAll();
$byCat = [];
foreach ($all as $r) $byCat[(int)$r['categorie']][] = $r;
page_header(tr('Joueurs'), $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><i class="fas fa-users"></i> <?= e(tr('Joueurs et staff')) ?> <span class="adm-count"><?= count($all) ?></span></h1>
  <a class="btn adm-btn" href="joueur.php"><i class="fas fa-plus"></i> <?= e(tr('Ajouter un joueur')) ?></a>
</div>
<p class="text-muted small"><?= e(tr('Même ordre que sur la page « Joueurs » du site. Les flèches changent l’ordre dans la catégorie.')) ?></p>

<?php foreach (JOUEUR_CATEGORIES as $c => [$catLabel]): $list = $byCat[$c] ?? []; ?>
  <h2 class="adm-h2 mt-4" id="cat<?= $c ?>"><?= e(tr($catLabel)) ?> <span class="adm-count"><?= count($list) ?></span>
    <a class="btn btn-sm btn-light adm-ms" href="joueur.php?categorie=<?= $c ?>"><i class="fas fa-plus"></i> <?= e(tr('Ajouter ici')) ?></a></h2>
  <?php if (!$list): ?><div class="adm-card text-muted small"><?= e(tr('Personne dans cette catégorie pour l’instant.')) ?></div><?php endif; ?>
  <div class="adm-list">
  <?php foreach ($list as $i => $r): ?>
    <div class="adm-item<?= $r['published'] ? '' : ' is-hidden' ?>" id="j<?= (int)$r['id'] ?>">
      <div class="adm-num"><?= $r['dossard'] !== null ? (int)$r['dossard'] : '–' ?></div>
      <img class="adm-thumb adm-thumb-player" src="<?= e(admin_img($r['img'] ?: 'images/player-default.png')) ?>" alt="" loading="lazy">
      <div class="adm-item-body">
        <div class="adm-item-title" dir="ltr"><?= e(joueur_nom($r)) ?></div>
        <div class="adm-item-title-ar" dir="rtl"><?= e($r['nom_ar'] ?? '') ?></div>
        <div class="adm-item-meta">
          <span class="adm-tag"><?= e(admin_lang() === 'ar' && !empty($r['poste_ar']) ? $r['poste_ar'] : tr($r['poste'])) ?></span>
          <?php $age = joueur_age($r); if ($age): ?><span><?= e(tr('%s ans', $age)) ?></span><?php endif; ?>
          <span><?= e(tr($r['nationalite'])) ?></span>
          <?php if (!$r['published']): ?><span class="adm-badge-hidden"><i class="fas fa-eye-slash"></i> <?= e(tr('Masqué')) ?></span><?php endif; ?>
        </div>
      </div>
      <div class="adm-actions">
        <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button name="action" value="up" class="btn btn-sm btn-light" title="<?= e(tr('Monter')) ?>" <?= $i === 0 ? 'disabled' : '' ?>><i class="fas fa-arrow-up"></i></button>
          <button name="action" value="down" class="btn btn-sm btn-light" title="<?= e(tr('Descendre')) ?>" <?= $i === count($list) - 1 ? 'disabled' : '' ?>><i class="fas fa-arrow-down"></i></button>
          <button name="action" value="toggle" class="btn btn-sm btn-light" title="<?= e($r['published'] ? tr('Masquer du site') : tr('Afficher sur le site')) ?>"><i class="fas <?= $r['published'] ? 'fa-eye-slash' : 'fa-eye' ?>"></i></button>
        </form>
        <a class="btn btn-sm adm-btn" href="joueur.php?id=<?= (int)$r['id'] ?>"><i class="fas fa-pen"></i> <?= e(tr('Modifier')) ?></a>
        <form method="post" onsubmit="return confirm(<?= trjs("Supprimer définitivement %s ?\n(Pour un joueur qui part en prêt, utilisez plutôt le bouton Masquer.)", joueur_nom($r)) ?>);"><?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button name="action" value="delete" class="btn btn-sm btn-outline-danger" title="<?= e(tr('Supprimer')) ?>"><i class="fas fa-trash"></i></button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
<?php endforeach; ?>
<?php page_footer();
