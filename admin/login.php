<?php
require __DIR__ . '/inc/bootstrap.php';
if (!admin_tables_ready()) redirect('setup.php');
if (current_admin()) redirect('index.php');
$nAdmins = (int)db()->query('SELECT COUNT(*) FROM admins')->fetchColumn();
if ($nAdmins === 0) redirect('setup.php');

$error = null;
$username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    if (login_is_locked()) {
        $error = 'Trop de tentatives. Réessayez dans ' . ADMIN_LOCK_MINUTES . ' minutes.';
    } elseif ($username === '' || $password === '' || !attempt_login($username, $password)) {
        $error = 'Identifiant ou mot de passe incorrect.';
    } else {
        redirect('index.php');
    }
}
page_header('Connexion');
?>
<div class="adm-card adm-narrow">
  <h1 class="adm-h1"><i class="fas fa-lock"></i> Connexion</h1>
  <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="post" autocomplete="on">
    <?= csrf_field() ?>
    <div class="form-group">
      <label for="u">Identifiant</label>
      <input class="form-control" id="u" name="username" value="<?= e($username) ?>" required autofocus autocomplete="username" maxlength="50">
    </div>
    <div class="form-group">
      <label for="p">Mot de passe</label>
      <input class="form-control" id="p" type="password" name="password" required autocomplete="current-password">
    </div>
    <button class="btn adm-btn btn-block" type="submit">Se connecter</button>
  </form>
</div>
<?php page_footer();
