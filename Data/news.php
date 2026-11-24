<?php
/* =====================================================================
 * ACTUALITÉS : lues depuis la base de données (table `actualites`),
 * gérées depuis l'espace admin (admin/).
 *
 * Si la base n'est pas joignable ou si la table n'existe pas encore
 * (SQL pas encore importé), le site affiche l'ancien fichier
 * Data/actualites.php : le site ne tombe jamais en panne.
 *
 * Chaque actualité a la même forme qu'avant :
 *   ['id', 'date', 'image', 'label' => ['fr','ar'], 'titre' => [...],
 *    'resume' => [...], 'contenu' => [...], 'tags' => [...],
 *    'galerie' => [...], 'bouton' => null | ['lien','fr','ar']]
 * ===================================================================== */

if (!function_exists('csc_pdo')) {
    /** Connexion PDO partagée (une seule par page). null si la base est injoignable. */
    function csc_pdo() {
        static $pdo = false;
        if ($pdo !== false) return $pdo;
        $cfg = file_exists(__DIR__ . '/config.php') ? require __DIR__ . '/config.php' : require __DIR__ . '/config.example.php';
        try {
            $pdo = new PDO(
                'mysql:host=' . $cfg['db_host'] . ';dbname=' . $cfg['db_name'] . ';charset=utf8mb4',
                $cfg['db_user'], $cfg['db_pass'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]
            );
        } catch (PDOException $e) {
            error_log('[CSC] Connexion BDD impossible : ' . $e->getMessage());
            $pdo = null;
        }
        return $pdo;
    }
}

/** Ligne de la table -> actualité au format du site */
function csc_news_from_row(array $r) {
    $split = fn($s) => array_values(array_filter(array_map('trim', preg_split('/\r\n|\n|\r/', (string)$s)), 'strlen'));
    $tags = array_values(array_filter(preg_split('/\s+/', trim((string)$r['tags'])), 'strlen'));
    $galerie = $split($r['galerie']);
    // Texte arabe vide -> on affiche le français
    $t = fn($k) => ['fr' => (string)$r[$k . '_fr'], 'ar' => trim((string)$r[$k . '_ar']) !== '' ? (string)$r[$k . '_ar'] : (string)$r[$k . '_fr']];
    // Article (anciennes actualités sans article : leur ancien résumé). Le résumé des cartes = début de l'article.
    $contenuFr = trim((string)$r['contenu_fr']) !== '' ? (string)$r['contenu_fr'] : (string)($r['resume_fr'] ?? '');
    $contenuAr = trim((string)$r['contenu_ar']) !== '' ? (string)$r['contenu_ar'] : (trim((string)($r['resume_ar'] ?? '')) !== '' ? (string)$r['resume_ar'] : $contenuFr);
    return [
        'id'      => (int)$r['id'],
        'date'    => $r['date_pub'] ?: '',
        'image'   => (string)$r['image'],
        'label'   => $t('label'),
        'titre'   => $t('titre'),
        'resume'  => ['fr' => csc_news_excerpt($contenuFr), 'ar' => csc_news_excerpt($contenuAr)],
        'contenu' => ['fr' => $contenuFr, 'ar' => $contenuAr],
        'tags'    => $tags,
        'galerie' => $galerie,
        'bouton'  => trim((string)$r['bouton_lien']) !== ''
                     ? ['lien' => $r['bouton_lien'], 'fr' => $r['bouton_fr'] ?: 'Read more', 'ar' => $r['bouton_ar'] ?: 'المزيد']
                     : null,
        'publie'  => (int)$r['publie'],
    ];
}

/** Début d'un article (cartes de l'accueil, partage) : premier paragraphe coupé proprement */
function csc_news_excerpt($text, $max = 180) {
    $paras = array_values(array_filter(array_map('trim', preg_split('/\R/u', (string)$text)), 'strlen'));
    $s = $paras[0] ?? '';
    if (mb_strlen($s) <= $max) return $s;
    $cut = mb_substr($s, 0, $max);
    $sp = mb_strrpos($cut, ' ');
    return preg_replace('/[\s,;:\x{2013}-]+$/u', '', $sp > $max * 0.6 ? mb_substr($cut, 0, $sp) : $cut) . "\u{2026}";
}

/** Ancien fichier (secours) */
function csc_news_fallback() {
    $a = @include __DIR__ . '/actualites.php';
    return is_array($a) ? $a : [];
}

/** Toutes les actualités publiées, la plus récente (position la plus haute) en premier */
function csc_news_all() {
    static $cache = null;
    if ($cache !== null) return $cache;
    $pdo = csc_pdo();
    if ($pdo) {
        try {
            $rows = $pdo->query('SELECT * FROM actualites WHERE publie = 1 ORDER BY position DESC, id DESC')->fetchAll();
            return $cache = array_map('csc_news_from_row', $rows);
        } catch (PDOException $e) {
            error_log('[CSC] Lecture actualites impossible : ' . $e->getMessage());
        }
    }
    return $cache = csc_news_fallback();
}
