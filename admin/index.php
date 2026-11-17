<?php
/* Liste des actualités + actions rapides (monter/descendre, publier, supprimer) */
require __DIR__ . '/inc/bootstrap.php';
$admin = require_login();
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $action = (string)($_POST['action'] ?? '');
    $st = $pdo->prepare('SELECT * FROM actualites WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) { flash('danger', 'Actualité introuvable.'); redirect('index.php'); }

    if ($action === 'delete') {
        $pdo->prepare('DELETE FROM actualites WHERE id = ?')->execute([$id]);
        delete_uploaded_image($row['image']);
        foreach (preg_split('/\R/', (string)$row['galerie']) as $g) delete_uploaded_image(trim($g));
        flash('success', 'Actualité supprimée : ' . $row['titre_fr']);
    } elseif ($action === 'toggle') {
        $pdo->prepare('UPDATE actualites SET publie = 1 - publie WHERE id = ?')->execute([$id]);
        flash('success', $row['publie'] ? 'Actualité masquée (elle n’apparaît plus sur le site).' : 'Actualité publiée sur le site.');
    } elseif ($action === 'up' || $action === 'down') {
        // Échange de position avec la voisine du dessus / du dessous
        $sql = $action === 'up'
            ? 'SELECT id, position FROM actualites WHERE (position > ? OR (position = ? AND id > ?)) ORDER BY position ASC, id ASC LIMIT 1'
            : 'SELECT id, position FROM actualites WHERE (position < ? OR (position = ? AND id < ?)) ORDER BY position DESC, id DESC LIMIT 1';
        $n = $pdo->prepare($sql);
        $n->execute([$row['position'], $row['position'], $id]);
        if ($other = $n->fetch()) {
            $pdo->beginTransaction();
            $newMine = (int)$other['position']; $newOther = (int)$row['position'];
            if ($newMine === $newOther) { $newMine += ($action === 'up' ? 1 : -1); }
            $pdo->prepare('UPDATE actualites SET position = ? WHERE id = ?')->execute([$newMine, $id]);
            $pdo->prepare('UPDATE actualites SET position = ? WHERE id = ?')->execute([$newOther, $other['id']]);
            $pdo->commit();
        }
        redirect('index.php#n' . $id);
    }
    redirect('index.php');
}

$rows = $pdo->query('SELECT id, position, date_pub, image, label_fr, titre_fr, titre_ar, publie, updated_at FROM actualites ORDER BY position DESC, id DESC')->fetchAll();
page_header('Actualités', $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><i class="fas fa-newspaper"></i> Actualités <span class="adm-count"><?= count($rows) ?></span></h1>
  <a class="btn adm-btn" href="edit.php"><i class="fas fa-plus"></i> Ajouter une actualité</a>
</div>
<p class="text-muted small">L’ordre ci-dessous est celui du site : la première est affichée en premier. Les flèches changent l’ordre.</p>

<?php if (!$rows): ?>
  <div class="adm-card text-center">Aucune actualité pour l’instant. <a href="edit.php">Ajouter la première</a>.</div>
<?php endif; ?>

<div class="adm-list">
<?php foreach ($rows as $i => $r): ?>
  <div class="adm-item<?= $r['publie'] ? '' : ' is-hidden' ?>" id="n<?= (int)$r['id'] ?>">
    <img class="adm-thumb" src="<?= e(admin_img($r['image'])) ?>" alt="" loading="lazy">
    <div class="adm-item-body">
      <div class="adm-item-meta">
        <?php if ($r['label_fr'] !== ''): ?><span class="adm-tag"><?= e($r['label_fr']) ?></span><?php endif; ?>
        <span><i class="far fa-calendar-alt"></i> <?= $r['date_pub'] ? e(date('d/m/Y', strtotime($r['date_pub']))) : 'sans date' ?></span>
        <?php if (!$r['publie']): ?><span class="adm-badge-hidden"><i class="fas fa-eye-slash"></i> Masquée</span><?php endif; ?>
      </div>
      <div class="adm-item-title"><?= e($r['titre_fr']) ?></div>
      <div class="adm-item-title-ar" dir="rtl"><?= e($r['titre_ar']) ?></div>
    </div>
    <div class="adm-actions">
      <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
        <button name="action" value="up" class="btn btn-sm btn-light" title="Monter" <?= $i === 0 ? 'disabled' : '' ?>><i class="fas fa-arrow-up"></i></button>
        <button name="action" value="down" class="btn btn-sm btn-light" title="Descendre" <?= $i === count($rows) - 1 ? 'disabled' : '' ?>><i class="fas fa-arrow-down"></i></button>
        <button name="action" value="toggle" class="btn btn-sm btn-light" title="<?= $r['publie'] ? 'Masquer du site' : 'Publier sur le site' ?>"><i class="fas <?= $r['publie'] ? 'fa-eye-slash' : 'fa-eye' ?>"></i></button>
      </form>
      <a class="btn btn-sm adm-btn" href="edit.php?id=<?= (int)$r['id'] ?>"><i class="fas fa-pen"></i> Modifier</a>
      <?php if ($r['publie']): ?><a class="btn btn-sm btn-light" href="../actualite.php?id=<?= (int)$r['id'] ?>" target="_blank" rel="noopener" title="Voir sur le site"><i class="fas fa-external-link-alt"></i></a><?php endif; ?>
      <form method="post" onsubmit="return confirm('Supprimer définitivement cette actualité ?');"><?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
        <button name="action" value="delete" class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="fas fa-trash"></i></button>
      </form>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php page_footer();
