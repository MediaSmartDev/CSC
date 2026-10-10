<?php require_once __DIR__ . '/Data/lang.php'; ?>
<?php if ($LANG === 'ar'): ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/rtl.css">
<?php endif; ?>
<header id="main-header" class="main-header"> 
    <div class="topbar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-6 d-flex align-items-center">
                    <ul class="topsocial">
                        <li><a href="https://www.facebook.com/csconstantine.official" target="_blank" class="fb"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="https://www.instagram.com/csconstantine_officiel/" target="_blank" class="insta"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="https://www.youtube.com/@CSConstantineTV" target="_blank" class="yt"><i class="fab fa-youtube"></i></a></li>
                        <li><a href="https://www.tiktok.com/@clubsportifconstantinois?_r=1&_t=ZS-95LAMd2fLHg" target="_blank" class="tk">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" fill="currentColor">
                                <path d="M448 209.9a210.1 210.1 0 0 1-122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/>
                            </svg>
                        </a></li>
                        <li><a href="https://t.me/+Eb8qO-lZuXwyYTY0" target="_blank" class="tg"><i class="fab fa-telegram"></i></a></li>
                        <li><a href="https://whatsapp.com/channel/0029VayARgfHFxOv1xDBSl3n" target="_blank" class="wa"><i class="fab fa-whatsapp"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-6 d-flex align-items-center justify-content-end">
                    <ul class="toplinks">
                        <li class="csc-lang-switch">
                            <a href="<?= lang_url('fr') ?>" class="<?= $LANG === 'fr' ? 'active' : '' ?>" lang="fr">FR</a>
                            <a href="<?= lang_url('ar') ?>" class="<?= $LANG === 'ar' ? 'active' : '' ?>" lang="ar">عربي</a>
                        </li>
                        <li>
                            <a href="inscription.php" class="csc-top-inscription"><i class="fas fa-user-plus"></i> <?= L('Inscription', 'التسجيل') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="logo-navbar">
        <div class="container">
            <div class="csc-navbar">
                <div class="logo csc-logo"><a href="index.php"><img src="images/logo-dark.png?v=3" alt="CSC"></a></div>
                <nav class="main-nav csc-main-nav">
                    <ul>
                        <li class="nav-item drop-down">
                            <a href="javascript:void(0)"><?= L('Club', 'النادي') ?></a>
                            <ul>
                                <li><a href="identite.php"><?= L('Identité', 'الهوية') ?></a></li>
                                <li><a href="histoire.php"><?= L('Histoire', 'التاريخ') ?></a></li>
                                <li><a href="palmares.php"><?= L('Palmarès', 'الألقاب') ?></a></li>
                                <li><a href="partenaire.php"><?= L('Partenaires', 'الشركاء') ?></a></li>
                                <li><a href="javascript:void(0)" class="nav-empty"><?= L('Presse', 'الصحافة') ?></a></li>
                                <li><a href="javascript:void(0)" class="nav-empty"><?= L('Sponsors', 'الرعاة') ?></a></li>
                            </ul>
                        </li>
                        <li class="nav-item drop-down">
                            <a href="javascript:void(0)"><?= L('Équipe première', 'الفريق الأول') ?></a>
                            <ul>
                                <li><a href="index.php#actualites"><?= L('Actualité', 'الأخبار') ?></a></li>
                                <li><a href="javascript:void(0)" class="nav-empty"><?= L('Calendrier des matchs', 'رزنامة المباريات') ?></a></li>
                                <li><a href="resultats.php"><?= L('Résultats', 'النتائج') ?></a></li>
                                <li><a href="classement.php"><?= L('Classement', 'الترتيب') ?></a></li>
                                <li><a href="joueurs.php"><?= L('Joueurs', 'اللاعبون') ?></a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="jeunes.php"><?= L('Catégorie Jeunes', 'الفئات الشبانية') ?></a></li>
                        <li class="nav-item"><a href="equipe-feminine.php"><?= L('Équipe féminine', 'الفريق النسوي') ?></a></li>
                        <li class="nav-item"><a href="https://www.youtube.com/@CSConstantineTV" target="_blank"><?= L('CSC TV', 'قناة النادي') ?></a></li>
                        <li class="nav-item"><a href="index.php#contact-section"><?= L('Contact', 'اتصل بنا') ?></a></li>
                        <li class="csc-shop-item">
                            <a href="https://apps.apple.com/app/id371294472" target="_blank" class="csc-shop-btn">
                                <i class="fab fa-shopify"></i> <?= L('Boutique CSC', 'متجر النادي') ?>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <style>
        /* --- Barre du haut : icônes réseaux sociaux alignées --- */
        .topbar .topsocial{display:flex;align-items:center;gap:6px;margin:0;padding:0;}
        .topbar .topsocial li{display:block;margin:0;}
        .topbar .topsocial a{display:flex;align-items:center;justify-content:center;width:30px;height:30px;line-height:1;padding:0;color:#c9d6cc;background:rgba(255,255,255,.08);border-radius:4px;}
        .topbar .topsocial a i{font-size:14px;line-height:1;}
        .topbar .topsocial a svg{display:block;width:14px;height:14px;}
        .topbar .topsocial a:hover{color:#fff;}
        .topbar .topsocial a.tk:hover{background:#000;}
        .topbar .topsocial a.tg:hover{background:#229ed9;}
        .topbar .topsocial a.wa:hover{background:#25d366;}
        .topbar .toplinks{display:flex;align-items:center;gap:10px;float:none;margin:0;}
        .topbar .toplinks .btn.btn-secondary,.topbar .toplinks .btn.btn-secondary:focus,.topbar .toplinks .btn.btn-secondary:active{box-shadow:none !important;outline:none;background:none;}
        .csc-top-inscription{background:#f0c040;color:#06210f !important;padding:6px 16px;border-radius:20px;font-size:12px !important;font-weight:800;text-transform:uppercase;display:flex;align-items:center;gap:6px;white-space:nowrap;box-shadow:0 2px 8px rgba(0,0,0,.3);transition:.2s;}
        .csc-top-inscription:hover{background:#fff;color:#0a4f0a !important;}
        .csc-lang-switch{display:flex !important;align-items:center;gap:4px;background:rgba(255,255,255,.08);border-radius:20px;padding:3px;}
        .csc-lang-switch a{color:#c9d6cc !important;font-size:12px !important;font-weight:700;padding:4px 12px;border-radius:16px;text-decoration:none;line-height:1.4;}
        .csc-lang-switch a.active{background:#fff;color:#0a4f0a !important;}
        .csc-lang-switch a:hover{color:#fff !important;}
        .csc-lang-switch a.active:hover{color:#0a4f0a !important;}
        /* --- Liens pas encore disponibles (pages à compléter) --- */
        .main-nav a.nav-empty,.mobile-nav a.nav-empty{cursor:default;}
        /* --- Header : logo + menu alignés sur une seule ligne (flex) --- */
        .csc-navbar{display:flex;align-items:center;justify-content:space-between;gap:20px;min-height:90px;}
        .csc-navbar .csc-logo{padding:0;flex:0 0 auto;}
        .csc-navbar .csc-logo img{height:48px;width:auto;display:block;}
        .csc-navbar .csc-main-nav{float:none;flex:1 1 auto;}
        .csc-navbar .csc-main-nav > ul{display:flex;align-items:center;justify-content:flex-end;margin:0;padding:0;list-style:none;}
        .csc-navbar .csc-main-nav > ul > li{float:none;background:transparent !important;}
        .csc-navbar .nav-item{margin:0 2px;}
        .csc-navbar .nav-item > a{padding:0 10px;font-size:15px;line-height:90px;}
        .csc-shop-item{margin-left:10px;}
        .csc-shop-btn{background:linear-gradient(135deg,#0a4f0a,#1a7a1a);color:#fff !important;padding:8px 16px;border-radius:20px;font-size:13px;font-weight:bold;text-decoration:none;display:flex;align-items:center;gap:6px;white-space:nowrap;box-shadow:0 2px 8px rgba(0,0,0,.3);}
        @media (max-width:1199px){
            .csc-navbar .csc-logo img{height:40px;}
            .csc-navbar .nav-item > a{padding:0 6px;font-size:13px;}
            .csc-shop-btn{padding:6px 10px;font-size:12px;}
        }
    </style>
</header>