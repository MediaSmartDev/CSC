<?php
/* Équipe féminine : groupes (mêmes que la page equipe-feminine.php) */
const FEM_GROUPES = [
    1 => ['Gardiennes', 'Gardienne'],      // valeurs françaises gardées : traduites à l'affichage (féminin en arabe)
    2 => ['Joueuses', 'Joueuse'],
    3 => ['Staff technique', 'Staff'],
];
const FEM_PHOTO_SIZE = [800, 1200];   // même format portrait que les photos actuelles (2:3)

function fem_nom(array $r): string { return trim((string)$r['nom']) !== '' ? trim((string)$r['nom']) : tr('No name'); }
function fem_role(array $r): string { return ($r['role_fr'] ?? '') !== '' ? $r['role_fr'] : (FEM_GROUPES[(int)$r['groupe']][1] ?? ''); }
