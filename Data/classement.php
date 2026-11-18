<?php
/* =====================================================================
 * CLASSEMENT LIGUE 1 MOBILIS (source : https://lfp.dz/fr/ranking)
 * Plus besoin de phpMyAdmin : modifier ce fichier puis git push.
 * Une ligne par club, dans l'ordre du classement :
 *   [code club, matchs joués J, gagnés G, nuls N, perdus P, buts pour, buts contre, points]
 * (les noms FR/AR et les logos viennent de Data/clubs.php)
 * ===================================================================== */
return [
    'saison'     => '2026/2027',
    'journee'    => 9,
    'mise_a_jour'=> '2026-11-18 10:00:00',
    'clubs' => [
        ['CRB',  8, 6, 2, 0, 13,  7, 20],
        ['JSK',  8, 5, 2, 1, 11,  3, 17],
        ['MCA',  7, 5, 1, 1,  9,  2, 16],
        ['MBR',  9, 4, 3, 2,  9,  6, 15],
        ['MCO',  8, 4, 3, 1,  5,  2, 15],
        ['USMA', 7, 4, 2, 1, 10,  5, 14],
        ['OA',   8, 3, 3, 2,  9,  6, 12],
        ['JSEB', 9, 3, 2, 4, 13, 12, 11],
        ['CRT',  9, 2, 4, 3,  7, 10, 10],
        ['ESS',  8, 2, 3, 3, 10,  8,  9],
        ['ESBA', 8, 1, 5, 2,  8,  9,  8],
        ['USMK', 9, 1, 4, 4,  5, 10,  7],
        ['JSS',  9, 1, 4, 4,  2,  8,  7],
        ['CSC',  9, 2, 1, 6, 11, 18,  7],
        ['ASO',  9, 0, 5, 4,  7, 13,  5],
        ['USB',  9, 0, 4, 5,  4, 14,  4],
    ],
];
