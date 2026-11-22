<?php
/* =====================================================================
 * ÉQUIPE FÉMININE : table `equipe_feminine`, gérée dans l'espace admin
 * (admin/feminine.php). Si la table n'existe pas encore (ou est vide),
 * on affiche l'effectif d'origine ci-dessous (secours).
 * ===================================================================== */
require_once __DIR__ . '/news.php';   // csc_pdo()

/** Groupes de la page, dans l'ordre d'affichage : n° => clé utilisée par equipe-feminine.php */
const CSC_FEM_GROUPES = [1 => 'Gardiennes', 2 => 'Joueuses', 3 => 'Staff technique'];

function csc_feminine_fallback() {
    $equipe = [
        'Gardiennes' => [
            ['img' => 'images/feminine/gardienne-01.jpg', 'nom' => '', 'num' => ''],
            ['img' => 'images/feminine/gardienne-02.jpg', 'nom' => '', 'num' => ''],
        ],
        'Joueuses' => [],
        'Staff technique' => [
            ['img' => 'images/feminine/staff-01.jpg', 'nom' => '', 'num' => ''],
            ['img' => 'images/feminine/staff-02.jpg', 'nom' => '', 'num' => ''],
        ],
    ];
    for ($i = 1; $i <= 24; $i++) {
        $equipe['Joueuses'][] = ['img' => sprintf('images/feminine/joueuse-%02d.jpg', $i), 'nom' => '', 'num' => ''];
    }
    return $equipe;
}

/**
 * Effectif affiché, par groupe : ['Gardiennes' => [['img','nom','num','role'?], ...], ...]
 * 'role' n'est présent que si un rôle particulier a été saisi (sinon : rôle du groupe).
 * Les groupes vides ne sont pas renvoyés.
 */
function csc_feminine() {
    $pdo = csc_pdo();
    if ($pdo) {
        try {
            $rows = $pdo->query('SELECT * FROM equipe_feminine ORDER BY groupe ASC, ordre ASC, id ASC')->fetchAll();
            if ($rows) {
                $equipe = [];
                foreach ($rows as $r) {
                    if (!$r['publie'] || !isset(CSC_FEM_GROUPES[(int)$r['groupe']])) continue;
                    $p = [
                        'img' => $r['img'] ?: 'images/player-default.png',
                        'nom' => (string)L($r['nom'], ($r['nom_ar'] ?? '') !== '' ? $r['nom_ar'] : $r['nom']),
                        'num' => $r['num'] === null ? '' : (string)(int)$r['num'],
                    ];
                    if (($r['role_fr'] ?? '') !== '') $p['role'] = L($r['role_fr'], ($r['role_ar'] ?? '') !== '' ? $r['role_ar'] : Lv($r['role_fr']));
                    $equipe[CSC_FEM_GROUPES[(int)$r['groupe']]][] = $p;
                }
                return $equipe;
            }
        } catch (PDOException $e) {
            error_log('[CSC] Lecture équipe féminine impossible : ' . $e->getMessage());
        }
    }
    return csc_feminine_fallback();
}
