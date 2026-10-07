<?php
/* =====================================================================
 * CALENDRIER DU CSC - Ligue 1 Mobilis 2026/2027 (source : lfp.dz)
 * Après chaque match : mettre le score dans 'bd' (buts équipe à domicile)
 * et 'be' (buts équipe à l'extérieur). null = match pas encore joué.
 * 'date' : AAAA-MM-JJ ('' = date pas encore fixée), 'heure' : HH:MM
 * 'stade_fr' / 'stade_ar' : '' = stade par défaut (Hamlaoui à domicile,
 *   ville de l'adversaire à l'extérieur)
 * ===================================================================== */
return [
    ['j' =>  1, 'dom' => 'CRT'  , 'ext' => 'CSC'  , 'date' => '2026-09-05', 'heure' => '19:00', 'bd' => 1   , 'be' => 1   , 'stade_fr' => '', 'stade_ar' => ''],
    ['j' =>  2, 'dom' => 'CSC'  , 'ext' => 'ASO'  , 'date' => '2026-09-12', 'heure' => '21:00', 'bd' => 3   , 'be' => 0   , 'stade_fr' => '', 'stade_ar' => ''],
    ['j' =>  3, 'dom' => 'ESS'  , 'ext' => 'CSC'  , 'date' => '2026-09-19', 'heure' => '19:00', 'bd' => 5   , 'be' => 1   , 'stade_fr' => '', 'stade_ar' => ''],
    ['j' =>  4, 'dom' => 'CSC'  , 'ext' => 'USB'  , 'date' => '2026-10-07', 'heure' => '18:00', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' =>  5, 'dom' => 'USMK' , 'ext' => 'CSC'  , 'date' => '2026-10-12', 'heure' => '15:00', 'bd' => null, 'be' => null, 'stade_fr' => 'Stade Amar Hamam, Khenchela', 'stade_ar' => 'ملعب عمار حمام، خنشلة'],
    ['j' =>  6, 'dom' => 'CSC'  , 'ext' => 'JSEB' , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' =>  7, 'dom' => 'OA'   , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' =>  8, 'dom' => 'CSC'  , 'ext' => 'USMA' , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' =>  9, 'dom' => 'JSS'  , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 10, 'dom' => 'CSC'  , 'ext' => 'ESBA' , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 11, 'dom' => 'CRB'  , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 12, 'dom' => 'MBR'  , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 13, 'dom' => 'CSC'  , 'ext' => 'MCO'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 14, 'dom' => 'JSK'  , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 15, 'dom' => 'CSC'  , 'ext' => 'MCA'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 16, 'dom' => 'CSC'  , 'ext' => 'CRT'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 17, 'dom' => 'ASO'  , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 18, 'dom' => 'CSC'  , 'ext' => 'ESS'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 19, 'dom' => 'USB'  , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 20, 'dom' => 'CSC'  , 'ext' => 'USMK' , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 21, 'dom' => 'JSEB' , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 22, 'dom' => 'CSC'  , 'ext' => 'OA'   , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 23, 'dom' => 'USMA' , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 24, 'dom' => 'CSC'  , 'ext' => 'JSS'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 25, 'dom' => 'ESBA' , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 26, 'dom' => 'CSC'  , 'ext' => 'CRB'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 27, 'dom' => 'CSC'  , 'ext' => 'MBR'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 28, 'dom' => 'MCO'  , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 29, 'dom' => 'CSC'  , 'ext' => 'JSK'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
    ['j' => 30, 'dom' => 'MCA'  , 'ext' => 'CSC'  , 'date' => '', 'heure' => '', 'bd' => null, 'be' => null, 'stade_fr' => '', 'stade_ar' => ''],
];
