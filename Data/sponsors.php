<?php
/* =====================================================================
 * SPONSORS (bandeau de logos de l'accueil) : table `sponsors`,
 * gérée dans l'espace admin. Si la table n'existe pas encore,
 * on affiche la liste ci-dessous (secours).
 * ===================================================================== */
require_once __DIR__ . '/news.php';   // csc_pdo()

function csc_sponsors_fallback() {
    return [
        ['nom' => 'ENTP',    'logo' => 'images/sponsors/entp.jpeg',    'lien' => ''],
        ['nom' => 'Hayat',   'logo' => 'images/sponsors/hayat.jpeg',   'lien' => ''],
        ['nom' => 'Macron',  'logo' => 'images/sponsors/macron.png',   'lien' => ''],
        ['nom' => 'Ooredoo', 'logo' => 'images/sponsors/ooredoo.jpeg', 'lien' => ''],
        ['nom' => 'Soummam', 'logo' => 'images/sponsors/soumam.jpeg',  'lien' => ''],
    ];
}

/** Sponsors affichés, dans l'ordre choisi dans l'admin */
function csc_sponsors() {
    $pdo = csc_pdo();
    if ($pdo) {
        try {
            return $pdo->query('SELECT nom, logo, lien FROM sponsors WHERE publie = 1 ORDER BY position ASC, id ASC')->fetchAll();
        } catch (PDOException $e) {
            error_log('[CSC] Lecture sponsors impossible : ' . $e->getMessage());
        }
    }
    return csc_sponsors_fallback();
}

/** HTML d'une rangée de logos (affichée 2 fois pour le défilement continu) */
function csc_sponsors_track(array $list, bool $hidden = false) {
    $h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
    $out = '<div class="sponsor-track"' . ($hidden ? ' aria-hidden="true"' : '') . '>';
    foreach ($list as $s) {
        $img = '<img src="' . $h($s['logo']) . '" alt="' . $h($s['nom']) . '">';
        if (!empty($s['lien'])) $img = '<a href="' . $h($s['lien']) . '" target="_blank" rel="noopener sponsored"' . ($hidden ? ' tabindex="-1"' : '') . '>' . $img . '</a>';
        $out .= '<div class="sponsor-item">' . $img . '</div>';
    }
    return $out . '</div>';
}
