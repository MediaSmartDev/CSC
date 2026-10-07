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
        'id' => 13, 'date' => '2026-10-05', 'image' => 'images/Actualite/next-csc-usb.jpg',
        'label'   => ['fr' => '📅 Next match', 'ar' => '📅 المباراة القادمة'],
        'titre'   => ['fr' => 'Next match : CSC – US Biskra', 'ar' => 'المباراة القادمة: شباب قسنطينة – إتحاد بسكرة'],
        'resume'  => ['fr' => '4e journée : CSC – US Biskra, mercredi 7 octobre 2026 à 18h00 au stade Chahid Hamlaoui.',
                      'ar' => 'الجولة 4: شباب قسنطينة – إتحاد بسكرة، الأربعاء 7 أكتوبر 2026 على الساعة 18:00 بملعب الشهيد حملاوي.'],
        'contenu' => ['fr' => '', 'ar' => ''],
        'tags' => ['#TheDean1898', '#CSCUSB'], 'bouton' => null,
    ],
    [
        'id' => 14, 'date' => '2026-10-06', 'image' => 'images/Actualite/ticket-csc-usb.jpg',
        'label'   => ['fr' => '🎫 Billetterie', 'ar' => '🎫 التذاكر'],
        'titre'   => ['fr' => 'Billetterie : CSC – US Biskra', 'ar' => 'التذاكر: شباب قسنطينة – إتحاد بسكرة'],
        'resume'  => ['fr' => 'La plateforme numérique « Tadkirati » est ouverte : achetez vos billets pour CSC – US Biskra, mercredi 7 octobre 2026 à 18h00 au stade Chahid Hamlaoui.',
                      'ar' => 'تم فتح المنصة الرقمية "تذكرتي": اقتنوا تذاكركم لمباراة العميد ضد إتحاد بسكرة، الأربعاء 07 أكتوبر 2026 على الساعة 18:00 بملعب الشهيد حملاوي.'],
        'contenu' => ['fr' => "La direction du CS Constantine informe ses fidèles supporters souhaitant assister au match du Doyen face à l'US Biskra, comptant pour la 4e journée de la Ligue 1 Mobilis, prévu ce mercredi 7 octobre 2026 à 18h00 au stade Chahid Hamlaoui de Constantine, que la plateforme numérique « Tadkirati » est ouverte.\nVous pouvez dès maintenant acheter vos billets en ligne.",
                      'ar' => "تعلم إدارة النادي الرياضي القسنطيني أنصار الفريق الأوفياء الراغبين بمشاهدة مباراة العميد ضد إتحاد بسكرة في إطار الجولة 04 من الرابطة المحترفة الأولى المقررة هذا الأربعاء 07 أكتوبر 2026 بداية من الساعة 18:00 بملعب الشهيد حملاوي بقسنطينة، أنه قد تم فتح المنصة الرقمية \"تذكرتي\".\nوبإمكانكم الآن اقتناء تذاكركم عبر الرابط."],
        'tags' => ['#TheDean1898', '#CSCUSB'],
        'bouton' => null,   // mettre ici le lien de "Tadkirati" : ['lien' => 'https://...', 'fr' => '🎟️ Acheter mon billet', 'ar' => '🎟️ اشترِ تذكرتك']
    ],
    [
        'id' => 12, 'date' => '2026-10-08', 'image' => 'https://lfp.dz/medias/ar-6ab65006bb74b.jpg',
        'label'   => ['fr' => '📅 Prochain match', 'ar' => '📅 المباراة القادمة'],
        'titre'   => ['fr' => '5e journée : USM Khenchela – CS Constantine', 'ar' => 'الجولة 5: إتحاد خنشلة – شباب قسنطينة'],
        'resume'  => ['fr' => 'Le Doyen se déplace à Khenchela le lundi 12 octobre 2026 à 15h00, au stade Amar Hamam, pour le compte de la 5e journée de la Ligue 1 Mobilis.',
                      'ar' => 'يتنقل العميد إلى خنشلة يوم الإثنين 12 أكتوبر 2026 على الساعة 15:00 بملعب عمار حمام، لحساب الجولة الخامسة من الرابطة المحترفة الأولى موبيليس.'],
        'contenu' => ['fr' => "Le CS Constantine affrontera l'USM Khenchela le lundi 12 octobre 2026 à 15h00 au stade Amar Hamam de Khenchela, pour le compte de la 5e journée de la Ligue 1 Mobilis.\nAvant cette rencontre, ",
                      'ar' => "يواجه النادي الرياضي القسنطيني فريق إتحاد خنشلة يوم الإثنين 12 أكتوبر 2026 على الساعة 15:00 بملعب عمار حمام بخنشلة، لحساب الجولة الخامسة من الرابطة المحترفة الأولى موبيليس.\nقبل هذه المواجهة، "],
        'tags' => ['#TheDean1898', '#USMKCSC'], 'bouton' => null,
    ],
    [
        'id' => 10, 'date' => '2026-09-19', 'image' => 'https://lfp.dz/medias/ar-6ab8287a7418f.jpg',
        'label'   => ['fr' => '⚽ Résultat', 'ar' => '⚽ نتيجة'],
        'titre'   => ['fr' => 'ES Sétif 5 – 1 CSC', 'ar' => 'وفاق سطيف 5 – 1 شباب قسنطينة'],
        'resume'  => ['fr' => 'Défaite du Doyen à Sétif lors de la 3e journée de la Ligue 1 Mobilis.',
                      'ar' => 'خسارة العميد في سطيف خلال الجولة الثالثة من الرابطة المحترفة الأولى موبيليس.'],
        'contenu' => ['fr' => "Le CS Constantine s'est incliné face à l'ES Sétif (5-1) le samedi 19 septembre 2026, pour le compte de la 3e journée de la Ligue 1 Mobilis.",
                      'ar' => "انهزم النادي الرياضي القسنطيني أمام وفاق سطيف (5-1) يوم السبت 19 سبتمبر 2026، لحساب الجولة الثالثة من الرابطة المحترفة الأولى موبيليس."],
        'tags' => ['#TheDean1898', '#ESSCSC'], 'bouton' => null,
    ],
    [
        'id' => 9, 'date' => '2026-09-12', 'image' => '',
        'label'   => ['fr' => '⚽ Résultat', 'ar' => '⚽ نتيجة'],
        'titre'   => ['fr' => 'CSC 3 – 0 ASO Chlef', 'ar' => 'شباب قسنطينة 3 – 0 جمعية الشلف'],
        'resume'  => ['fr' => 'Première victoire de la saison pour le Doyen, large vainqueur de l\'ASO Chlef lors de la 2e journée.',
                      'ar' => 'أول فوز للعميد هذا الموسم، بانتصار عريض على جمعية الشلف خلال الجولة الثانية.'],
        'contenu' => ['fr' => "Le CS Constantine s'est imposé 3-0 face à l'ASO Chlef le samedi 12 septembre 2026, pour le compte de la 2e journée de la Ligue 1 Mobilis. Il s'agit de la première victoire du club cette saison.",
                      'ar' => "فاز النادي الرياضي القسنطيني على جمعية الشلف بثلاثية نظيفة (3-0) يوم السبت 12 سبتمبر 2026، لحساب الجولة الثانية من الرابطة المحترفة الأولى موبيليس، في أول انتصار للنادي هذا الموسم."],
        'tags' => ['#TheDean1898', '#CSCASO'], 'bouton' => null,
    ],
    [
        'id' => 8, 'date' => '2026-09-05', 'image' => '',
        'label'   => ['fr' => '⚽ Résultat', 'ar' => '⚽ نتيجة'],
        'titre'   => ['fr' => 'CR Témouchent 1 – 1 CSC', 'ar' => 'شباب تموشنت 1 – 1 شباب قسنطينة'],
        'resume'  => ['fr' => 'Le Doyen ramène le point du match nul de Témouchent pour l\'ouverture de la saison 2026/2027.',
                      'ar' => 'العميد يعود بنقطة التعادل من تموشنت في افتتاح موسم 2026/2027.'],
        'contenu' => ['fr' => "Pour la 1re journée de la Ligue 1 Mobilis 2026/2027, le CS Constantine a fait match nul (1-1) sur le terrain du CR Témouchent, le samedi 5 septembre 2026.",
                      'ar' => "في الجولة الأولى من الرابطة المحترفة الأولى موبيليس 2026/2027، تعادل النادي الرياضي القسنطيني (1-1) أمام شباب تموشنت خارج الديار، يوم السبت 5 سبتمبر 2026."],
        'tags' => ['#TheDean1898', '#CRTCSC'], 'bouton' => null,
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
];

/* --- Résultat à remettre dans la liste (en haut) après le match, avec le bon score ---
    [
        'id' => 15, 'date' => '2026-10-07', 'image' => 'images/Actualite/ft-csc-usb-4-0.jpg',
        'label'   => ['fr' => '⚽ Résultat', 'ar' => '⚽ نتيجة'],
        'titre'   => ['fr' => 'FT : CSC 4 – 0 US Biskra', 'ar' => 'نهاية المباراة: شباب قسنطينة 4 – 0 إتحاد بسكرة'],
        'resume'  => ['fr' => 'Large victoire du Doyen face à l\'US Biskra au stade Chahid Hamlaoui, pour le compte de la 4e journée. Buteurs : Djaouchi, L\'ghoul, Evra.',
                      'ar' => 'فوز عريض للعميد على إتحاد بسكرة بملعب الشهيد حملاوي، لحساب الجولة الرابعة. الهدافون: جاوشي، الغول، إيفرا.'],
        'contenu' => ['fr' => "Le CS Constantine s'est largement imposé face à l'US Biskra (4-0) ce mercredi 7 octobre 2026 au stade Chahid Hamlaoui, pour le compte de la 4e journée de la Ligue 1 Mobilis.\nButeurs : Djaouchi, L'ghoul, Evra.",
                      'ar' => "حقق النادي الرياضي القسنطيني فوزاً عريضاً على إتحاد بسكرة (4-0) هذا الأربعاء 7 أكتوبر 2026 بملعب الشهيد حملاوي، لحساب الجولة الرابعة من الرابطة المحترفة الأولى موبيليس.\nالهدافون: جاوشي، الغول، إيفرا."],
        'tags' => ['#TheDean1898', '#DimaCsc'], 'bouton' => null,
    ],
*/
