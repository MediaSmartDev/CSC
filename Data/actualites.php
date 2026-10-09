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
        'id' => 15, 'date' => '2026-10-07', 'image' => 'images/Actualite/ft-csc-usb-4-0-final.jpg',
        'label'   => ['fr' => '⚽ Résultat', 'ar' => '⚽ نتيجة'],
        'titre'   => ['fr' => 'Full time : CSC 4 – 0 US Biskra', 'ar' => 'نهاية المباراة: شباب قسنطينة 4 – 0 إتحاد بسكرة'],
        'resume'  => ['fr' => "Large victoire du Doyen face à l'US Biskra (4-0) au stade Chahid Hamlaoui, pour le compte de la 4e journée de la Ligue 1 Mobilis.",
                      'ar' => 'فوز عريض للعميد على إتحاد بسكرة (4-0) بملعب الشهيد حملاوي، لحساب الجولة الرابعة من الرابطة المحترفة الأولى موبيليس.'],
        'contenu' => ['fr' => "Le CS Constantine s'est largement imposé face à l'US Biskra (4-0) ce mercredi 7 octobre 2026 au stade Chahid Hamlaoui, pour le compte de la 4e journée de la Ligue 1 Mobilis.\nButs : Evra (37'), contre son camp (51'), Rebiai (55'), Djaouchi (72').\nAvec cette victoire, le Doyen remonte à la 2e place du classement avec 7 points.",
                      'ar' => "حقق النادي الرياضي القسنطيني فوزاً عريضاً على إتحاد بسكرة (4-0) هذا الأربعاء 7 أكتوبر 2026 بملعب الشهيد حملاوي، لحساب الجولة الرابعة من الرابطة المحترفة الأولى موبيليس.\nالأهداف: إيفرا (37')، ضد مرماه (51')، ربيعي (55')، جاوشي (72').\nبهذا الفوز يرتقي العميد إلى المركز الثاني في الترتيب برصيد 7 نقاط."],
        'tags' => ['#TheDean1898', '#CSCUSB', '#DimaCsc'], 'bouton' => null,
    ],
    [
        'id' => 18, 'date' => '2026-10-09', 'image' => 'images/Actualite/fixtures-octobre.jpg',
        'label'   => ['fr' => '📅 Calendrier', 'ar' => '📅 الرزنامة'],
        'titre'   => ['fr' => 'Les matchs du CSC en octobre', 'ar' => 'مباريات العميد في شهر أكتوبر'],
        'resume'  => ['fr' => "Le programme du Doyen en octobre : US Biskra, USM Khenchela, JS El Biar et Olympique Akbou.",
                      'ar' => 'برنامج العميد في شهر أكتوبر: إتحاد بسكرة، إتحاد خنشلة، شبيبة الأبيار وأولمبيك أقبو.'],
        'contenu' => ['fr' => "Voici le programme du CS Constantine pour le mois d'octobre en Ligue 1 Mobilis :\n• Mercredi 7 octobre, 18h00 : CSC – US Biskra (stade Chahid Hamlaoui) — victoire 4-0\n• Lundi 12 octobre, 15h00 : USM Khenchela – CSC (stade Amar Hamam, Khenchela)\n• Samedi 17 octobre, 17h00 : CSC – JS El Biar (stade Chahid Hamlaoui)\n• Vendredi 23 octobre, 15h15 : Olympique Akbou – CSC (stade des Chouhada, Akbou)",
                      'ar' => "إليكم برنامج النادي الرياضي القسنطيني لشهر أكتوبر في الرابطة المحترفة الأولى موبيليس:\n• الأربعاء 7 أكتوبر، 18:00: شباب قسنطينة – إتحاد بسكرة (ملعب الشهيد حملاوي) — فوز 4-0\n• الإثنين 12 أكتوبر، 15:00: إتحاد خنشلة – شباب قسنطينة (ملعب عمار حمام، خنشلة)\n• السبت 17 أكتوبر، 17:00: شباب قسنطينة – شبيبة الأبيار (ملعب الشهيد حملاوي)\n• الجمعة 23 أكتوبر، 15:15: أولمبيك أقبو – شباب قسنطينة (ملعب الشهداء، أقبو)"],
        'tags' => ['#TheDean1898', '#FixturesOctober'], 'bouton' => null,
    ],
    [
        'id' => 17, 'date' => '2026-10-08', 'image' => 'images/Actualite/programme-j7.jpg',
        'label'   => ['fr' => '📅 Programme', 'ar' => '📅 البرنامج'],
        'titre'   => ['fr' => 'Programme de la 7e journée : Olympique Akbou – CSC', 'ar' => 'برنامج الجولة 7: أولمبيك أقبو – شباب قسنطينة'],
        'resume'  => ['fr' => "Le Doyen se déplacera à Akbou le vendredi 23 octobre 2026 à 15h15, au stade des Chouhada (Béjaïa).",
                      'ar' => 'يتنقل العميد إلى أقبو يوم الجمعة 23 أكتوبر 2026 على الساعة 15:15 بملعب الشهداء (بجاية).'],
        'contenu' => ['fr' => "La LFP a dévoilé le programme de la 7e journée de la Ligue 1 Mobilis.\nLe CS Constantine affrontera l'Olympique Akbou le vendredi 23 octobre 2026 à 15h15 au stade des Chouhada, Akbou (Béjaïa).",
                      'ar' => "كشفت رابطة كرة القدم المحترفة عن برنامج الجولة السابعة من الرابطة المحترفة الأولى موبيليس.\nيواجه النادي الرياضي القسنطيني أولمبيك أقبو يوم الجمعة 23 أكتوبر 2026 على الساعة 15:15 بملعب الشهداء، أقبو - بجاية."],
        'tags' => ['#TheDean1898', '#OACSC'], 'bouton' => null,
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
        'id' => 13, 'date' => '2026-10-05', 'image' => 'images/Actualite/next-csc-usb.jpg',
        'label'   => ['fr' => '📅 Next match', 'ar' => '📅 المباراة القادمة'],
        'titre'   => ['fr' => 'Next match : CSC – US Biskra', 'ar' => 'المباراة القادمة: شباب قسنطينة – إتحاد بسكرة'],
        'resume'  => ['fr' => '4e journée : CSC – US Biskra, mercredi 7 octobre 2026 à 18h00 au stade Chahid Hamlaoui.',
                      'ar' => 'الجولة 4: شباب قسنطينة – إتحاد بسكرة، الأربعاء 7 أكتوبر 2026 على الساعة 18:00 بملعب الشهيد حملاوي.'],
        'contenu' => ['fr' => '', 'ar' => ''],
        'tags' => ['#TheDean1898', '#CSCUSB'], 'bouton' => null,
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
