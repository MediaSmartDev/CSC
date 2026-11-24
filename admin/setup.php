<?php
/* Première installation : crée le premier compte admin.
 * Cette page se bloque d'elle-même dès qu'un compte existe. */
require __DIR__ . '/inc/bootstrap.php';
page_header(tr('Setup'));

if (!admin_tables_ready()) { ?>
  <div class="adm-card adm-narrow">
    <h1 class="adm-h1"><?= e(tr('Setup')) ?></h1>
    <p><?= e(tr("The admin tables do not exist in the database yet.")) ?></p>
    <p><?= tr('In <b>phpMyAdmin</b>, choose the site database, open the <b>Import</b> tab and import the file %s. Then reload this page.', '<code>database/maj_2026-11-17_admin_actualites.sql</code>') ?></p>
  </div>
<?php page_footer(); exit; }

if ((int)db()->query('SELECT COUNT(*) FROM admins')->fetchColumn() > 0) { ?>
  <div class="adm-card adm-narrow">
    <h1 class="adm-h1"><?= e(tr('Setup complete')) ?></h1>
    <p><?= e(tr('An admin account already exists. This page is disabled.')) ?></p>
    <a class="btn adm-btn" href="login.php"><?= e(tr('Go to login')) ?></a>
  </div>
<?php page_footer(); exit; }

$error = null; $username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $username = trim((string)($_POST['username'] ?? ''));
    $p1 = (string)($_POST['password'] ?? ''); $p2 = (string)($_POST['password2'] ?? '');
    if (!preg_match('/^[\p{L}\p{N} ._@-]{3,50}$/u', $username)) $error = tr('Username: 3 to 50 characters (letters, numbers, space, . _ - @).');
    else $error = password_problem($p1, $p2);
    if (!$error) {
        $pdo = db();
        $pdo->beginTransaction();
        // Re-vérifie dans la transaction : un seul premier compte possible
        if ((int)$pdo->query('SELECT COUNT(*) FROM admins FOR UPDATE')->fetchColumn() === 0) {
            $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)')->execute([$username, password_hash($p1, PASSWORD_DEFAULT)]);
        }
        $pdo->commit();
        attempt_login($username, $p1);
        flash('success', tr('Account created. Welcome to the admin area!'));
        redirect('index.php');
    }
}
?>
<div class="adm-card adm-narrow">
  <h1 class="adm-h1"><i class="fas fa-user-shield"></i> <?= e(tr('Create the admin account')) ?></h1>
  <p class="text-muted"><?= e(tr("This form is used only once. Choose a strong password and keep it somewhere safe.")) ?></p>
  <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="post">
    <?= csrf_field() ?>
    <div class="form-group"><label><?= e(tr('Username')) ?></label>
      <input class="form-control" name="username" value="<?= e($username) ?>" required maxlength="50" autocomplete="username">
      <small class="text-muted"><?= e(tr('E.g. ghada (this is the name you will type to log in)')) ?></small></div>
    <div class="form-group"><label><?= e(tr('Password')) ?> <small class="text-muted"><?= e(tr('(10 characters minimum, letters and numbers)')) ?></small></label>
      <input class="form-control" type="password" name="password" required minlength="10" autocomplete="new-password"></div>
    <div class="form-group"><label><?= e(tr('Confirm password')) ?></label>
      <input class="form-control" type="password" name="password2" required minlength="10" autocomplete="new-password"></div>
    <button class="btn adm-btn btn-block" type="submit"><?= e(tr('Create the account')) ?></button>
  </form>
</div>
<?php page_footer();
