<?php
/* =====================================================================
 * Gestion des langues du site : Anglais (en) / Arabe (ar)
 *  - changer de langue : ajouter ?lang=en ou ?lang=ar à l'URL
 *    (le choix est mémorisé 1 an dans un cookie)
 *  - dans les pages : <?= L('English text', 'النص العربي') ?>
 *  - les champs *_fr de la base contiennent le texte anglais (ancien nom de colonne)
 * ===================================================================== */
if (!function_exists('L')) {
    $LANGS = ['en', 'ar'];
    $LANG  = 'en';                     // ancien cookie « fr » = anglais
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
        static $en = [
            'Gardien' => 'Goalkeeper', 'Gardienne' => 'Goalkeeper', 'Défenseur' => 'Defender', 'Milieu' => 'Midfielder',
            'Attaquant' => 'Forward', 'Joueuse' => 'Player', 'Staff' => 'Staff', 'Entraîneur' => 'Coach',
            'Entraîneur principal' => 'Head coach', 'Entraîneur adjoint' => 'Assistant coach', 'Entraîneur des gardiens' => 'Goalkeeper coach',
            'Préparateur physique' => 'Fitness coach', 'Directeur technique' => 'Technical director', 'Médecin' => 'Doctor', 'Kinésithérapeute' => 'Physiotherapist',
            'Analyste vidéo' => 'Video analyst', 'Intendant' => 'Kit manager', 'Entraîneuse principale' => 'Head coach',
            'Entraîneuse adjointe' => 'Assistant coach', 'Entraîneur des gardiennes' => 'Goalkeeper coach', 'Préparatrice physique' => 'Fitness coach',
            'Intendante' => 'Kit manager',
            'Algérie' => 'Algeria', 'RD Congo' => 'DR Congo', 'Ouganda' => 'Uganda', 'Rwanda' => 'Rwanda', 'Togo' => 'Togo', 'Alger' => 'Algiers',
        ];
        if ($LANG !== 'ar') return $en[$val] ?? $val;
        static $map = [
            'Gardien' => 'حارس مرمى', 'Gardienne' => 'حارسة مرمى', 'Défenseur' => 'مدافع', 'Milieu' => 'وسط ميدان',
            'Attaquant' => 'مهاجم', 'Joueuse' => 'لاعبة', 'Staff' => 'الطاقم الفني', 'Entraîneur' => 'مدرب',
            'Entraîneur principal' => 'المدرب الرئيسي', 'Entraîneur adjoint' => 'مدرب مساعد', 'Entraîneur des gardiens' => 'مدرب حراس المرمى',
            'Préparateur physique' => 'محضر بدني', 'Directeur technique' => 'مدير فني', 'Médecin' => 'طبيب', 'Kinésithérapeute' => 'معالج فيزيائي',
            'Analyste vidéo' => 'محلل فيديو', 'Intendant' => 'مسؤول العتاد', 'Entraîneuse principale' => 'المدربة الرئيسية',
            'Entraîneuse adjointe' => 'مدربة مساعدة', 'Entraîneur des gardiennes' => 'مدرب حارسات المرمى', 'Préparatrice physique' => 'محضرة بدنية',
            'Intendante' => 'مسؤولة العتاد',
            'Algérie' => 'الجزائر', 'RD Congo' => 'الكونغو الديمقراطية', 'Ouganda' => 'أوغندا', 'Rwanda' => 'رواندا', 'Togo' => 'توغو',
            // mêmes valeurs saisies en anglais
            'Goalkeeper' => 'حارس مرمى', 'Defender' => 'مدافع', 'Midfielder' => 'وسط ميدان', 'Forward' => 'مهاجم', 'Player' => 'لاعب',
            'Coach' => 'مدرب', 'Head coach' => 'المدرب الرئيسي', 'Assistant coach' => 'مدرب مساعد', 'Goalkeeper coach' => 'مدرب حراس المرمى',
            'Fitness coach' => 'محضر بدني', 'Technical director' => 'مدير فني', 'Doctor' => 'طبيب', 'Physiotherapist' => 'معالج فيزيائي',
            'Video analyst' => 'محلل فيديو', 'Kit manager' => 'مسؤول العتاد', 'Algeria' => 'الجزائر', 'DR Congo' => 'الكونغو الديمقراطية', 'Uganda' => 'أوغندا',
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
        $men = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $mar = ['جانفي','فيفري','مارس','أفريل','ماي','جوان','جويلية','أوت','سبتمبر','أكتوبر','نوفمبر','ديسمبر'];
        $m = (int)date('n', $t) - 1;
        return date('j', $t) . ' ' . ($LANG === 'ar' ? $mar[$m] : $men[$m]) . ' ' . date('Y', $t);
    }
}

/* Nom d'un club / d'un joueur dans la langue courante (colonnes *_ar de la base) */
if (!function_exists('club_name')) {
    function club_name($row) {
        global $LANG;
        return ($LANG === 'ar' && !empty($row['club_ar'])) ? $row['club_ar'] : $row['club'];
    }
    /** Poste dans la langue courante : poste en arabe saisi dans l'admin, sinon traduction connue */
    function player_poste($row) {
        global $LANG;
        if ($LANG === 'ar' && !empty($row['poste_ar'])) return $row['poste_ar'];
        return Lv($row['poste'] ?? '');
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
