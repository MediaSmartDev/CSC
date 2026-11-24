<?php
/* =====================================================================
 * VIDÉOS ET PUBLICITÉ : réglages gérés dans l'espace admin
 * (admin/videos.php, admin/pub.php). Sans les tables, le site garde la
 * bannière de l'accueil et la pub de Data/pub.php.
 * ===================================================================== */
require_once __DIR__ . '/news.php';   // csc_pdo()

/** Réglage enregistré (tableau), ou null s'il n'existe pas */
function csc_reglage($cle) {
    $pdo = csc_pdo();
    if (!$pdo) return null;
    try {
        $st = $pdo->prepare('SELECT valeur FROM reglages WHERE cle = ?');
        $st->execute([$cle]);
        $v = $st->fetchColumn();
        $a = $v === false ? null : json_decode($v, true);
        return is_array($a) ? $a : null;
    } catch (PDOException $e) {
        return null;   // table pas encore créée
    }
}

/** Texte dans la langue de la page (repli sur le français) */
function csc_txt(array $a, $k) {
    $fr = (string)($a[$k . '_fr'] ?? '');
    $ar = (string)($a[$k . '_ar'] ?? '');
    return L($fr, $ar !== '' ? $ar : $fr);
}

/** Bande publicitaire : ['actif','type','fichier','poster','lien','alt'] */
function csc_pub() {
    $r = csc_reglage('pub');
    if ($r === null) return require __DIR__ . '/pub.php';
    return ['actif' => !empty($r['actif']) && !empty($r['fichier']), 'type' => ($r['type'] ?? '') === 'video' ? 'video' : 'image',
            'fichier' => (string)($r['fichier'] ?? ''), 'poster' => (string)($r['poster'] ?? ''),
            'lien' => (string)($r['lien'] ?? ''), 'alt' => csc_txt($r, 'alt')];
}

/** Vidéo d'accueil (en haut de la page d'accueil), ou null si désactivée */
function csc_hero() {
    $r = csc_reglage('hero');
    if (!$r || empty($r['actif']) || empty($r['video'])) return null;
    return ['video' => (string)$r['video'], 'poster' => (string)($r['poster'] ?? ''),
            'titre' => csc_txt($r, 'titre'), 'texte' => csc_txt($r, 'texte'),
            'bouton' => csc_txt($r, 'bouton'), 'lien' => (string)($r['lien'] ?? '')];
}

/** Vidéos YouTube publiées : [['id','titre'], ...] */
function csc_videos() {
    $pdo = csc_pdo();
    if (!$pdo) return [];
    try {
        $out = [];
        foreach ($pdo->query('SELECT youtube_id, titre_fr, titre_ar FROM videos WHERE publie = 1 ORDER BY ordre ASC, id DESC')->fetchAll() as $r) {
            $out[] = ['id' => $r['youtube_id'], 'titre' => L($r['titre_fr'], ($r['titre_ar'] ?? '') !== '' ? $r['titre_ar'] : $r['titre_fr'])];
        }
        return $out;
    } catch (PDOException $e) {
        return [];
    }
}
