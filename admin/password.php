<?php
require __DIR__ . '/inc/bootstrap.php';
$admin = require_login();
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $st = db()->prepare('SELECT password_hash FROM admins WHERE id = ?');
    $st->execute([$admin['id']]);
    if (!password_verify((string)($_POST['current'] ?? ''), (string)$st->fetchColumn())) {
        $error = tr('Mot de passe actuel incorrect.');
    } else {
        $error = password_problem((string)($_POST['password'] ?? ''), (string)($_POST['password2'] ?? ''));
    }
    if (!$error) {
        db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')->execute([password_hash((string)$_POST['password'], PASSWORD_DEFAULT), $admin['id']]);
        session_regenerate_id(true);
        flash('success', tr('Mot de passe modifié.'));
        redirect('index.php');
    }
}
page_header(tr('Mot de passe'), $admin);
?>
<div class="adm-card adm-narrow">
  <h1 class="adm-h1"><i class="fas fa-key"></i> <?= e(tr('Changer le mot de passe')) ?></h1>
  <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="post">
    <?= csrf_field() ?>
    <div class="form-group"><label><?= e(tr('Mot de passe actuel')) ?></label>
      <input class="form-control" type="password" name="current" required autocomplete="current-password"></div>
    <div class="form-group"><label><?= e(tr('Nouveau mot de passe')) ?> <small class="text-muted"><?= e(tr('(10 caractères minimum, lettres et chiffres)')) ?></small></label>
      <input class="form-control" type="password" name="password" required minlength="10" autocomplete="new-password"></div>
    <div class="form-group"><label><?= e(tr('Confirmer')) ?></label>
      <input class="form-control" type="password" name="password2" required minlength="10" autocomplete="new-password"></div>
    <button class="btn adm-btn" type="submit"><?= e(tr('Enregistrer')) ?></button>
    <a class="btn btn-link" href="index.php"><?= e(tr('Annuler')) ?></a>
  </form>
</div>
<?php page_footer();
