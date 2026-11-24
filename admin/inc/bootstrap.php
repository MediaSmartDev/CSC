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
const ADMIN_UPLOAD_JOUEURS = 'uploads/joueurs';
const ADMIN_UPLOAD_SPONSORS = 'uploads/sponsors';
const ADMIN_UPLOAD_FEMININE = 'uploads/feminine';
const ADMIN_UPLOAD_JEUNES = 'uploads/jeunes';
const ADMIN_UPLOAD_MEDIAS = 'uploads/medias';   // vidéo d'accueil, publicité
const ADMIN_VIDEO_MAX_BYTES = 60 * 1024 * 1024;
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
    $_SESSION['flash'] = ['warning', tr('Session expired, please log in again.')];
}

/* Changement de langue : ?alang=ar ou ?alang=en (retenu un an dans un cookie) */
if (isset($_GET['alang']) && in_array($_GET['alang'], ['en', 'ar'], true) && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
    setcookie('csc_admin_lang', $_GET['alang'], ['expires' => time() + 31536000, 'path' => '/', 'secure' => $https, 'httponly' => true, 'samesite' => 'Lax']);
    $q = $_GET; unset($q['alang']);
    header('Location: ' . basename((string)($_SERVER['SCRIPT_NAME'] ?? 'index.php')) . ($q ? '?' . http_build_query($q) : ''));
    exit;
}

/* ---------- Petits outils ---------- */
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/* ---------- Langue de l'interface admin (anglais / arabe) ---------- */
function admin_lang(): string { return ($_COOKIE['csc_admin_lang'] ?? '') === 'ar' ? 'ar' : 'en'; }
/** Texte de l'interface dans la langue choisie. Ex. : tr('Deleted: %s', $nom). Traductions : inc/lang_ar.php (clé = texte anglais) */
function tr(string $en, ...$args): string {
    static $ar = null;
    /* Valeurs enregistrées en français dans la base ou les listes (postes, rôles, pays) */
    static $legacy = [
        'Gardien' => 'Goalkeeper', 'Gardienne' => 'Goalkeeper', 'Défenseur' => 'Defender', 'Milieu' => 'Midfielder',
        'Attaquant' => 'Forward', 'Joueuse' => 'Player', 'Entraîneur' => 'Coach', 'Entraîneur principal' => 'Head coach',
        'Entraîneur adjoint' => 'Assistant coach', 'Entraîneur des gardiens' => 'Goalkeeper coach', 'Préparateur physique' => 'Fitness coach', 'Directeur technique' => 'Technical director',
        'Médecin' => 'Doctor', 'Kinésithérapeute' => 'Physiotherapist', 'Analyste vidéo' => 'Video analyst', 'Intendant' => 'Kit manager',
        'Entraîneuse principale' => 'Head coach', 'Entraîneuse adjointe' => 'Assistant coach', 'Entraîneur des gardiennes' => 'Goalkeeper coach', 'Préparatrice physique' => 'Fitness coach',
        'Intendante' => 'Kit manager', 'Algérie' => 'Algeria', 'RD Congo' => 'DR Congo', 'Ouganda' => 'Uganda',
        'Rwanda' => 'Rwanda', 'Togo' => 'Togo', 'Gardiens' => 'Goalkeepers', 'Défenseurs' => 'Defenders',
        'Milieux' => 'Midfielders', 'Attaquants' => 'Forwards', 'Staff technique' => 'Coaching staff', 'Gardiennes' => 'Goalkeepers',
        'Joueuses' => 'Players', 'Joueurs' => 'Players',
    ];
    if (admin_lang() === 'ar') { $ar ??= (require __DIR__ . '/lang_ar.php'); $s = $ar[$en] ?? $ar[$legacy[$en] ?? ''] ?? $en; }
    else $s = $legacy[$en] ?? $en;
    return $args ? vsprintf($s, array_map('strval', $args)) : $s;
}
/** Même chose, prêt à être mis dans un attribut onsubmit="return confirm(...)" */
function trjs(string $fr, ...$args): string { return e(json_encode(tr($fr, ...$args), JSON_UNESCAPED_UNICODE)); }
/** Nom court d'un club (Data/clubs.php) dans la langue de l'interface */
function admin_club(array $clubs, string $code): string { return $clubs[$code][admin_lang() === 'ar' ? 'ar' : 'fr'] ?? $code; }
/** Lien vers la page actuelle dans l'autre langue */
function admin_lang_url(string $l): string {
    $q = $_GET; $q['alang'] = $l;
    return basename((string)($_SERVER['SCRIPT_NAME'] ?? 'index.php')) . '?' . http_build_query($q);
}

function db(): PDO {
    $pdo = csc_pdo();
    if (!$pdo) {
        http_response_code(503);
        exit(tr('Cannot reach the database. Check Data/config.php.'));
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
        flash('danger', tr('Upload too large (server limit: %s). Try lighter images.', upload_limit_label()));
        redirect($_SERVER['REQUEST_URI'] ?? 'index.php');
    }
    $t = $_POST['csrf'] ?? '';
    if (!is_string($t) || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $t)) {
        // Page ouverte depuis longtemps, ou reconnexion dans un autre onglet :
        // on recharge la page proprement au lieu d'une page d'erreur.
        flash('warning', tr('The page had expired (opened before your last login). It has been reloaded: just do the action again.'));
        $back = (string)($_SERVER['REQUEST_URI'] ?? 'index.php');
        redirect(preg_match('#^/[^\s]*$#', $back) ? $back : 'index.php');
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
    csrf_token();
    return true;
}

/** Règles du mot de passe ; renvoie un message d'erreur ou null */
function password_problem(string $p, string $confirm): ?string {
    if (mb_strlen($p) < 10) return tr('The password must be at least 10 characters long.');
    if (!preg_match('/[A-Za-z]/', $p) || !preg_match('/\d/', $p)) return tr('The password must contain letters and numbers.');
    if ($p !== $confirm) return tr('The two passwords do not match.');
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
function upload_limit_label(): string { return round(upload_limit_bytes() / 1048576, 1) . ' ' . tr('MB'); }
function video_limit_bytes(): int {
    $l = [ADMIN_VIDEO_MAX_BYTES, ini_bytes((string)ini_get('upload_max_filesize')), ini_bytes((string)ini_get('post_max_size'))];
    return min(array_filter($l, fn($x) => $x > 0));
}
function video_limit_label(): string { return round(video_limit_bytes() / 1048576, 1) . ' ' . tr('MB'); }

/** Enregistre une vidéo MP4 / WEBM envoyée. Renvoie le chemin relatif, null si aucun fichier. */
function save_uploaded_video(array $f, string $sub = ADMIN_UPLOAD_MEDIAS): ?string {
    $err = $f['error'] ?? UPLOAD_ERR_NO_FILE;
    if ($err === UPLOAD_ERR_NO_FILE) return null;
    if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) throw new RuntimeException(tr('Video too large (max %s).', video_limit_label()));
    if ($err !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name'])) throw new RuntimeException(tr("The video upload failed (code %s).", $err));
    if ($f['size'] > video_limit_bytes()) throw new RuntimeException(tr('Video too large (max %s).', video_limit_label()));
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $ext = ['video/mp4' => 'mp4', 'video/webm' => 'webm'][$mime] ?? null;
    if (!$ext) throw new RuntimeException(tr('Format not accepted: upload an MP4 or WEBM video.'));
    $path = upload_dir_abs($sub) . '/' . date('Ymd') . '-' . bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($f['tmp_name'], $path)) throw new RuntimeException(tr("Could not save the video."));
    @chmod($path, 0644);
    return $sub . '/' . basename($path);
}

/** Dossier d'envoi (créé au besoin, avec un .htaccess qui interdit d'y exécuter du code) */
function upload_dir_abs(string $sub = ADMIN_UPLOAD_DIR): string {
    $dir = dirname(__DIR__, 2) . '/' . $sub;
    if (!is_dir($dir) && !@mkdir($dir, 0755, true)) throw new RuntimeException(tr("Could not create the folder %s: check write permissions.", $sub));
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
    if (!is_writable($dir)) throw new RuntimeException(tr("The folder %s is not writable.", $sub));
    return $dir;
}

/**
 * Enregistre une image envoyée ($_FILES[...] d'un seul fichier).
 * Renvoie le chemin relatif (ex. uploads/actualites/20261117-ab12cd34.jpg),
 * null si aucun fichier, ou lève une RuntimeException avec un message clair.
 */
/* $sub : dossier d'envoi ; $crop = [largeur, hauteur] pour recadrer au centre (photos de joueurs) */
function save_uploaded_image(array $f, string $sub = ADMIN_UPLOAD_DIR, ?array $crop = null): ?string {
    $err = $f['error'] ?? UPLOAD_ERR_NO_FILE;
    if ($err === UPLOAD_ERR_NO_FILE) return null;
    if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) throw new RuntimeException(tr('Image too large (max %s).', upload_limit_label()));
    if ($err !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name'])) throw new RuntimeException(tr("The image upload failed (code %s).", $err));
    if ($f['size'] > upload_limit_bytes()) throw new RuntimeException(tr('Image too large (max %s).', upload_limit_label()));

    // Le vrai type du fichier (on ne fait pas confiance au nom ni au navigateur)
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? null;
    $info = @getimagesize($f['tmp_name']);
    if (!$ext || !$info || $info[0] < 1 || $info[1] < 1) throw new RuntimeException(tr('Format not accepted: upload a JPG, PNG or WEBP image.'));
    if ($info[0] * $info[1] > 40000000) throw new RuntimeException(tr('Image too big (dimensions).'));

    $dir = upload_dir_abs($sub);
    $name = date('Ymd') . '-' . bin2hex(random_bytes(8));

    // Avec GD : on ré-encode l'image (supprime tout contenu caché) et on la réduit si besoin
    if (extension_loaded('gd')) {
        $src = match ($ext) {
            'jpg'  => @imagecreatefromjpeg($f['tmp_name']),
            'png'  => @imagecreatefrompng($f['tmp_name']),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($f['tmp_name']) : false,
        };
        if (!$src) throw new RuntimeException(tr("Unreadable or damaged image."));
        if ($ext === 'jpg' && function_exists('exif_read_data')) {           // photos de téléphone : bonne orientation
            $o = (int)(@exif_read_data($f['tmp_name'])['Orientation'] ?? 1);
            $rot = [3 => 180, 6 => -90, 8 => 90][$o] ?? 0;
            if ($rot) { $r = imagerotate($src, $rot, 0); if ($r) { imagedestroy($src); $src = $r; } }
        }
        $w = imagesx($src); $h = imagesy($src);
        if ($crop) {
            // Recadrage au centre au bon format (ex. 600x750 comme les photos officielles)
            [$cw, $ch] = $crop;
            $ratio = $cw / $ch;
            if ($w / $h > $ratio) { $sh = $h; $sw = (int)round($h * $ratio); $sx = (int)(($w - $sw) / 2); $sy = 0; }
            else { $sw = $w; $sh = (int)round($w / $ratio); $sx = 0; $sy = (int)max(0, ($h - $sh) * 0.2); } // garde le haut (visage)
            $dst = imagecreatetruecolor($cw, $ch);
            if ($ext !== 'jpg') { imagealphablending($dst, false); imagesavealpha($dst, true); }
            imagecopyresampled($dst, $src, 0, 0, $sx, $sy, $cw, $ch, $sw, $sh);
            imagedestroy($src); $src = $dst; $w = $cw; $h = $ch;
        }
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
        if (!$ok) throw new RuntimeException(tr("Could not save the image."));
    } else {
        $path = "$dir/$name.$ext";
        if (!move_uploaded_file($f['tmp_name'], $path)) throw new RuntimeException(tr("Could not save the image."));
    }
    @chmod($path, 0644);
    return $sub . "/$name.$ext";
}

/**
 * Logo de sponsor : même format que les logos actuels (carré blanc 500x500,
 * logo centré). Les marges blanches/transparentes du fichier sont retirées
 * pour que chaque logo ait la même taille visuelle dans le bandeau.
 */
function save_sponsor_logo(array $f): ?string {
    $tmp = save_uploaded_image($f, ADMIN_UPLOAD_SPONSORS);   // vérifications + ré-encodage
    if (!$tmp || !extension_loaded('gd')) return $tmp;
    $abs = dirname(__DIR__, 2) . '/' . $tmp;
    $src = @imagecreatefromstring((string)file_get_contents($abs));
    if (!$src) return $tmp;
    $w = imagesx($src); $h = imagesy($src);
    // Aplatir sur fond blanc (logos PNG transparents)
    $flat = imagecreatetruecolor($w, $h);
    imagefill($flat, 0, 0, imagecolorallocate($flat, 255, 255, 255));
    imagecopy($flat, $src, 0, 0, 0, 0, $w, $h);
    imagedestroy($src);
    // Cadre utile : pixels nettement non blancs
    $minX = $w; $minY = $h; $maxX = -1; $maxY = -1;
    $step = max(1, (int)floor(max($w, $h) / 800));
    for ($y = 0; $y < $h; $y += $step) for ($x = 0; $x < $w; $x += $step) {
        $c = imagecolorat($flat, $x, $y);
        if ((($c >> 16) & 255) < 235 || (($c >> 8) & 255) < 235 || ($c & 255) < 235) {
            if ($x < $minX) $minX = $x; if ($x > $maxX) $maxX = $x;
            if ($y < $minY) $minY = $y; if ($y > $maxY) $maxY = $y;
        }
    }
    if ($maxX < 0) { $minX = 0; $minY = 0; $maxX = $w - 1; $maxY = $h - 1; }
    $cw = $maxX - $minX + 1; $ch = $maxY - $minY + 1;
    $box = 400; $size = 500;                             // logo dans 400x400, centré dans 500x500
    $r = min($box / $cw, $box / $ch);
    $nw = max(1, (int)round($cw * $r)); $nh = max(1, (int)round($ch * $r));
    $dst = imagecreatetruecolor($size, $size);
    imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255));
    imagecopyresampled($dst, $flat, (int)(($size - $nw) / 2), (int)(($size - $nh) / 2), $minX, $minY, $nw, $nh, $cw, $ch);
    imagedestroy($flat);
    $final = preg_replace('/\.(png|webp|jpg)$/', '.jpg', $tmp);
    imagejpeg($dst, dirname(__DIR__, 2) . '/' . $final, 90);
    imagedestroy($dst);
    if ($final !== $tmp) @unlink($abs);
    return $final;
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
    if (!$rel || !preg_match('#^uploads/(actualites|joueurs|sponsors|feminine|jeunes|medias)/[A-Za-z0-9-]+\.(jpg|png|webp|mp4|webm)$#', $rel)) return;
    $checks = ['SELECT COUNT(*) FROM actualites WHERE image = ? OR galerie LIKE ?' => [$rel, '%' . $rel . '%'],
               'SELECT COUNT(*) FROM joueurs WHERE img = ?' => [$rel],
               'SELECT COUNT(*) FROM sponsors WHERE logo = ?' => [$rel],
               'SELECT COUNT(*) FROM equipe_feminine WHERE img = ?' => [$rel],
               'SELECT COUNT(*) FROM jeunes WHERE img = ?' => [$rel],
               'SELECT COUNT(*) FROM reglages WHERE valeur LIKE ?' => ['%' . $rel . '%']];
    foreach ($checks as $sql => $params) {
        try { $n = db()->prepare($sql); $n->execute($params); if ((int)$n->fetchColumn() > 0) return; }
        catch (PDOException $e) { /* table pas encore créée */ }
    }
    @unlink(dirname(__DIR__, 2) . '/' . $rel);
}

/** Chemin d'image utilisable depuis admin/ */
function admin_img(?string $p): string {
    if ($p && preg_match('#^https?://#', $p)) return $p;
    return ($p && is_file(dirname(__DIR__, 2) . '/' . $p)) ? '../' . $p : '../images/banner-csc.jpg';
}

/* ---------- Mise en page ---------- */
function page_header(string $title, ?array $admin = null): void { ?>
<!doctype html>
<html lang="<?= admin_lang() ?>" dir="<?= admin_lang() === 'ar' ? 'rtl' : 'ltr' ?>">
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
<body class="<?= $admin ? 'adm-has-side' : '' ?>">
<?php if ($admin):
    // Lien actif : la page en cours, ou la liste dont elle depend (edit.php -> index.php...)
    $cur = basename($_SERVER['SCRIPT_NAME'] ?? '');
    $cur = ['edit.php' => 'index.php', 'joueur.php' => 'joueurs.php', 'match.php' => 'matchs.php', 'feminine_edit.php' => 'feminine.php', 'jeune.php' => 'jeunes.php'][$cur] ?? $cur;
    $menu = [
        tr('Content') => [['index.php', 'fa-newspaper', tr('News')], ['matchs.php', 'fa-futbol', tr('Matches')], ['classement.php', 'fa-list-ol', tr('Standings')], ['videos.php', 'fa-video', tr('Videos')]],
        tr('Teams') => [['joueurs.php', 'fa-users', tr('Players')], ['feminine.php', 'fa-female', tr('Women\'s team')], ['jeunes.php', 'fa-child', tr('Youth')]],
        tr('Partners') => [['sponsors.php', 'fa-handshake', tr('Sponsors')], ['pub.php', 'fa-bullhorn', tr('Advertising')]],
    ];
?>
<header class="adm-topbar">
  <button type="button" class="adm-burger" id="admBurger" aria-label="<?= e(tr('Menu')) ?>" aria-controls="admSide" aria-expanded="false"><i class="fas fa-bars"></i></button>
  <a class="adm-brand" href="index.php"><img src="../images/logo-csc.png" alt=""> Admin CSC</a>
</header>
<aside class="adm-side" id="admSide">
  <a class="adm-brand adm-side-brand" href="index.php"><img src="../images/logo-csc.png" alt=""> Admin CSC</a>
  <?php admin_lang_switch(); ?>
  <nav class="adm-side-nav">
    <?php foreach ($menu as $section => $links): ?>
      <div class="adm-side-title"><?= e($section) ?></div>
      <?php foreach ($links as [$href, $icon, $label]): ?>
        <a href="<?= $href ?>" class="<?= $cur === $href ? 'active' : '' ?>"<?= $cur === $href ? ' aria-current="page"' : '' ?>><i class="fas <?= $icon ?> fa-fw"></i> <?= e($label) ?></a>
      <?php endforeach; ?>
    <?php endforeach; ?>
    <div class="adm-side-title"><?= e(tr('Account')) ?></div>
    <a href="password.php" class="<?= $cur === 'password.php' ? 'active' : '' ?>"><i class="fas fa-key fa-fw"></i> <?= e(tr('Password')) ?></a>
    <a href="../index.php" target="_blank" rel="noopener"><i class="fas fa-external-link-alt fa-fw"></i> <?= e(tr('View the site')) ?></a>
  </nav>
  <form method="post" action="logout.php" class="adm-side-foot"><?= csrf_field() ?>
    <div class="adm-side-user"><i class="fas fa-user-circle"></i> <?= e($admin['username']) ?></div>
    <button type="submit" class="adm-logout"><i class="fas fa-sign-out-alt fa-fw"></i> <?= e(tr('Log out')) ?></button>
  </form>
</aside>
<div class="adm-backdrop" id="admBackdrop"></div>
<script>
(function () {
  var b = document.getElementById('admBurger'), bd = document.getElementById('admBackdrop');
  function set(open) { document.body.classList.toggle('adm-side-open', open); b.setAttribute('aria-expanded', open ? 'true' : 'false'); }
  b.addEventListener('click', function () { set(!document.body.classList.contains('adm-side-open')); });
  bd.addEventListener('click', function () { set(false); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') set(false); });
})();
</script>
<?php else: ?>
<nav class="adm-nav">
  <div class="container adm-nav-in">
    <a class="adm-brand" href="index.php"><img src="../images/logo-csc.png" alt=""> Admin CSC</a>
    <?php admin_lang_switch(); ?>
  </div>
</nav>
<?php endif; ?>
<div class="adm-page">
<main class="container adm-main">
<?php
    if (!empty($_SESSION['flash'])) {
        [$t, $m] = $_SESSION['flash']; unset($_SESSION['flash']);
        echo '<div class="alert alert-' . e($t) . '">' . e($m) . '</div>';
    }
}

/** Boutons FR / عربي */
function admin_lang_switch(): void { $l = admin_lang(); ?>
  <div class="adm-langsw" role="group" aria-label="Langue / اللغة">
    <a href="<?= e(admin_lang_url('en')) ?>" lang="en" class="<?= $l === 'en' ? 'active' : '' ?>">EN</a>
    <a href="<?= e(admin_lang_url('ar')) ?>" lang="ar" class="<?= $l === 'ar' ? 'active' : '' ?>">عربي</a>
  </div>
<?php }
function page_footer(): void { ?>
</main>
<footer class="adm-foot"><?= e(tr("CS Constantine · admin area")) ?></footer>
</div>
</body>
</html>
<?php }
