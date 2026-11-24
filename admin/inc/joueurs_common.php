<?php
/* Catégories et postes des joueurs (mêmes valeurs que la page joueurs.php) */
const JOUEUR_CATEGORIES = [
    1 => ['Goalkeepers', 'Goalkeeper'],
    2 => ['Defenders', 'Defender'],
    3 => ['Midfielders', 'Midfielder'],
    4 => ['Forwards', 'Forward'],
    5 => ['Coaching staff', 'Coach'],
];
const JOUEUR_PHOTO_SIZE = [600, 750];   // format des photos officielles 2026/2027

function joueur_nom(array $r): string { return trim($r['nom'] . ' ' . ($r['prenom'] ?? '')); }

/** Âge : depuis la date de naissance si connue, sinon la colonne age */
function joueur_age(array $r): ?int {
    if (!empty($r['date_naissance'])) return (new DateTime())->diff(new DateTime($r['date_naissance']))->y;
    return isset($r['age']) && $r['age'] !== '' ? (int)$r['age'] : null;
}
