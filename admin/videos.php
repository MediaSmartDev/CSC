<?php
/* Vidéos de l'accueil : la vidéo en haut de la page (à la place de la bannière) et le bloc « Vidéos » (YouTube) */
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/medias_common.php';
$admin = require_login();
if (!reglages_ready()) medias_missing_page(tr('Videos'), $admin);
$pdo = db();

$savedHero = reglage_get('hero') ?? [];
$h = $savedHero + ['actif' => 0, 'video' => '', 'poster' => '', 'titre_fr' => '', 'titre_ar' => '', 'texte_fr' => '', 'texte_ar' => '',
                   'bouton_fr' => '', 'bouton_ar' => '', 'lien' => ''];
$editId = (int)($_GET['edit'] ?? 0);
$vid = ['id' => 0, 'lien' => '', 'titre_fr' => '', 'titre_ar' => '', 'publie' => 1];
if ($editId) {
    $st = $pdo->prepare('SELECT * FROM videos WHERE id = ?');
    $st->execute([$editId]);
    if ($r = $st->fetch()) $vid = ['id' => (int)$r['id'], 'lien' => 'https://youtu.be/' . $r['youtube_id'], 'titre_fr' => $r['titre_fr'], 'titre_ar' => (string)$r['titre_ar'], 'publie' => (int)$r['publie']];
}
$heroErrors = $vidErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string)($_POST['action'] ?? '');

    if ($action === 'hero') {                                   // ----- vidéo d'accueil
        $h['actif'] = isset($_POST['actif']) ? 1 : 0;
        foreach (['titre' => 80, 'texte' => 160, 'bouton' => 40] as $k => $max) {
            $h[$k . '_fr'] = post_txt($k . '_fr', $max);
            $h[$k . '_ar'] = post_txt($k . '_ar', $max);
        }
        $lien = post_link('lien');
        if ($lien === false) $heroErrors[] = tr('Invalid button link: an https://... address or a page of the site (e.g. joueurs.php).');
        else $h['lien'] = $lien;
        if (!$heroErrors) {
            try {
                $new = !empty($_FILES['video']) ? save_uploaded_video($_FILES['video']) : null;
                if ($new) $h['video'] = $new;
                elseif (isset($_POST['video_remove'])) $h['video'] = '';
                $poster = !empty($_FILES['poster']) ? save_uploaded_image($_FILES['poster'], ADMIN_UPLOAD_MEDIAS) : null;
                if ($poster) $h['poster'] = $poster;
                elseif (isset($_POST['poster_remove'])) $h['poster'] = '';
            } catch (RuntimeException $ex) {
                $heroErrors[] = $ex->getMessage();
            }
        }
        if (!$heroErrors && $h['actif'] && $h['video'] === '') $heroErrors[] = tr('Add a video to show it on the home page.');
        if (!$heroErrors) {
            reglage_set('hero', $h);
            foreach (['video', 'poster'] as $k) if (($savedHero[$k] ?? '') !== $h[$k]) delete_uploaded_image($savedHero[$k] ?? '');
            flash('success', $h['actif'] ? tr('Home video saved: it replaces the banner.') : tr('Home video saved: hidden, the banner stays visible.'));
            redirect('videos.php');
        }
    } elseif ($action === 'save_video') {                      // ----- ajouter / modifier une vidéo YouTube
        $vid['id'] = (int)($_POST['id'] ?? 0);
        $vid['lien'] = trim((string)($_POST['lien'] ?? ''));
        $vid['titre_fr'] = post_txt('titre_fr', 200);
        $vid['titre_ar'] = post_txt('titre_ar', 200);
        $vid['publie'] = isset($_POST['publie']) ? 1 : 0;
        $yt = youtube_id($vid['lien']);
        if (!$yt) $vidErrors[] = tr('YouTube link not recognised. Example: https://www.youtube.com/watch?v=XXXXXXXXXXX');
        if ($vid['titre_fr'] === '') $vidErrors[] = tr('The English title is required.');
        if (!$vidErrors) {
            $vals = [$yt, $vid['titre_fr'], $vid['titre_ar'] !== '' ? $vid['titre_ar'] : null, $vid['publie']];
            if ($vid['id']) {
                $pdo->prepare('UPDATE videos SET youtube_id = ?, titre_fr = ?, titre_ar = ?, publie = ? WHERE id = ?')->execute([...$vals, $vid['id']]);
                flash('success', tr('Saved: %s', $vid['titre_fr']));
            } else {
                $o = (int)$pdo->query('SELECT COALESCE(MIN(ordre), 1) - 1 FROM videos')->fetchColumn();   // la plus récente en premier
                $pdo->prepare('INSERT INTO videos (youtube_id, titre_fr, titre_ar, publie, ordre) VALUES (?, ?, ?, ?, ?)')->execute([...$vals, $o]);
                $vid['id'] = (int)$pdo->lastInsertId();
                flash('success', tr('Video added: %s', $vid['titre_fr']));
            }
            redirect('videos.php#v' . $vid['id']);
        }
    } else {                                                    // ----- actions sur une vidéo de la liste
        $id = (int)($_POST['id'] ?? 0);
        $st = $pdo->prepare('SELECT * FROM videos WHERE id = ?');
        $st->execute([$id]);
        $row = $st->fetch();
        if (!$row) { flash('danger', tr('Video not found.')); redirect('videos.php'); }
        if ($action === 'delete') {
            $pdo->prepare('DELETE FROM videos WHERE id = ?')->execute([$id]);
            flash('success', tr('Deleted: %s', $row['titre_fr']));
        } elseif ($action === 'toggle') {
            $pdo->prepare('UPDATE videos SET publie = 1 - publie WHERE id = ?')->execute([$id]);
            flash('success', $row['publie'] ? tr('%s is hidden from the site.', $row['titre_fr']) : tr('%s is shown on the site.', $row['titre_fr']));
        } elseif ($action === 'up' || $action === 'down') {
            $ids = array_map('intval', $pdo->query('SELECT id FROM videos ORDER BY ordre ASC, id DESC')->fetchAll(PDO::FETCH_COLUMN));
            $i = array_search($id, $ids, true);
            $j = $action === 'up' ? $i - 1 : $i + 1;
            if ($i !== false && isset($ids[$j])) {
                [$ids[$i], $ids[$j]] = [$ids[$j], $ids[$i]];
                $pdo->beginTransaction();
                $u = $pdo->prepare('UPDATE videos SET ordre = ? WHERE id = ?');
                foreach ($ids as $k => $vidId) $u->execute([$k + 1, $vidId]);
                $pdo->commit();
            }
        }
        redirect('videos.php#v' . $id);
    }
}

$list = $pdo->query('SELECT * FROM videos ORDER BY ordre ASC, id DESC')->fetchAll();
$heroSrc = admin_media($h['video']);
page_header(tr('Videos'), $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><i class="fas fa-video"></i> <?= e(tr('Home page videos')) ?></h1>
  <a class="btn btn-light" href="../index.php" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> <?= e(tr('View on the site')) ?></a>
</div>

<!-- ===== Vidéo d'accueil ===== -->
<h2 class="adm-h2 mt-2"><?= e(tr('Video at the top of the home page')) ?></h2>
<p class="text-muted small"><?= e(tr('It replaces the big banner, muted and looping. When turned off, the current banner stays.')) ?></p>
<?php if ($heroErrors): ?>
  <div class="alert alert-danger"><b><?= e(tr('Please fix:')) ?></b><ul class="mb-0"><?php foreach ($heroErrors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data" class="adm-form">
  <?= csrf_field() ?><input type="hidden" name="action" value="hero">
  <div class="adm-card">
    <label class="adm-switch"><input type="checkbox" name="actif" value="1" <?= $h['actif'] ? 'checked' : '' ?>> <?= e(tr('Show the video at the top of the home page')) ?></label>
  </div>
  <div class="adm-card">
    <div class="adm-img-row">
      <div class="adm-hero-preview">
        <?php if ($heroSrc): ?>
          <video src="<?= e($heroSrc) ?>" <?= admin_media($h['poster']) ? 'poster="' . e(admin_media($h['poster'])) . '"' : '' ?> autoplay muted loop playsinline></video>
        <?php else: ?>
          <img src="../images/banner-csc.jpg" alt=""><span><?= e(tr('No video yet: the banner is shown.')) ?></span>
        <?php endif; ?>
      </div>
      <div style="flex:1;min-width:260px">
        <div class="form-group"><label><?= e(tr('Video')) ?></label>
          <input type="file" name="video" accept="video/mp4,video/webm" class="form-control-file">
          <small class="text-muted d-block mt-1"><?= e(tr('MP4 or WEBM, max %s. Recommended: 15 to 30 seconds, landscape (16:9), no important text near the edges.', video_limit_label())) ?></small>
          <?php if ($h['video']): ?><label class="mt-2 small"><input type="checkbox" name="video_remove" value="1"> <?= e(tr('Remove the video')) ?></label><?php endif; ?></div>
        <div class="form-group mb-0"><label><?= e(tr('Placeholder image')) ?> <span class="text-muted small"><?= e(tr('(optional)')) ?></span></label>
          <input type="file" name="poster" accept="image/jpeg,image/png,image/webp" class="form-control-file">
          <small class="text-muted d-block mt-1"><?= e(tr('Shown while the video loads (a frame from the video, for example).')) ?></small>
          <?php if ($h['poster']): ?><label class="mt-2 small"><input type="checkbox" name="poster_remove" value="1"> <?= e(tr('Remove the placeholder image')) ?></label><?php endif; ?></div>
      </div>
    </div>
  </div>
  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Text over the video')) ?> <span class="text-muted small"><?= e(tr('(optional)')) ?></span></h2>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Title (in English)')) ?></label>
        <input class="form-control" dir="ltr" name="titre_fr" value="<?= e($h['titre_fr']) ?>" maxlength="80" placeholder="e.g. The Doyen 1898"></div>
      <div class="form-group col-md-6" dir="rtl"><label>العنوان بالعربية</label>
        <input class="form-control" name="titre_ar" value="<?= e($h['titre_ar']) ?>" maxlength="80"></div>
      <div class="form-group col-md-6"><label><?= e(tr('Subtitle (in English)')) ?></label>
        <input class="form-control" dir="ltr" name="texte_fr" value="<?= e($h['texte_fr']) ?>" maxlength="160"></div>
      <div class="form-group col-md-6" dir="rtl"><label>النص بالعربية</label>
        <input class="form-control" name="texte_ar" value="<?= e($h['texte_ar']) ?>" maxlength="160"></div>
      <div class="form-group col-md-6"><label><?= e(tr('Button (in English)')) ?></label>
        <input class="form-control" dir="ltr" name="bouton_fr" value="<?= e($h['bouton_fr']) ?>" maxlength="40" placeholder="e.g. Tickets"></div>
      <div class="form-group col-md-6" dir="rtl"><label>نص الزر بالعربية</label>
        <input class="form-control" name="bouton_ar" value="<?= e($h['bouton_ar']) ?>" maxlength="40"></div>
    </div>
    <div class="form-group mb-0"><label><?= e(tr('Button link')) ?></label>
      <input class="form-control" dir="ltr" name="lien" value="<?= e($h['lien']) ?>" maxlength="300" placeholder="https://...  ou  joueurs.php">
      <small class="text-muted"><?= e(tr('The button only appears if it has a text and a link. Without Arabic text, the Arabic site shows the English text.')) ?></small></div>
  </div>
  <div class="adm-submit"><button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> <?= e(tr('Save')) ?></button></div>
</form>

<!-- ===== Vidéos YouTube ===== -->
<h2 class="adm-h2 mt-5" id="yt"><?= e(tr('Home page “Videos” block (YouTube)')) ?> <span class="adm-count"><?= count($list) ?></span></h2>
<p class="text-muted small"><?= e(tr('Videos show as thumbnails under the news and play in a pop-up. With no video shown, the block does not appear.')) ?></p>
<?php if ($vidErrors): ?>
  <div class="alert alert-danger"><b><?= e(tr('Please fix:')) ?></b><ul class="mb-0"><?php foreach ($vidErrors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>
<form method="post" class="adm-card adm-form" id="vform">
  <?= csrf_field() ?><input type="hidden" name="action" value="save_video"><input type="hidden" name="id" value="<?= (int)$vid['id'] ?>">
  <h3 class="adm-h2" style="font-size:1rem"><?= e($vid['id'] ? tr('Edit the video') : tr('Add a video')) ?></h3>
  <div class="form-group"><label><?= e(tr('YouTube link')) ?> *</label>
    <input class="form-control" dir="ltr" name="lien" value="<?= e($vid['lien']) ?>" required maxlength="300" placeholder="https://www.youtube.com/watch?v=..."></div>
  <div class="form-row">
    <div class="form-group col-md-6"><label><?= e(tr('Title (in English)')) ?> *</label>
      <input class="form-control" dir="ltr" name="titre_fr" value="<?= e($vid['titre_fr']) ?>" required maxlength="200"></div>
    <div class="form-group col-md-6" dir="rtl"><label>العنوان بالعربية <small class="text-muted"><?= e(tr('(optional)')) ?></small></label>
      <input class="form-control" name="titre_ar" value="<?= e($vid['titre_ar']) ?>" maxlength="200"></div>
  </div>
  <label class="adm-switch"><input type="checkbox" name="publie" value="1" <?= $vid['publie'] ? 'checked' : '' ?>> <?= e(tr('Shown on the site')) ?></label>
  <div class="mt-3">
    <button class="btn adm-btn" type="submit"><i class="fas <?= $vid['id'] ? 'fa-save' : 'fa-plus' ?>"></i> <?= e($vid['id'] ? tr('Save') : tr('Add')) ?></button>
    <?php if ($vid['id']): ?><a class="btn btn-link" href="videos.php#yt"><?= e(tr('Cancel')) ?></a><?php endif; ?>
  </div>
</form>

<?php if (!$list): ?><div class="adm-card text-muted small"><?= e(tr('No videos yet.')) ?></div><?php endif; ?>
<div class="adm-list">
<?php foreach ($list as $i => $r): ?>
  <div class="adm-item<?= $r['publie'] ? '' : ' is-hidden' ?>" id="v<?= (int)$r['id'] ?>">
    <a href="https://www.youtube.com/watch?v=<?= e($r['youtube_id']) ?>" target="_blank" rel="noopener"><img class="adm-thumb" src="https://img.youtube.com/vi/<?= e($r['youtube_id']) ?>/mqdefault.jpg" alt="" loading="lazy"></a>
    <div class="adm-item-body">
      <div class="adm-item-title" dir="ltr"><?= e($r['titre_fr']) ?></div>
      <div class="adm-item-title-ar" dir="rtl"><?= e($r['titre_ar'] ?? '') ?></div>
      <div class="adm-item-meta">
        <span class="adm-tag"><i class="fab fa-youtube"></i> <?= e($r['youtube_id']) ?></span>
        <?php if (!$r['publie']): ?><span class="adm-badge-hidden"><i class="fas fa-eye-slash"></i> <?= e(tr('Hidden')) ?></span><?php endif; ?>
      </div>
    </div>
    <div class="adm-actions">
      <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
        <button name="action" value="up" class="btn btn-sm btn-light" title="<?= e(tr('Move up')) ?>" <?= $i === 0 ? 'disabled' : '' ?>><i class="fas fa-arrow-up"></i></button>
        <button name="action" value="down" class="btn btn-sm btn-light" title="<?= e(tr('Move down')) ?>" <?= $i === count($list) - 1 ? 'disabled' : '' ?>><i class="fas fa-arrow-down"></i></button>
        <button name="action" value="toggle" class="btn btn-sm btn-light" title="<?= e($r['publie'] ? tr('Hide from the site') : tr('Show on the site')) ?>"><i class="fas <?= $r['publie'] ? 'fa-eye-slash' : 'fa-eye' ?>"></i></button>
      </form>
      <a class="btn btn-sm adm-btn" href="videos.php?edit=<?= (int)$r['id'] ?>#vform"><i class="fas fa-pen"></i> <?= e(tr('Edit')) ?></a>
      <form method="post" onsubmit="return confirm(<?= trjs('Permanently delete %s?', $r['titre_fr']) ?>);"><?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
        <button name="action" value="delete" class="btn btn-sm btn-outline-danger" title="<?= e(tr('Delete')) ?>"><i class="fas fa-trash"></i></button>
      </form>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php page_footer();
