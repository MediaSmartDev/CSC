<?php
/* Équipe féminine : liste par groupe + actions rapides (ordre, afficher/masquer, supprimer) */
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/feminine_common.php';
$admin = require_login();
$pdo = db();

try { $pdo->query('SELECT 1 FROM equipe_feminine LIMIT 1'); }
catch (PDOException $e) {
    page_header('Équipe féminine', $admin); ?>
    <div class="adm-card"><h1 class="adm-h1">Équipe féminine</h1>
      <p>La table de l’équipe féminine n’existe pas encore. Dans <b>phpMyAdmin</b>, importez
      <code>database/maj_2026-11-22_admin_feminine.sql</code>, puis rechargez cette page.</p></div>
    <?php page_footer(); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $action = (string)($_POST['action'] ?? '');
    $st = $pdo->prepare('SELECT * FROM equipe_feminine WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) { flash('danger', 'Membre introuvable.'); redirect('feminine.php'); }

    if ($action === 'delete') {
        $pdo->prepare('DELETE FROM equipe_feminine WHERE id = ?')->execute([$id]);
        delete_uploaded_image($row['img']);
        flash('success', 'Supprimé : ' . fem_nom($row));
    } elseif ($action === 'toggle') {
        $pdo->prepare('UPDATE equipe_feminine SET publie = 1 - publie WHERE id = ?')->execute([$id]);
        flash('success', fem_nom($row) . ($row['publie'] ? ' est masquée du site.' : ' est affichée sur le site.'));
    } elseif ($action === 'up' || $action === 'down') {
        // On renumérote le groupe (1, 2, 3...) puis on échange avec la voisine
        $l = $pdo->prepare('SELECT id FROM equipe_feminine WHERE groupe = ? ORDER BY ordre ASC, id ASC');
        $l->execute([$row['groupe']]);
        $ids = array_map('intval', $l->fetchAll(PDO::FETCH_COLUMN));
        $i = array_search($id, $ids, true);
        $j = $action === 'up' ? $i - 1 : $i + 1;
        if ($i !== false && isset($ids[$j])) {
            [$ids[$i], $ids[$j]] = [$ids[$j], $ids[$i]];
            $pdo->beginTransaction();
            $u = $pdo->prepare('UPDATE equipe_feminine SET ordre = ? WHERE id = ?');
            foreach ($ids as $k => $pid) $u->execute([$k + 1, $pid]);
            $pdo->commit();
        }
        redirect('feminine.php#f' . $id);
    }
    redirect('feminine.php#g' . (int)$row['groupe']);
}

$all = $pdo->query('SELECT * FROM equipe_feminine ORDER BY groupe ASC, ordre ASC, id ASC')->fetchAll();
$byG = [];
foreach ($all as $r) $byG[(int)$r['groupe']][] = $r;
page_header('Équipe féminine', $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><i class="fas fa-female"></i> Équipe féminine <span class="adm-count"><?= count($all) ?></span></h1>
  <a class="btn adm-btn" href="feminine_edit.php"><i class="fas fa-plus"></i> Ajouter une joueuse</a>
</div>
<p class="text-muted small">Même ordre que sur la page « Équipe féminine » du site. Les flèches changent l’ordre dans le groupe.
Nom et numéro sont facultatifs : tant qu’ils sont vides, la carte montre seulement la photo et le rôle.</p>

<?php foreach (FEM_GROUPES as $g => [$gLabel]): $list = $byG[$g] ?? []; ?>
  <h2 class="adm-h2 mt-4" id="g<?= $g ?>"><?= e($gLabel) ?> <span class="adm-count"><?= count($list) ?></span>
    <a class="btn btn-sm btn-light ml-2" href="feminine_edit.php?groupe=<?= $g ?>"><i class="fas fa-plus"></i> Ajouter ici</a></h2>
  <?php if (!$list): ?><div class="adm-card text-muted small">Personne dans ce groupe pour l’instant (le groupe n’apparaît pas sur le site).</div><?php endif; ?>
  <div class="adm-list">
  <?php foreach ($list as $i => $r): ?>
    <div class="adm-item<?= $r['publie'] ? '' : ' is-hidden' ?>" id="f<?= (int)$r['id'] ?>">
      <div class="adm-num"><?= $r['num'] !== null ? (int)$r['num'] : '–' ?></div>
      <img class="adm-thumb adm-thumb-player" src="<?= e(admin_img($r['img'] ?: 'images/player-default.png')) ?>" alt="" loading="lazy">
      <div class="adm-item-body">
        <div class="adm-item-title<?= trim($r['nom']) === '' ? ' text-muted font-italic' : '' ?>"><?= e(fem_nom($r)) ?></div>
        <div class="adm-item-title-ar" dir="rtl"><?= e($r['nom_ar'] ?? '') ?></div>
        <div class="adm-item-meta">
          <span class="adm-tag"><?= e(fem_role($r)) ?></span>
          <?php if (!$r['publie']): ?><span class="adm-badge-hidden"><i class="fas fa-eye-slash"></i> Masquée</span><?php endif; ?>
        </div>
      </div>
      <div class="adm-actions">
        <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button name="action" value="up" class="btn btn-sm btn-light" title="Monter" <?= $i === 0 ? 'disabled' : '' ?>><i class="fas fa-arrow-up"></i></button>
          <button name="action" value="down" class="btn btn-sm btn-light" title="Descendre" <?= $i === count($list) - 1 ? 'disabled' : '' ?>><i class="fas fa-arrow-down"></i></button>
          <button name="action" value="toggle" class="btn btn-sm btn-light" title="<?= $r['publie'] ? 'Masquer du site' : 'Afficher sur le site' ?>"><i class="fas <?= $r['publie'] ? 'fa-eye-slash' : 'fa-eye' ?>"></i></button>
        </form>
        <a class="btn btn-sm adm-btn" href="feminine_edit.php?id=<?= (int)$r['id'] ?>"><i class="fas fa-pen"></i> Modifier</a>
        <form method="post" onsubmit="return confirm('Supprimer définitivement <?= e(addslashes(fem_nom($r))) ?> ?\n(Pour une absence temporaire, utilisez plutôt le bouton Masquer.)');"><?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button name="action" value="delete" class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="fas fa-trash"></i></button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
<?php endforeach; ?>
<?php page_footer();
