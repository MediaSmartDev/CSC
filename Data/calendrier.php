<?php
/* Outils pour afficher le calendrier (données : Data/matchs.php + Data/clubs.php) */
require_once __DIR__ . '/lang.php';
$CLUBS  = require __DIR__ . '/clubs.php';
$MATCHS = csc_matchs_load();

/** Matchs du CSC : table `matchs_csc` (espace admin), sinon Data/matchs.php (secours) */
function csc_matchs_load() {
    require_once __DIR__ . '/news.php';   // csc_pdo()
    $pdo = csc_pdo();
    if ($pdo) {
        try {
            $rows = $pdo->query('SELECT * FROM matchs_csc ORDER BY j ASC, date_match IS NULL, date_match ASC, id ASC')->fetchAll();
            if ($rows) return array_map(fn($r) => [
                'id' => (int)$r['id'], 'j' => (int)$r['j'], 'dom' => $r['dom'], 'ext' => $r['ext'],
                'date' => $r['date_match'] ?: '', 'heure' => $r['heure'] ? substr($r['heure'], 0, 5) : '',
                'bd' => $r['bd'] === null ? null : (int)$r['bd'], 'be' => $r['be'] === null ? null : (int)$r['be'],
                'stade_fr' => (string)$r['stade_fr'], 'stade_ar' => (string)$r['stade_ar'],
                'slogan_fr' => (string)$r['slogan_fr'], 'slogan_ar' => (string)$r['slogan_ar'],
                'actu' => $r['actu'] ? (int)$r['actu'] : null,
            ], $rows);
        } catch (PDOException $e) {
            error_log('[CSC] Lecture matchs impossible : ' . $e->getMessage());
        }
    }
    $m = @include __DIR__ . '/matchs.php';
    return is_array($m) ? $m : [];
}

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
/** Matchs à venir : pas encore joués, et pas en retard (date passée sans score,
 *  ou sans date mais avant le dernier match joué) — ceux-là attendent juste leur score. */
function matchs_a_venir() {
    global $MATCHS;
    $auj = date('Y-m-d');
    $j_dernier = 0;
    foreach ($MATCHS as $m) if (match_joue($m)) $j_dernier = max($j_dernier, $m['j']);
    return array_values(array_filter($MATCHS, fn($m) => !match_joue($m)
        && ($m['date'] !== '' ? $m['date'] >= $auj : $m['j'] > $j_dernier)));
}
function bilan_csc() {
    $b = ['v' => 0, 'n' => 0, 'd' => 0];
    foreach (matchs_joues() as $m) $b[match_resultat($m)]++;
    $b['pts'] = $b['v'] * 3 + $b['n'];
    return $b;
}
