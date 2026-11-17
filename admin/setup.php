<?php
/* Première installation : crée le premier compte admin.
 * Cette page se bloque d'elle-même dès qu'un compte existe. */
require __DIR__ . '/inc/bootstrap.php';
page_header('Installation');

if (!admin_tables_ready()) { ?>
  <div class="adm-card adm-narrow">
    <h1 class="adm-h1">Installation</h1>
    <p>Les tables de l'espace admin n'existent pas encore dans la base.</p>
    <p>Dans <b>phpMyAdmin</b>, choisissez la base du site, onglet <b>Importer</b>, et importez le fichier
       <code>database/maj_2026-11-17_admin_actualites.sql</code>. Rechargez ensuite cette page.</p>
  </div>
<?php page_footer(); exit; }

if ((int)db()->query('SELECT COUNT(*) FROM admins')->fetchColumn() > 0) { ?>
  <div class="adm-card adm-narrow">
    <h1 class="adm-h1">Installation terminée</h1>
    <p>Un compte admin existe déjà. Cette page est désactivée.</p>
    <a class="btn adm-btn" href="login.php">Aller à la connexion</a>
  </div>
<?php page_footer(); exit; }

$error = null; $username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $username = trim((string)($_POST['username'] ?? ''));
    $p1 = (string)($_POST['password'] ?? ''); $p2 = (string)($_POST['password2'] ?? '');
    if (!preg_match('/^[\p{L}\p{N} ._@-]{3,50}$/u', $username)) $error = "Identifiant : 3 à 50 caractères (lettres, chiffres, espace, . _ - @).";
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
        flash('success', 'Compte créé. Bienvenue dans l’espace admin !');
        redirect('index.php');
    }
}
?>
<div class="adm-card adm-narrow">
  <h1 class="adm-h1"><i class="fas fa-user-shield"></i> Créer le compte admin</h1>
  <p class="text-muted">Ce formulaire ne sert qu'une seule fois. Choisissez un mot de passe solide et gardez-le en lieu sûr.</p>
  <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="post">
    <?= csrf_field() ?>
    <div class="form-group"><label>Identifiant</label>
      <input class="form-control" name="username" value="<?= e($username) ?>" required maxlength="50" autocomplete="username">
      <small class="text-muted">Ex. : ghada (c’est ce nom qu’il faudra taper pour se connecter)</small></div>
    <div class="form-group"><label>Mot de passe <small class="text-muted">(10 caractères minimum, lettres et chiffres)</small></label>
      <input class="form-control" type="password" name="password" required minlength="10" autocomplete="new-password"></div>
    <div class="form-group"><label>Confirmer le mot de passe</label>
      <input class="form-control" type="password" name="password2" required minlength="10" autocomplete="new-password"></div>
    <button class="btn adm-btn btn-block" type="submit">Créer le compte</button>
  </form>
</div>
<?php page_footer();
