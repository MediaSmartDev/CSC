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
        $error = tr('Too many attempts. Try again in %s minutes.', ADMIN_LOCK_MINUTES);
    } elseif ($username === '' || $password === '' || !attempt_login($username, $password)) {
        $error = tr('Incorrect username or password.');
    } else {
        redirect('index.php');
    }
}
page_header(tr('Login'));
?>
<div class="adm-card adm-narrow">
  <h1 class="adm-h1"><i class="fas fa-lock"></i> <?= e(tr('Login')) ?></h1>
  <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="post" autocomplete="on">
    <?= csrf_field() ?>
    <div class="form-group">
      <label for="u"><?= e(tr('Username')) ?></label>
      <input class="form-control" id="u" name="username" value="<?= e($username) ?>" required autofocus autocomplete="username" maxlength="50">
    </div>
    <div class="form-group">
      <label for="p"><?= e(tr('Password')) ?></label>
      <input class="form-control" id="p" type="password" name="password" required autocomplete="current-password">
    </div>
    <button class="btn adm-btn btn-block" type="submit"><?= e(tr('Log in')) ?></button>
  </form>
</div>
<?php page_footer();
