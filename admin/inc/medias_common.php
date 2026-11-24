<?php
/* Réglages du site (table `reglages`, valeurs en JSON) : vidéo d'accueil, publicité */

function reglages_ready(): bool {
    try { db()->query('SELECT 1 FROM reglages LIMIT 1'); db()->query('SELECT 1 FROM videos LIMIT 1'); return true; }
    catch (PDOException $e) { return false; }
}
function reglage_get(string $cle): ?array {
    $st = db()->prepare('SELECT valeur FROM reglages WHERE cle = ?');
    $st->execute([$cle]);
    $v = $st->fetchColumn();
    $a = $v === false ? null : json_decode($v, true);
    return is_array($a) ? $a : null;
}
function reglage_set(string $cle, array $val): void {
    db()->prepare('INSERT INTO reglages (cle, valeur) VALUES (?, ?) ON DUPLICATE KEY UPDATE valeur = VALUES(valeur)')
        ->execute([$cle, json_encode($val, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)]);
}
/** Page affichée tant que le fichier SQL n'est pas importé */
function medias_missing_page(string $title, $admin): never {
    page_header($title, $admin); ?>
    <div class="adm-card"><h1 class="adm-h1"><?= e($title) ?></h1>
      <p><?= tr('The %1$s table does not exist yet. In <b>phpMyAdmin</b>, import %2$s, then reload this page.', tr('settings'), '<code>database/maj_2026-11-24_admin_medias.sql</code>') ?></p></div>
    <?php page_footer(); exit;
}
/** Texte d'un champ du formulaire : espaces nettoyés, longueur limitée */
function post_txt(string $k, int $max): string {
    return mb_substr(trim(preg_replace('/\s+/u', ' ', (string)($_POST[$k] ?? ''))), 0, $max);
}
/** Lien saisi : adresse web (https://...) ou page du site (ex. joueurs.php). '' si vide, false si invalide */
function post_link(string $k): string|false {
    $l = trim((string)($_POST[$k] ?? ''));
    if ($l === '') return '';
    if (strlen($l) > 300) return false;
    if (preg_match('#^https?://[^\s<>"]+$#i', $l) && filter_var($l, FILTER_VALIDATE_URL)) return $l;
    if (preg_match('#^[A-Za-z0-9_./\#?=&-]+$#', $l) && !str_contains($l, '//')) return $l;
    return false;
}
/** Chemin public d'un fichier vidéo ou image, utilisable depuis admin/ */
function admin_media(?string $p): string {
    return ($p && is_file(dirname(__DIR__, 2) . '/' . $p)) ? '../' . $p : '';
}
/** Identifiant YouTube (11 caractères) depuis un lien ou un identifiant, ou null */
function youtube_id(string $s): ?string {
    $s = trim($s);
    if (preg_match('/^[A-Za-z0-9_-]{11}$/', $s)) return $s;
    if (preg_match('#^https?://(?:www\.|m\.)?(?:youtube\.com/(?:watch\?(?:.*&)?v=|shorts/|embed/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})#i', $s, $m)) return $m[1];
    return null;
}
