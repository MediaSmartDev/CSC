<?php
/* Bande publicitaire fixe en bas de toutes les pages : image ou vidéo, lien, affichée ou non */
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/medias_common.php';
$admin = require_login();
if (!reglages_ready()) medias_missing_page(tr('Advertising'), $admin);

$saved = reglage_get('pub');
if ($saved === null) {                       // pas encore réglée ici : on part de Data/pub.php
    $f = require dirname(__DIR__) . '/Data/pub.php';
    $saved = ['actif' => !empty($f['actif']) ? 1 : 0, 'type' => $f['type'] ?? 'image', 'fichier' => $f['fichier'] ?? '',
              'poster' => $f['poster'] ?? '', 'lien' => $f['lien'] ?? '', 'alt_fr' => $f['alt'] ?? '', 'alt_ar' => ''];
}
$v = $saved + ['actif' => 0, 'type' => 'image', 'fichier' => '', 'poster' => '', 'lien' => '', 'alt_fr' => '', 'alt_ar' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v['actif'] = isset($_POST['actif']) ? 1 : 0;
    $v['alt_fr'] = post_txt('alt_fr', 150);
    $v['alt_ar'] = post_txt('alt_ar', 150);
    $lien = post_link('lien');
    if ($lien === false) $errors[] = tr('Invalid link: paste an address that starts with https://');
    else $v['lien'] = $lien;

    if (!$errors) {
        try {
            $up = $_FILES['fichier'] ?? null;
            if ($up && ($up['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK && is_uploaded_file($up['tmp_name'])
                && str_starts_with((string)(new finfo(FILEINFO_MIME_TYPE))->file($up['tmp_name']), 'video/')) {
                $new = save_uploaded_video($up);
                $type = 'video';
            } else {
                $new = $up ? save_uploaded_image($up, ADMIN_UPLOAD_MEDIAS) : null;
                $type = 'image';
            }
            if ($new) { $v['fichier'] = $new; $v['type'] = $type; if ($type === 'image') $v['poster'] = ''; }
            $poster = !empty($_FILES['poster']) ? save_uploaded_image($_FILES['poster'], ADMIN_UPLOAD_MEDIAS) : null;
            if ($poster) $v['poster'] = $poster;
            elseif (isset($_POST['poster_remove'])) $v['poster'] = '';
        } catch (RuntimeException $ex) {
            $errors[] = $ex->getMessage();
        }
    }
    if (!$errors && $v['actif'] && $v['fichier'] === '') $errors[] = tr('Add an image or a video to show the bar.');

    if (!$errors) {
        reglage_set('pub', $v);
        foreach (['fichier', 'poster'] as $k) if (($saved[$k] ?? '') !== $v[$k]) delete_uploaded_image($saved[$k] ?? '');
        flash('success', $v['actif'] ? tr('Ad saved: visible at the bottom of every page.') : tr('Ad saved: hidden from the site.'));
        redirect('pub.php');
    }
}

$src = admin_media($v['fichier']);
page_header(tr('Advertising'), $admin);
?>
<div class="adm-head">
  <h1 class="adm-h1"><i class="fas fa-bullhorn"></i> <?= e(tr('Advertising bar')) ?></h1>
  <a class="btn btn-light" href="../index.php" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> <?= e(tr('View on the site')) ?></a>
</div>
<p class="text-muted small"><?= e(tr('The bar stays at the bottom of every page of the site. Visitors can close it with the cross.')) ?></p>

<?php if ($errors): ?>
  <div class="alert alert-danger"><b><?= e(tr('Please fix:')) ?></b><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="adm-form">
  <?= csrf_field() ?>
  <div class="adm-card">
    <label class="adm-switch"><input type="checkbox" name="actif" value="1" <?= $v['actif'] ? 'checked' : '' ?>> <?= e(tr('Show the advertising bar on the site')) ?></label>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Image or video')) ?></h2>
    <div class="adm-pub-preview">
      <?php if ($src && $v['type'] === 'video'): ?>
        <video src="<?= e($src) ?>" <?= admin_media($v['poster']) ? 'poster="' . e(admin_media($v['poster'])) . '"' : '' ?> autoplay muted loop playsinline></video>
      <?php elseif ($src): ?>
        <img src="<?= e($src) ?>" alt="">
      <?php else: ?>
        <div class="text-muted small p-3"><?= e(tr('No file yet.')) ?></div>
      <?php endif; ?>
    </div>
    <div class="form-group mt-3"><label><?= e(tr('Replace with')) ?></label>
      <input type="file" name="fichier" accept="image/jpeg,image/png,image/webp,video/mp4,video/webm" class="form-control-file">
      <small class="text-muted d-block mt-1"><?= e(tr('JPG, PNG or WEBP image (max %1$s) or MP4 / WEBM video (max %2$s). Recommended size: horizontal strip 1920 × 96.', upload_limit_label(), video_limit_label())) ?></small></div>
    <?php if ($v['type'] === 'video'): ?>
    <div class="form-group"><label><?= e(tr('Video placeholder image')) ?> <span class="text-muted small"><?= e(tr('(optional)')) ?></span></label>
      <input type="file" name="poster" accept="image/jpeg,image/png,image/webp" class="form-control-file">
      <small class="text-muted d-block mt-1"><?= e(tr('Shown while the video loads.')) ?></small>
      <?php if ($v['poster']): ?><label class="mt-2 small"><input type="checkbox" name="poster_remove" value="1"> <?= e(tr('Remove the placeholder image')) ?></label><?php endif; ?></div>
    <?php endif; ?>
  </div>

  <div class="adm-card">
    <h2 class="adm-h2"><?= e(tr('Link and description')) ?></h2>
    <div class="form-group"><label><?= e(tr('Link on click')) ?> <span class="text-muted small"><?= e(tr('(optional)')) ?></span></label>
      <input class="form-control" dir="ltr" name="lien" value="<?= e($v['lien']) ?>" maxlength="300" placeholder="https://">
      <small class="text-muted"><?= e(tr('Page opened when someone clicks the ad (the advertiser’s site). Empty = no link.')) ?></small></div>
    <div class="form-row">
      <div class="form-group col-md-6"><label><?= e(tr('Description (in English)')) ?></label>
        <input class="form-control" dir="ltr" name="alt_fr" value="<?= e($v['alt_fr']) ?>" maxlength="150" placeholder="e.g. Ooredoo, official partner"></div>
      <div class="form-group col-md-6" dir="rtl"><label>الوصف بالعربية <small class="text-muted"><?= e(tr('(optional)')) ?></small></label>
        <input class="form-control" name="alt_ar" value="<?= e($v['alt_ar']) ?>" maxlength="150"></div>
    </div>
    <small class="text-muted"><?= e(tr('Read by screen readers and search engines.')) ?></small>
  </div>

  <div class="adm-submit">
    <button class="btn adm-btn btn-lg" type="submit"><i class="fas fa-save"></i> <?= e(tr('Save')) ?></button>
  </div>
</form>
<?php page_footer();
