<?php
/* =====================================================================
 * Gestion des langues du site : Français (fr) / Arabe (ar)
 *  - changer de langue : ajouter ?lang=fr ou ?lang=ar à l'URL
 *    (le choix est mémorisé 1 an dans un cookie)
 *  - dans les pages : <?= L('Texte français', 'النص العربي') ?>
 * ===================================================================== */
if (!function_exists('L')) {
    $LANGS = ['fr', 'ar'];
    $LANG  = 'fr';
    if (isset($_GET['lang']) && in_array($_GET['lang'], $LANGS, true)) {
        $LANG = $_GET['lang'];
        if (!headers_sent()) setcookie('csc_lang', $LANG, time() + 31536000, '/');
    } elseif (isset($_COOKIE['csc_lang']) && in_array($_COOKIE['csc_lang'], $LANGS, true)) {
        $LANG = $_COOKIE['csc_lang'];
    }
    $DIR = ($LANG === 'ar') ? 'rtl' : 'ltr';

    /** Texte dans la langue courante */
    function L($fr, $ar) { global $LANG; return $LANG === 'ar' ? $ar : $fr; }
    /** Même chose, mais prêt à être mis dans du JavaScript */
    function LJ($fr, $ar) { return json_encode(L($fr, $ar), JSON_UNESCAPED_UNICODE); }
    /** Lien vers la page actuelle dans une autre langue */
    function lang_url($l) {
        $q = $_GET; $q['lang'] = $l;
        $path = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
        return htmlspecialchars($path . '?' . http_build_query($q));
    }
}

/* Traductions des valeurs venant de la base (postes, pays) */
if (!function_exists('Lv')) {
    function Lv($val) {
        global $LANG;
        if ($LANG !== 'ar') return $val;
        static $map = [
            'Gardien' => 'حارس مرمى', 'Gardienne' => 'حارسة مرمى', 'Défenseur' => 'مدافع', 'Milieu' => 'وسط ميدان',
            'Attaquant' => 'مهاجم', 'Joueuse' => 'لاعبة', 'Staff' => 'الطاقم الفني', 'Entraîneur' => 'مدرب',
            'Algérie' => 'الجزائر', 'RD Congo' => 'الكونغو الديمقراطية', 'Ouganda' => 'أوغندا', 'Rwanda' => 'رواندا', 'Togo' => 'توغو',
        ];
        return $map[$val] ?? $val;
    }
}

/* Image d'une actualité (image de secours si le fichier n'existe pas encore) */
if (!function_exists('news_img')) {
    function news_img($path) {
        if (is_string($path) && preg_match('#^https?://#', $path)) return $path;   // image en ligne (ex. lfp.dz)
        return (is_string($path) && $path !== '' && file_exists(__DIR__ . '/../' . $path)) ? $path : 'images/banner-csc.jpg';
    }
    function news_date($d) {
        global $LANG;
        if (!$d) return '';
        $t = strtotime($d);
        $mfr = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
        $mar = ['جانفي','فيفري','مارس','أفريل','ماي','جوان','جويلية','أوت','سبتمبر','أكتوبر','نوفمبر','ديسمبر'];
        $m = (int)date('n', $t) - 1;
        return date('j', $t) . ' ' . ($LANG === 'ar' ? $mar[$m] : $mfr[$m]) . ' ' . date('Y', $t);
    }
}

/* Nom d'un club / d'un joueur dans la langue courante (colonnes *_ar de la base) */
if (!function_exists('club_name')) {
    function club_name($row) {
        global $LANG;
        return ($LANG === 'ar' && !empty($row['club_ar'])) ? $row['club_ar'] : $row['club'];
    }
    function player_name($row) {
        global $LANG;
        if ($LANG === 'ar' && !empty($row['nom_ar'])) return $row['nom_ar'];
        return trim($row['nom'] . ' ' . ($row['prenom'] ?? ''));
    }
}

/* Texte d'une actualité dans la langue courante : nt($article, 'titre') */
if (!function_exists('nt')) {
    function nt($n, $champ) {
        global $LANG;
        $v = $n[$champ] ?? '';
        if (!is_array($v)) return (string)$v;
        return (string)($v[$LANG] ?? ($v['fr'] ?? ''));
    }
}
