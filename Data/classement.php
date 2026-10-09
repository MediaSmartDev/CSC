<?php
/* =====================================================================
 * CLASSEMENT LIGUE 1 MOBILIS (source : https://lfp.dz/ar/ranking)
 * Plus besoin de phpMyAdmin : modifier ce fichier puis git push.
 * Une ligne par club, dans l'ordre du classement :
 *   [code club, matchs joués J, gagnés G, nuls N, perdus P, buts pour, buts contre, points]
 * (les noms FR/AR et les logos viennent de Data/clubs.php)
 * ===================================================================== */
return [
    'saison'     => '2026/2027',
    'journee'    => 4,
    'mise_a_jour'=> '2026-10-09 12:00:00',
    'clubs' => [
        ['CRB',  4, 3, 1, 0, 6, 3, 10],
        ['CSC',  4, 2, 1, 1, 9, 6, 7],
        ['MCO',  3, 2, 1, 0, 3, 0, 7],
        ['USMA', 4, 2, 1, 1, 5, 3, 7],
        ['ESBA', 4, 1, 3, 0, 6, 5, 6],
        ['MBR',  4, 2, 0, 2, 3, 3, 6],
        ['OA',   4, 1, 1, 2, 4, 5, 4],
        ['ESS',  4, 1, 1, 2, 5, 3, 4],
        ['JSEB', 4, 1, 1, 2, 6, 6, 4],
        ['CRT',  3, 1, 1, 1, 2, 3, 4],
        ['MCA',  1, 1, 0, 0, 2, 0, 3],
        ['JSK',  2, 1, 0, 1, 1, 1, 3],
        ['JSS',  3, 0, 2, 1, 0, 4, 2],
        ['USB',  4, 0, 2, 2, 2, 7, 2],
        ['USMK', 3, 0, 2, 1, 1, 2, 2],
        ['ASO',  3, 0, 1, 2, 3, 7, 1],
    ],
];
