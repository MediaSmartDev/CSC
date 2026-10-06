<?php
/* =====================================================================
 * ACTUALITÉS DU CLUB  (accueil + page actualite.php?id=...)
 * Chaque texte existe en 2 langues : 'fr' et 'ar'.
 * Pour ajouter une actualité : copier un bloc [ ... ], le coller EN HAUT
 * de la liste (la plus récente en premier) et lui donner un nouvel 'id'.
 *   date    : 'AAAA-MM-JJ' ('' = pas de date)
 *   image   : image dans images/Actualite/
 *   contenu : texte complet (un paragraphe par ligne) ; '' = on affiche le résumé
 *   bouton  : null, ou ['lien' => ..., 'fr' => ..., 'ar' => ...]
 * ===================================================================== */
return [
    [
        'id' => 7, 'date' => '', 'image' => 'images/Actualite/news3.jpeg',
        'label'   => ['fr' => '🎉 Félicitations', 'ar' => '🎉 تهنئة'],
        'titre'   => ['fr' => 'Félicitations aux clubs promus 🎉', 'ar' => 'تهنئة الأندية الصاعدة 🎉'],
        'resume'  => ['fr' => 'La direction du CS Constantine adresse ses plus sincères félicitations à la JS El Biar, au CR Témouchent et à l\'US Biskra.',
                      'ar' => 'تتقدم إدارة النادي الرياضي القسنطيني بأسمى التهاني إلى أندية شبيبة الأبيار، شباب تموشنت وإتحاد بسكرة.'],
        'contenu' => ['fr' => '', 'ar' => ''],
        'tags' => ['#TheDean1898', '#DimaCsc'], 'bouton' => null,
    ],
    [
        'id' => 6, 'date' => '', 'image' => 'images/Actualite/statement.jpeg',
        'label'   => ['fr' => '📋 Communiqué officiel', 'ar' => '📋 بيان رسمي'],
        'titre'   => ['fr' => 'Communiqué officiel', 'ar' => 'بيان رسمي'],
        'resume'  => ['fr' => 'La direction du CS Constantine informe que tout ce qui circule au sujet du mercato estival ne relève que de rumeurs.',
                      'ar' => 'تُعلم إدارة النادي الرياضي القسنطيني أن كل ما يتم تداوله بخصوص ملف الانتدابات الصيفية يبقى مجرد إشاعات.'],
        'contenu' => ['fr' => '', 'ar' => ''],
        'tags' => ['#TheDean1898', '#DimaCsc'], 'bouton' => null,
    ],
    [
        'id' => 5, 'date' => '2026-05-19', 'image' => 'images/Actualite/ticket-news.jpeg',
        'label'   => ['fr' => '🎫 Billetterie', 'ar' => '🎫 التذاكر'],
        'titre'   => ['fr' => 'Billetterie 🎫 ⚫️🟢', 'ar' => 'التذاكر 🎫 ⚫️🟢'],
        'resume'  => ['fr' => 'Match du Doyen face à l\'USM Khenchela — mardi 19 mai 2026 à 17h45 au stade Chahid Hamlaoui.',
                      'ar' => 'مباراة العميد ضد إتحاد خنشلة — الثلاثاء 19 ماي 2026 على الساعة 17:45 بملعب الشهيد حملاوي.'],
        'contenu' => ['fr' => '', 'ar' => ''],
        'tags' => ['#TheDean1898', '#CSCUSMK'],
        'bouton' => ['lien' => 'https://digiticket.dz', 'fr' => '🎟️ Achetez votre billet', 'ar' => '🎟️ اشترِ تذكرتك'],
    ],
    [
        'id' => 4, 'date' => '', 'image' => 'images/Actualite/usmaNews.jpeg',
        'label'   => ['fr' => 'Félicitations', 'ar' => 'تهنئة'],
        'titre'   => ['fr' => 'Félicitations 🇩🇿🏆', 'ar' => 'تهنئة 🇩🇿🏆'],
        'resume'  => ['fr' => 'Le CS Constantine adresse ses plus chaleureuses félicitations à l\'USM Alger pour sa victoire en Coupe de la Confédération africaine.',
                      'ar' => 'تقدم النادي الرياضي القسنطيني بأحر التهاني لنادي اتحاد العاصمة بمناسبة فوزه بكأس الكونفدرالية الإفريقية.'],
        'contenu' => ['fr' => '', 'ar' => ''],
        'tags' => ['#TheDean1898', '#USMA'], 'bouton' => null,
    ],
    [
        'id' => 1, 'date' => '', 'image' => 'images/Actualite/Ooredoonews.jpeg',
        'label'   => ['fr' => '🤝 Partenariat officiel', 'ar' => '🤝 شراكة رسمية'],
        'titre'   => ['fr' => '🤝 Officiel : Ooredoo, nouveau sponsor 🟢🖤', 'ar' => '🤝 رسمياً: أوريدو ممول جديد 🟢🖤'],
        'resume'  => ['fr' => 'La direction du CS Constantine annonce la signature d\'un contrat de sponsoring de deux ans avec Ooredoo.',
                      'ar' => 'تعلن إدارة النادي الرياضي القسنطيني عن إبرام عقد رعاية مع شركة أوريدو لمدة سنتين.'],
        'contenu' => ['fr' => '', 'ar' => ''],
        'tags' => ['#TheDean1898', '#Ooredoo'], 'bouton' => null,
    ],
    [
        'id' => 2, 'date' => '', 'image' => 'images/Actualite/news7.jpg',
        'label'   => ['fr' => 'Site officiel', 'ar' => 'الموقع الرسمي'],
        'titre'   => ['fr' => 'Le Doyen renforce sa présence numérique 🟢⚫🌐', 'ar' => '"العميد" يعزز ريادته الرقمية 🟢⚫🌐'],
        'resume'  => ['fr' => 'Nous avons le plaisir d\'annoncer le lancement du site internet officiel du Club Sportif Constantinois.',
                      'ar' => 'يسعدنا إعلان إطلاق الموقع الإلكتروني الرسمي للنادي الرياضي القسنطيني.'],
        'contenu' => ['fr' => '', 'ar' => ''],
        'tags' => ['#TheDean1898', '#DimaCsc'], 'bouton' => null,
    ],
    [
        'id' => 3, 'date' => '', 'image' => 'images/Actualite/news2.jpeg',
        'label'   => ['fr' => '🇩🇿 Convocation', 'ar' => '🇩🇿 استدعاء'],
        'titre'   => ['fr' => 'Les joueurs du Doyen convoqués en sélection 🇩🇿', 'ar' => 'استدعاء لاعبي العميد للمنتخب 🇩🇿'],
        'resume'  => ['fr' => 'Les joueurs du Doyen Benadla, Benmoussa et Khelfaoui ont été convoqués en sélection nationale.',
                      'ar' => 'تلقى لاعبو العميد "بن عدلة"، "بن موسى" و"خلفاوي" استدعاءً للمنتخب الوطني.'],
        'contenu' => ['fr' => '', 'ar' => ''],
        'tags' => ['#TheDean1898', '#DimaCsc'], 'bouton' => null,
    ],
];
