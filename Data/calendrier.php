<?php
/* Outils pour afficher le calendrier (données : Data/matchs.php + Data/clubs.php) */
require_once __DIR__ . '/lang.php';
$CLUBS  = require __DIR__ . '/clubs.php';
$MATCHS = require __DIR__ . '/matchs.php';

function club_info($code) { global $CLUBS; return $CLUBS[$code] ?? ['fr' => $code, 'ar' => $code, 'ville_fr' => '', 'ville_ar' => '', 'logo' => 'images/logo-dark.png']; }
function club_court($code) { $c = club_info($code); return L($c['fr'], $c['ar']); }
function match_joue($m) { return $m['bd'] !== null && $m['be'] !== null; }
function match_stade($m) {
    if ($m['stade_fr'] !== '') return L($m['stade_fr'], $m['stade_ar']);
    if ($m['dom'] === 'CSC') return L('Stade Chahid Hamlaoui, Constantine', 'ملعب الشهيد حملاوي، قسنطينة');
    $c = club_info($m['dom']);
    return L($c['ville_fr'], $c['ville_ar']);
}
function match_date($m) { return $m['date'] ? news_date($m['date']) : L('Date à confirmer', 'التاريخ لم يحدد بعد'); }
function match_heure($m) { return $m['heure'] ?: '--:--'; }
/** Résultat du CSC : 'v', 'n' ou 'd' */
function match_resultat($m) {
    $csc = $m['dom'] === 'CSC' ? $m['bd'] : $m['be'];
    $adv = $m['dom'] === 'CSC' ? $m['be'] : $m['bd'];
    return $csc > $adv ? 'v' : ($csc == $adv ? 'n' : 'd');
}
function matchs_joues()  { global $MATCHS; return array_values(array_filter($MATCHS, 'match_joue')); }
function matchs_a_venir() { global $MATCHS; return array_values(array_filter($MATCHS, fn($m) => !match_joue($m))); }
function bilan_csc() {
    $b = ['v' => 0, 'n' => 0, 'd' => 0];
    foreach (matchs_joues() as $m) $b[match_resultat($m)]++;
    $b['pts'] = $b['v'] * 3 + $b['n'];
    return $b;
}
