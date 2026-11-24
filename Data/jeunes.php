<?php
/* =====================================================================
 * CATÉGORIES JEUNES : table `jeunes`, gérée dans l'espace admin
 * (admin/jeunes.php). Sans la table, les catégories restent vides
 * (« Effectif bientôt disponible »).
 * ===================================================================== */
require_once __DIR__ . '/news.php';   // csc_pdo()

/** Catégories, dans l'ordre des onglets */
const CSC_JEUNES_CATEGORIES = [
    'U21' => ['Reserves (U21)', 'الآمال (أقل من 21 سنة)'],
    'U19' => ['Under-19s (U19)', 'الأواسط (أقل من 19 سنة)'],
    'U17' => ['Under-17s (U17)', 'الأشبال (أقل من 17 سنة)'],
    'U15' => ['Under-15s (U15)', 'الأصاغر (أقل من 15 سنة)'],
    'U13' => ['Under-13s (U13)', 'البراعم (أقل من 13 سنة)'],
];

/**
 * Catégories pour jeunes.php : [['code','fr','ar','coach','joueurs' => [['nom','num','poste','img'], ...]], ...]
 * Noms et postes sont déjà dans la langue de la page. Joueurs d'abord, puis le staff.
 */
function csc_jeunes() {
    $cats = [];
    foreach (CSC_JEUNES_CATEGORIES as $code => [$fr, $ar]) $cats[$code] = ['code' => $code, 'fr' => $fr, 'ar' => $ar, 'coach' => '', 'joueurs' => []];
    $pdo = csc_pdo();
    if ($pdo) {
        try {
            $rows = $pdo->query('SELECT * FROM jeunes WHERE publie = 1 ORDER BY type ASC, ordre ASC, id ASC')->fetchAll();
            foreach ($rows as $r) {
                if (!isset($cats[$r['categorie']])) continue;
                $nom = L($r['nom'], ($r['nom_ar'] ?? '') !== '' ? $r['nom_ar'] : $r['nom']);
                $poste = ($r['poste_ar'] ?? '') !== '' ? L($r['poste'], $r['poste_ar']) : Lv($r['poste']);
                if ((int)$r['type'] === 2 && $cats[$r['categorie']]['coach'] === '') $cats[$r['categorie']]['coach'] = $nom;
                $cats[$r['categorie']]['joueurs'][] = ['nom' => $nom, 'num' => $r['num'] === null ? '' : (string)(int)$r['num'],
                                                      'poste' => $poste, 'img' => (string)$r['img']];
            }
        } catch (PDOException $e) {
            error_log('[CSC] Lecture jeunes impossible : ' . $e->getMessage());
        }
    }
    return array_values($cats);
}
