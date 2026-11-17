<?php
/* =====================================================================
 * Espace admin CSC : session, connexion, protection CSRF, envoi d'images.
 * Inclus en haut de chaque page de admin/.
 * ===================================================================== */
declare(strict_types=1);

require_once __DIR__ . '/../../Data/news.php';
date_default_timezone_set('Africa/Algiers');

const ADMIN_IDLE_TIMEOUT = 7200;          // déconnexion après 2 h sans activité
const ADMIN_MAX_ATTEMPTS = 5;             // essais de mot de passe ratés...
const ADMIN_LOCK_MINUTES = 15;            // ... avant blocage pendant 15 minutes
const ADMIN_UPLOAD_DIR   = 'uploads/actualites';   // relatif à la racine du site
const ADMIN_IMG_MAX_W    = 1600;          // largeur max des images (redimensionnées)
const ADMIN_IMG_MAX_BYTES = 8 * 1024 * 1024;

/* ---------- En-têtes de sécurité ---------- */
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('X-Robots-Tag: noindex, nofollow');

/* ---------- Session ---------- */
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
      || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
session_name('csc_admin');
session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'secure' => $https, 'httponly' => true, 'samesite' => 'Strict']);
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
session_start();

if (!empty($_SESSION['admin_id']) && (time() - ($_SESSION['last_seen'] ?? 0)) > ADMIN_IDLE_TIMEOUT) {
    $_SESSION = [];
    session_regenerate_id(true);
    $_SESSION['flash'] = ['warning', 'Session expirée, merci de vous reconnecter.'];
}

/* ---------- Petits outils ---------- */
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function db(): PDO {
    $pdo = csc_pdo();
    if (!$pdo) {
        http_response_code(503);
        exit('Base de données injoignable. Vérifiez Data/config.php.');
    }
    return $pdo;
}

/** Les tables de l'espace admin existent-elles ? (SQL importé) */
function admin_tables_ready(): bool {
    try { db()->query('SELECT 1 FROM admins LIMIT 1'); db()->query('SELECT 1 FROM actualites LIMIT 1'); return true; }
    catch (PDOException $e) { return false; }
}

function redirect(string $url): never { header('Location: ' . $url); exit; }

function flash(string $type, string $msg): void { $_SESSION['flash'] = [$type, $msg]; }

function client_ip(): string { return substr((string)($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'), 0, 45); }

/* ---------- CSRF ---------- */
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_field(): string { return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">'; }
function csrf_check(): void {
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') return;
    // Fichier trop gros pour PHP : $_POST arrive vide
    if (empty($_POST) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
        flash('danger', 'Envoi trop volumineux (limite du serveur : ' . upload_limit_label() . '). Essayez avec des images plus légères.');
        redirect($_SERVER['REQUEST_URI'] ?? 'index.php');
    }
    $t = $_POST['csrf'] ?? '';
    if (!is_string($t) || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $t)) {
        http_response_code(400);
        exit('Requête refusée (jeton de sécurité invalide). Rechargez la page et réessayez.');
    }
}

/* ---------- Connexion ---------- */
function current_admin(): ?array {
    static $admin = false;
    if ($admin !== false) return $admin;
    $admin = null;
    if (!empty($_SESSION['admin_id'])) {
        $st = db()->prepare('SELECT id, username FROM admins WHERE id = ?');
        $st->execute([(int)$_SESSION['admin_id']]);
        $admin = $st->fetch() ?: null;
        if ($admin) $_SESSION['last_seen'] = time();
        else unset($_SESSION['admin_id']);
    }
    return $admin;
}

/** À appeler en haut de chaque page protégée */
function require_login(): array {
    if (!admin_tables_ready()) redirect('setup.php');
    $a = current_admin();
    if (!$a) redirect('login.php');
    csrf_check();
    return $a;
}

function login_is_locked(): bool {
    $st = db()->prepare('SELECT COUNT(*) FROM admin_login_attempts WHERE ip = ? AND attempted_at > (NOW() - INTERVAL ' . ADMIN_LOCK_MINUTES . ' MINUTE)');
    $st->execute([client_ip()]);
    return (int)$st->fetchColumn() >= ADMIN_MAX_ATTEMPTS;
}

function attempt_login(string $username, string $password): bool {
    $st = db()->prepare('SELECT id, password_hash FROM admins WHERE username = ?');
    $st->execute([$username]);
    $row = $st->fetch();
    // Même durée de calcul que le compte existe ou non
    $hash = $row['password_hash'] ?? password_hash(random_bytes(12), PASSWORD_DEFAULT);
    $ok = $row && password_verify($password, $hash);
    if (!$ok) {
        db()->prepare('INSERT INTO admin_login_attempts (ip) VALUES (?)')->execute([client_ip()]);
        db()->exec('DELETE FROM admin_login_attempts WHERE attempted_at < (NOW() - INTERVAL 1 DAY)');
        return false;
    }
    if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
        db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')->execute([password_hash($password, PASSWORD_DEFAULT), $row['id']]);
    }
    db()->prepare('DELETE FROM admin_login_attempts WHERE ip = ?')->execute([client_ip()]);
    db()->prepare('UPDATE admins SET last_login = NOW() WHERE id = ?')->execute([$row['id']]);
    session_regenerate_id(true);
    $_SESSION['admin_id'] = (int)$row['id'];
    $_SESSION['last_seen'] = time();
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return true;
}

/** Règles du mot de passe ; renvoie un message d'erreur ou null */
function password_problem(string $p, string $confirm): ?string {
    if (mb_strlen($p) < 10) return 'Le mot de passe doit faire au moins 10 caractères.';
    if (!preg_match('/[A-Za-z]/', $p) || !preg_match('/\d/', $p)) return 'Le mot de passe doit contenir des lettres et des chiffres.';
    if ($p !== $confirm) return 'Les deux mots de passe ne sont pas identiques.';
    return null;
}

/* ---------- Images ---------- */
function ini_bytes(string $v): int {
    $v = trim($v); $n = (int)$v;
    switch (strtolower(substr($v, -1))) { case 'g': $n *= 1024; case 'm': $n *= 1024; case 'k': $n *= 1024; }
    return $n;
}
function upload_limit_bytes(): int {
    $l = [ADMIN_IMG_MAX_BYTES, ini_bytes((string)ini_get('upload_max_filesize'))];
    return min(array_filter($l, fn($x) => $x > 0));
}
function upload_limit_label(): string { return round(upload_limit_bytes() / 1048576, 1) . ' Mo'; }

/** Dossier d'envoi (créé au besoin, avec un .htaccess qui interdit d'y exécuter du code) */
function upload_dir_abs(): string {
    $dir = dirname(__DIR__, 2) . '/' . ADMIN_UPLOAD_DIR;
    if (!is_dir($dir) && !@mkdir($dir, 0755, true)) throw new RuntimeException("Impossible de créer le dossier " . ADMIN_UPLOAD_DIR . " : vérifiez les droits d'écriture.");
    $root = dirname(__DIR__, 2) . '/uploads';
    if (!file_exists($root . '/.htaccess')) {
        @file_put_contents($root . '/.htaccess',
            "# Images envoyées depuis l'espace admin : aucun script ne doit s'exécuter ici\n"
          . "Options -Indexes -ExecCGI\n"
          . "<IfModule mod_php.c>\n  php_flag engine off\n</IfModule>\n"
          . "<IfModule mod_php7.c>\n  php_flag engine off\n</IfModule>\n"
          . "<IfModule mod_php8.c>\n  php_flag engine off\n</IfModule>\n"
          . "RemoveHandler .php .phtml .php3 .php4 .php5 .php7 .php8 .phar .pl .py .cgi .sh\n"
          . "RemoveType .php .phtml .php3 .php4 .php5 .php7 .php8 .phar\n"
          . "<FilesMatch \"(?i)\\.(php\\d?|phtml|phar|pl|py|cgi|sh|html?|svg|js)$\">\n  Require all denied\n</FilesMatch>\n");
    }
    if (!is_writable($dir)) throw new RuntimeException("Le dossier " . ADMIN_UPLOAD_DIR . " n'est pas accessible en écriture.");
    return $dir;
}

/**
 * Enregistre une image envoyée ($_FILES[...] d'un seul fichier).
 * Renvoie le chemin relatif (ex. uploads/actualites/20261117-ab12cd34.jpg),
 * null si aucun fichier, ou lève une RuntimeException avec un message clair.
 */
function save_uploaded_image(array $f): ?string {
    $err = $f['error'] ?? UPLOAD_ERR_NO_FILE;
    if ($err === UPLOAD_ERR_NO_FILE) return null;
    if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) throw new RuntimeException('Image trop lourde (max ' . upload_limit_label() . ').');
    if ($err !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name'])) throw new RuntimeException("L'envoi de l'image a échoué (code $err).");
    if ($f['size'] > upload_limit_bytes()) throw new RuntimeException('Image trop lourde (max ' . upload_limit_label() . ').');

    // Le vrai type du fichier (on ne fait pas confiance au nom ni au navigateur)
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? null;
    $info = @getimagesize($f['tmp_name']);
    if (!$ext || !$info || $info[0] < 1 || $info[1] < 1) throw new RuntimeException('Format non accepté : envoyez une image JPG, PNG ou WEBP.');
    if ($info[0] * $info[1] > 40000000) throw new RuntimeException('Image trop grande (dimensions).');

    $dir = upload_dir_abs();
    $name = date('Ymd') . '-' . bin2hex(random_bytes(8));

    // Avec GD : on ré-encode l'image (supprime tout contenu caché) et on la réduit si besoin
    if (extension_loaded('gd')) {
        $src = match ($ext) {
            'jpg'  => @imagecreatefromjpeg($f['tmp_name']),
            'png'  => @imagecreatefrompng($f['tmp_name']),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($f['tmp_name']) : false,
        };
        if (!$src) throw new RuntimeException("Image illisible ou abîmée.");
        if ($ext === 'jpg' && function_exists('exif_read_data')) {           // photos de téléphone : bonne orientation
            $o = (int)(@exif_read_data($f['tmp_name'])['Orientation'] ?? 1);
            $rot = [3 => 180, 6 => -90, 8 => 90][$o] ?? 0;
            if ($rot) { $r = imagerotate($src, $rot, 0); if ($r) { imagedestroy($src); $src = $r; } }
        }
        $w = imagesx($src); $h = imagesy($src);
        if ($w > ADMIN_IMG_MAX_W) {
            $nh = (int)round($h * ADMIN_IMG_MAX_W / $w);
            $dst = imagecreatetruecolor(ADMIN_IMG_MAX_W, $nh);
            if ($ext !== 'jpg') { imagealphablending($dst, false); imagesavealpha($dst, true); }
            imagecopyresampled($dst, $src, 0, 0, 0, 0, ADMIN_IMG_MAX_W, $nh, $w, $h);
            imagedestroy($src); $src = $dst;
        }
        if ($ext === 'webp' && !function_exists('imagewebp')) $ext = 'jpg';
        $path = "$dir/$name.$ext";
        $ok = match ($ext) {
            'jpg'  => imagejpeg($src, $path, 85),
            'png'  => (imagesavealpha($src, true) && imagepng($src, $path, 6)),
            'webp' => imagewebp($src, $path, 85),
        };
        imagedestroy($src);
        if (!$ok) throw new RuntimeException("Impossible d'enregistrer l'image.");
    } else {
        $path = "$dir/$name.$ext";
        if (!move_uploaded_file($f['tmp_name'], $path)) throw new RuntimeException("Impossible d'enregistrer l'image.");
    }
    @chmod($path, 0644);
    return ADMIN_UPLOAD_DIR . "/$name.$ext";
}

/** Transforme $_FILES['x'] (envoi multiple) en liste de fichiers */
function files_list(string $field): array {
    $f = $_FILES[$field] ?? null;
    if (!$f || !is_array($f['name'])) return [];
    $out = [];
    foreach ($f['name'] as $i => $_) {
        $out[] = ['name' => $f['name'][$i], 'type' => $f['type'][$i], 'tmp_name' => $f['tmp_name'][$i], 'error' => $f['error'][$i], 'size' => $f['size'][$i]];
    }
    return $out;
}

/** Supprime une image seulement si elle a été envoyée depuis l'admin (jamais les images du dépôt Git) */
function delete_uploaded_image(?string $rel): void {
    if (!$rel || !preg_match('#^' . preg_quote(ADMIN_UPLOAD_DIR, '#') . '/[A-Za-z0-9-]+\.(jpg|png|webp)$#', $rel)) return;
    $n = db()->prepare('SELECT COUNT(*) FROM actualites WHERE image = ? OR galerie LIKE ?');
    $n->execute([$rel, '%' . $rel . '%']);
    if ((int)$n->fetchColumn() === 0) @unlink(dirname(__DIR__, 2) . '/' . $rel);
}

/** Chemin d'image utilisable depuis admin/ */
function admin_img(?string $p): string {
    if ($p && preg_match('#^https?://#', $p)) return $p;
    return ($p && is_file(dirname(__DIR__, 2) . '/' . $p)) ? '../' . $p : '../images/banner-csc.jpg';
}

/* ---------- Mise en page ---------- */
function page_header(string $title, ?array $admin = null): void { ?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($title) ?> · Admin CSC</title>
<link rel="icon" href="../images/fav.png" type="image/png">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/fontawesome.css">
<link rel="stylesheet" href="assets/admin.css">
</head>
<body>
<nav class="adm-nav">
  <div class="container adm-nav-in">
    <a class="adm-brand" href="index.php"><img src="../images/logo-csc.png" alt=""> Admin CSC</a>
    <?php if ($admin): ?>
    <div class="adm-links">
      <a href="index.php"><i class="fas fa-newspaper"></i> Actualités</a>
      <a href="password.php"><i class="fas fa-key"></i> Mot de passe</a>
      <a href="../index.php" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> Voir le site</a>
      <form method="post" action="logout.php" class="d-inline"><?= csrf_field() ?>
        <button type="submit" class="adm-logout"><i class="fas fa-sign-out-alt"></i> Déconnexion (<?= e($admin['username']) ?>)</button>
      </form>
    </div>
    <?php endif; ?>
  </div>
</nav>
<main class="container adm-main">
<?php
    if (!empty($_SESSION['flash'])) {
        [$t, $m] = $_SESSION['flash']; unset($_SESSION['flash']);
        echo '<div class="alert alert-' . e($t) . '">' . e($m) . '</div>';
    }
}

function page_footer(): void { ?>
</main>
<footer class="adm-foot">CS Constantine · espace d'administration</footer>
</body>
</html>
<?php }
