<?php require_once __DIR__ . '/Data/lang.php'; ?>
<!doctype html>
<?php
include 'Data/Dbo.php';
$today = new DateTime();
?>
<html lang="<?= $LANG ?>" dir="<?= $DIR ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" href="images/fav.png" type="image/png">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="css/responsive.css">
<link rel="stylesheet" href="css/color.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/fontawesome.css">
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/prettyPhoto.css">
<link rel="stylesheet" href="js/rev-slider/css/settings.css" type='text/css' media='all'>
<link rel="stylesheet" href="js/rev-slider/css/layers.css" type='text/css' media='all'>
<link rel="stylesheet" href="js/rev-slider/css/navigation.css" type='text/css' media='all'>
<title><?= L('Official website of CSC - Club Sportif Constantinois', 'الموقع الرسمي للنادي الرياضي القسنطيني') ?></title>
<style type="text/css">
    .static-pagetitle { background:linear-gradient(145deg,#0f830a 0,#020e01); -webkit-background-clip:text; -webkit-text-fill-color:transparent; color:#fff; text-align:center; margin:30px !important; font-weight:bold !important; }
    .ar { direction:rtl; text-align:right; font-family:"HelveticaNeue",Helvetica,Arial,sans-serif; font-size:14px; }
    .slider-tabs.wf100 { margin-top:20px !important; position:relative; z-index:1; }
    .point-table-widget { overflow-x:auto !important; }
    .point-table-widget table { min-width:300px !important; width:100% !important; }
    .point-table-widget table td, .point-table-widget table th { display:table-cell !important; visibility:visible !important; opacity:1 !important; white-space:nowrap !important; padding:6px 8px !important; font-size:12px !important; }

    /* SPONSORS STRIP */
    .sponsor-strip { width:100%; background:#fff; overflow:hidden; position:relative; z-index:99; padding:30px 0; border-top:1px solid #eee; border-bottom:1px solid #eee; }
    .sponsor-strip::before,.sponsor-strip::after { content:""; height:100%; position:absolute; width:8%; z-index:2; pointer-events:none; top:0; }
    .sponsor-strip::before { left:0; background:linear-gradient(to right,#fff 0%,rgba(255,255,255,0) 100%); }
    .sponsor-strip::after  { right:0; background:linear-gradient(to left,#fff 0%,rgba(255,255,255,0) 100%); }
    .sponsor-track-outer { display:flex; width:max-content; animation:scrollSponsors 30s linear infinite; }
    .sponsor-strip:hover .sponsor-track-outer { animation-play-state:paused; }
    .sponsor-track { display:flex; align-items:center; flex-shrink:0; }
    .sponsor-item { display:flex; align-items:center; justify-content:center; width:200px; height:80px; margin:0 40px; transition:transform 0.3s ease; }
    .sponsor-item { box-sizing:border-box; padding:4px 8px; }
    .sponsor-item a { display:flex; align-items:center; justify-content:center; width:100%; height:100%; }
    .sponsor-item img { max-width:100%; max-height:100%; width:auto; height:auto; object-fit:contain; display:block; }
    .sponsor-item:hover { transform:scale(1.1); }
    @keyframes scrollSponsors { from{transform:translateX(0)} to{transform:translateX(-50%)} }
    @media(max-width:768px){ .sponsor-strip{padding:18px 0} .sponsor-item{width:120px;height:50px;margin:0 20px} .sponsor-track-outer{animation-duration:20s} }

    /* PALMARES */
    .pal-stat-strip { display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:0; background:#fff; border:2px solid #0a4f0a; border-radius:14px; padding:20px 30px; }
    .pal-stat-item { text-align:center; padding:8px 28px; flex:1; min-width:110px; }
    .pal-stat-num { display:block; font-size:34px; font-weight:900; color:#0a4f0a; line-height:1; margin-bottom:5px; }
    .pal-stat-num sup { font-size:18px; }
    .pal-stat-lbl { font-size:11px; color:#666; text-transform:uppercase; letter-spacing:0.8px; line-height:1.4; }
    .pal-stat-lbl small { display:block; font-size:10px; color:#0a4f0a; font-weight:700; }
    .pal-stat-divider { width:1px; height:48px; background:#ddd; flex-shrink:0; }
    .pal-col { margin-bottom:24px; }
    .pal-card { background:#fff; border-radius:14px; border:1.5px solid #d4ead4; height:100%; overflow:hidden; transition:box-shadow 0.2s,transform 0.2s; }
    .pal-card:hover { box-shadow:0 8px 28px rgba(10,79,10,0.13); transform:translateY(-3px); }
    .pal-card-header { background:linear-gradient(135deg,#0a4f0a 0%,#1a7a1a 100%); padding:20px 20px 16px; text-align:center; }
    .pal-icon { font-size:28px; display:block; margin-bottom:6px; }
    .pal-card-title { color:#fff; font-size:15px; font-weight:800; margin:0 0 4px 0; }
    .pal-card-sub { color:rgba(255,255,255,0.75); font-size:11px; margin:0; }
    .pal-card-body { padding:18px 16px; }
    .pal-trophy { margin-bottom:14px; }
    .pal-trophy:last-child { margin-bottom:0; }
    .pal-trophy-label { display:block; font-size:12px; font-weight:700; color:#0a4f0a; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:7px; padding-bottom:5px; border-bottom:1px solid #e8f5e8; }
    .pal-years { list-style:none; padding:0; margin:0; }
    .pal-years li { font-size:13px; color:#444; padding:3px 0 3px 14px; position:relative; }
    .pal-years li::before { content:'•'; position:absolute; left:0; color:#0a4f0a; font-weight:bold; }
    .pal-trophy.champion .pal-trophy-label { color:#b8860b; }
    .pal-trophy.champion .pal-years li::before { color:#b8860b; }
    .pal-trophy.vice .pal-trophy-label { color:#888; }
    .pal-trophy.vice .pal-years li::before { color:#888; }
    .pal-trophy.africa-highlight { background:#f0fff0; border-radius:8px; padding:10px 12px; }
    .pal-doyen-banner { background:linear-gradient(135deg,#062e06 0%,#0a4f0a 50%,#1a7a1a 100%); border-radius:16px; padding:28px 36px; display:flex; align-items:center; gap:28px; flex-wrap:wrap; }
    .pal-doyen-left { flex-shrink:0; }
    .pal-doyen-center { flex:1; min-width:200px; }
    .pal-doyen-badge { display:inline-block; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:#fff; font-size:11px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; padding:4px 14px; border-radius:20px; margin-bottom:8px; }
    .pal-doyen-center p { color:rgba(255,255,255,0.85); font-size:14px; margin:0; line-height:1.6; }
    .pal-doyen-center p strong { color:#fff; }
    .pal-doyen-right { flex-shrink:0; }
    .pal-history-btn { display:inline-block; background:#fff; color:#0a4f0a; font-weight:700; font-size:13px; padding:10px 22px; border-radius:22px; text-decoration:none; transition:background 0.2s; white-space:nowrap; }
    .pal-history-btn:hover { background:#e8f5e8; color:#062e06; }
    @media(max-width:768px){ .pal-stat-strip{padding:16px 12px} .pal-stat-item{padding:8px 14px;min-width:80px} .pal-stat-num{font-size:26px} .pal-stat-divider{display:none} .pal-doyen-banner{padding:20px;flex-direction:column;text-align:center;gap:16px} }

    /* FORME RECENTE */
    .forme-widget { background:#fff; border-radius:12px; border:1.5px solid #d4ead4; padding:16px 18px; margin-top:16px; }
    .forme-title { font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:#0a4f0a; margin-bottom:12px; border-bottom:1px solid #e8f5e8; padding-bottom:8px; }
    .forme-badges { display:flex; gap:7px; justify-content:center; flex-wrap:wrap; }
    .forme-badge { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:900; color:#fff; }
    .forme-badge.v { background:#0a4f0a; }
    .forme-badge.n { background:#888; }
    .forme-badge.d { background:#c0392b; }
    .dernier-resultat { text-align:center; margin:4px 0 12px; }
    .dernier-resultat .dr-lbl { display:block; font-size:11px; color:#888; text-transform:uppercase; letter-spacing:.5px; }
    .dernier-resultat .dr-score { font-weight:700; color:#111; font-size:15px; }
    .dernier-resultat .dr-score b { background:#0a4f0a; color:#fff; border-radius:6px; padding:1px 8px; margin:0 4px; }
    .forme-stats { display:flex; justify-content:space-around; margin-top:14px; padding-top:12px; border-top:1px solid #e8f5e8; }
    .forme-stat-item { text-align:center; }
    .forme-stat-num { display:block; font-size:20px; font-weight:900; color:#0a4f0a; line-height:1; }
    .forme-stat-lbl { font-size:10px; color:#888; text-transform:uppercase; letter-spacing:0.5px; }

    /* NEWS CAROUSEL */
    .news-card-link { cursor:pointer; }
    .csc-scroll-wrapper { position:relative; overflow:hidden; }
    .csc-scroll-track { display:flex; gap:20px; overflow-x:auto; scroll-snap-type:x mandatory; -webkit-overflow-scrolling:touch; scrollbar-width:none; padding-bottom:8px; scroll-behavior:smooth; }
    .csc-scroll-track::-webkit-scrollbar { display:none; }
    .csc-scroll-card { flex:0 0 320px; scroll-snap-align:start; position:relative; border-radius:14px; overflow:hidden; cursor:pointer; background:#111; height:420px; transition:transform 0.25s ease,box-shadow 0.25s ease; }
    .csc-scroll-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(0,0,0,0.25); }
    .csc-scroll-card img { width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.4s ease; }
    .csc-scroll-card:hover img { transform:scale(1.04); }
    .csc-scroll-card .overlay { position:absolute; inset:0; background:linear-gradient(to top,rgba(0,0,0,0.85) 45%,rgba(0,0,0,0.1) 100%); }
    .csc-scroll-card .card-label { position:absolute; top:14px; left:14px; background:#0a4f0a; color:#fff; font-size:10px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; padding:4px 12px; border-radius:20px; }
    .csc-scroll-card .card-bottom { position:absolute; bottom:0; left:0; right:0; padding:18px 16px 16px; }
    .csc-scroll-card .card-title { color:#fff; font-size:15px; font-weight:700; line-height:1.4; margin:0 0 8px; }
    .csc-scroll-card .card-desc { color:rgba(255,255,255,0.75); font-size:12.5px; line-height:1.6; margin:0 0 10px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .csc-scroll-card .card-desc.ar { direction:rtl; text-align:right; }
    .csc-scroll-card .card-hashtags { display:flex; flex-wrap:wrap; gap:6px; margin-bottom:10px; }
    .csc-scroll-card .card-hashtags span { background:rgba(10,79,10,0.6); color:#a8e6a8; font-size:10px; font-weight:700; padding:3px 9px; border-radius:20px; }
    .card-ticket-btn { display:inline-flex; align-items:center; gap:6px; background:#fff; color:#0a4f0a; font-size:12px; font-weight:800; padding:7px 16px; border-radius:20px; text-decoration:none; transition:background 0.2s,color 0.2s; direction:rtl; margin-top:4px; }
    .card-ticket-btn:hover { background:#0a4f0a; color:#fff; text-decoration:none; }
    .csc-scroll-btn { position:absolute; top:50%; transform:translateY(-50%); width:42px; height:42px; border-radius:50%; background:#0a4f0a; color:#fff; border:none; font-size:26px; line-height:1; cursor:pointer; z-index:10; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 14px rgba(0,0,0,0.25); transition:background 0.2s,transform 0.2s; }
    .csc-scroll-btn:hover { background:#062e06; transform:translateY(-50%) scale(1.08); }
    .csc-scroll-prev { left:0; }
    .csc-scroll-next { right:0; }
    @media(max-width:768px){ .csc-scroll-card{flex:0 0 280px;height:400px;} .csc-scroll-btn{display:none;} }

    /* SHARE MODAL */
    .share-modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; }
    .share-modal-overlay.active { display:flex; }
    .share-modal { background:#fff; border-radius:16px; padding:28px 24px; max-width:420px; width:90%; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.3); }
    .share-modal-close { position:absolute; top:14px; right:16px; font-size:22px; cursor:pointer; color:#888; line-height:1; background:none; border:none; }
    .share-modal h4 { font-size:15px; font-weight:800; color:#111; margin:0 0 6px; line-height:1.4; }
    .share-modal p { font-size:12px; color:#666; margin:0 0 20px; }
    .share-btns { display:flex; flex-direction:column; gap:10px; }
    .share-btn { display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-weight:700; transition:opacity 0.2s; }
    .share-btn:hover { opacity:0.85; }
    .share-btn.copy { background:#0a4f0a; color:#fff; }
    .share-btn.whats { background:#25D366; color:#fff; }
    .share-btn.copy.copied { background:#888; }
    .share-feedback { font-size:12px; color:#0a4f0a; text-align:center; margin-top:10px; min-height:18px; font-weight:700; }
    #actualites,#contact-section,#palmares{scroll-margin-top:90px;}
</style>
</head>
<body>
<div class="wrapper"> 
    <?php require 'header.php';?>

<?php require_once __DIR__ . '/Data/medias.php'; $HERO = csc_hero(); if ($HERO): ?>
    <!-- VIDÉO D'ACCUEIL (réglée dans l'admin : Vidéos) -->
    <section class="csc-hero" aria-label="<?= L('Club video', 'فيديو النادي') ?>">
        <video class="csc-hero-video" id="cscHeroVideo" src="<?= htmlspecialchars($HERO['video']) ?>"<?= $HERO['poster'] !== '' ? ' poster="' . htmlspecialchars($HERO['poster']) . '"' : '' ?> autoplay muted loop playsinline preload="auto"></video>
        <div class="csc-hero-shade"></div>
        <div class="csc-hero-in">
            <div class="container">
                <?php if ($HERO['titre'] !== ''): ?><h1 class="csc-hero-title"><?= htmlspecialchars($HERO['titre']) ?></h1><?php endif; ?>
                <?php if ($HERO['texte'] !== ''): ?><p class="csc-hero-text"><?= htmlspecialchars($HERO['texte']) ?></p><?php endif; ?>
                <?php if ($HERO['bouton'] !== '' && $HERO['lien'] !== ''): ?><a class="csc-hero-btn" href="<?= htmlspecialchars($HERO['lien']) ?>"<?= preg_match('#^https?://#i', $HERO['lien']) ? ' target="_blank" rel="noopener"' : '' ?>><?= htmlspecialchars($HERO['bouton']) ?></a><?php endif; ?>
            </div>
        </div>
        <button type="button" class="csc-hero-sound" id="cscHeroSound" aria-pressed="false" aria-label="<?= L('Turn sound on', 'تشغيل الصوت') ?>" data-on="<?= L('Mute', 'كتم الصوت') ?>" data-off="<?= L('Turn sound on', 'تشغيل الصوت') ?>"><i class="fas fa-volume-mute"></i></button>
        <a class="csc-hero-down" href="#calendrier" aria-label="<?= L('Scroll down', 'إلى الأسفل') ?>"><i class="fas fa-chevron-down"></i></a>
    </section>
    <style>
        .csc-hero{position:relative;width:100%;height:calc(100vh - 120px);min-height:440px;max-height:780px;background:#03140c;overflow:hidden;color:#fff;}
        body.has-pub-bar .csc-hero{height:calc(100vh - 130px - 5vw);}
        .csc-hero-video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;}
        .csc-hero-shade{position:absolute;inset:0;background:linear-gradient(to top,rgba(3,20,12,.88) 0%,rgba(3,20,12,.35) 40%,rgba(0,0,0,0) 70%);pointer-events:none;}
        .csc-hero-in{position:absolute;left:0;right:0;bottom:70px;}
        .wrapper .csc-hero-title{color:#fff;font-size:56px;line-height:1.05;font-weight:800;text-transform:uppercase;letter-spacing:.5px;max-width:820px;margin:0 0 12px;text-shadow:0 2px 18px rgba(0,0,0,.35);}
        .csc-hero-text{font-size:18px;line-height:1.5;max-width:640px;margin:0 0 22px;color:rgba(255,255,255,.9);}
        .csc-hero-btn{display:inline-block;background:#0a7d3b;color:#fff;font-weight:700;text-transform:uppercase;letter-spacing:.6px;font-size:14px;padding:13px 30px;border-radius:30px;transition:background .2s,transform .2s;}
        .csc-hero-btn:hover{background:#fff;color:#0a4f0a;transform:translateY(-2px);}
        .csc-hero-sound{position:absolute;right:24px;bottom:24px;width:44px;height:44px;border-radius:50%;border:2px solid rgba(255,255,255,.7);background:rgba(0,0,0,.25);color:#fff;font-size:16px;cursor:pointer;}
        .csc-hero-sound:hover{background:#fff;color:#0a4f0a;}
        .csc-hero-down{position:absolute;left:50%;bottom:18px;margin-left:-18px;width:36px;height:36px;line-height:36px;text-align:center;color:#fff;font-size:18px;animation:cscHeroBounce 2s infinite;}
        .csc-hero-down:hover{color:#fff;}
        @keyframes cscHeroBounce{0%,100%{transform:translateY(0);}50%{transform:translateY(6px);}}
        html[dir="rtl"] .csc-hero-sound{right:auto;left:24px;}
        @media (max-width:767px){
            .csc-hero{height:62vh;min-height:320px;}
            .csc-hero-in{bottom:56px;}
            .wrapper .csc-hero-title{font-size:30px;}
            .csc-hero-text{font-size:15px;margin-bottom:16px;}
            .csc-hero-sound{right:14px;bottom:14px;width:38px;height:38px;font-size:14px;}
            html[dir="rtl"] .csc-hero-sound{left:14px;}
            .csc-hero-down{display:none;}
        }
        @media (prefers-reduced-motion:reduce){.csc-hero-down{animation:none;}}
    </style>
    <script>
    (function () {
        var v = document.getElementById('cscHeroVideo'), b = document.getElementById('cscHeroSound');
        if (!v || !b) return;
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) v.removeAttribute('autoplay'), v.pause();
        b.addEventListener('click', function () {
            v.muted = !v.muted;
            if (!v.muted) v.play();
            b.setAttribute('aria-pressed', v.muted ? 'false' : 'true');
            b.setAttribute('aria-label', v.muted ? b.dataset.off : b.dataset.on);
            b.innerHTML = '<i class="fas ' + (v.muted ? 'fa-volume-mute' : 'fa-volume-up') + '"></i>';
        });
    })();
    </script>
<?php else: ?>
    <!-- BANNIÈRE -->
    <section class="csc-banner">
        <img src="images/banner-csc.jpg" alt="<?= L('CS Constantine 1898', 'النادي الرياضي القسنطيني 1898') ?>">
    </section>
<?php endif; ?>
    <style>
        .csc-banner{width:100%;background:#03140c;line-height:0;overflow:hidden;}
        .csc-banner img{display:block;width:100%;height:auto;max-height:620px;object-fit:cover;object-position:center;}
    </style>

    <div class="main-content wf100"> 
        <!-- SPONSORS ANIMÉS -->
        <div class="sponsor-strip" id="sponsors-section">
            <div class="sponsor-track-outer">
                <?php require_once __DIR__ . '/Data/sponsors.php'; $SPONSORS = csc_sponsors(); ?>
                <?= csc_sponsors_track($SPONSORS) ?>
                <?= csc_sponsors_track($SPONSORS, true) ?>
            </div>
        </div>

        <!-- APPEL À L'INSCRIPTION -->
        <section class="csc-cta-inscription">
            <div class="container">
                <div class="csc-cta-box">
                    <div>
                        <h3><?= L('Want to join CSC?', 'هل ترغب في الانضمام إلى النادي؟') ?></h3>
                        <p><?= L('Administration, marketing, logistics, communication: offer your skills to the club.', 'الإدارة، التسويق، اللوجستيك، الاتصال: اقترح كفاءاتك على النادي.') ?></p>
                    </div>
                    <a href="inscription.php" class="csc-cta-btn"><i class="fas fa-user-plus"></i> <?= L('Sign up now', 'سجّل الآن') ?></a>
                </div>
            </div>
        </section>
        <style>
            .csc-cta-inscription{padding:35px 0 0;}
            .csc-cta-box{display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;background:linear-gradient(135deg,#06210f,#0a4f0a 60%,#1a7a1a);border-radius:16px;padding:28px 36px;box-shadow:0 10px 30px rgba(10,79,10,.25);}
            .csc-cta-box h3{color:#fff;font-weight:800;margin:0 0 6px;}
            .csc-cta-box p{color:rgba(255,255,255,.8);margin:0;}
            .csc-cta-btn{background:#f0c040;color:#06210f;font-weight:800;padding:14px 30px;border-radius:30px;white-space:nowrap;text-decoration:none;transition:.2s;}
            .csc-cta-btn:hover{background:#fff;color:#0a4f0a;text-decoration:none;}
            @media(max-width:768px){.csc-cta-box{padding:22px;text-align:center;justify-content:center;}}
        </style>

        <!-- PROCHAIN MATCH + CLASSEMENT -->
        <section class="wf100 p80" id="calendrier" style="padding-top:30px !important;">
            <div class="container">
                <div class="row">
                    <?php
                    require_once __DIR__ . '/Data/calendrier.php';
                    $joues   = matchs_joues();
                    $avenir  = matchs_a_venir();
                    $next    = $avenir[0] ?? null;
                    $dernier = $joues ? $joues[count($joues) - 1] : null;
                    $bilan   = bilan_csc();
                    $forme   = array_slice($joues, -5);
                    $lettres = ['v' => [L('W', 'ف'), L('Win', 'فوز')], 'n' => [L('D', 'ت'), L('Draw', 'تعادل')], 'd' => [L('L', 'خ'), L('Loss', 'خسارة')]];
                    ?>
                    <!-- COL 1 : Prochain Match + Forme Récente -->
                    <div class="col-lg-4 col-md-6">
                        <?php if ($next): $d = club_info($next['dom']); $e = club_info($next['ext']); ?>
                        <div class="next-match-widget">
                            <h5 class="title"><?= L('Next match', 'المباراة القادمة') ?></h5>
                            <div class="nmw-wrap">
                                <ul class="match-teams-vs">
                                    <li class="team-logo">
                                        <img src="<?= htmlspecialchars($d['logo']) ?>" alt="" style="width:60px;height:60px;object-fit:contain;">
                                        <strong><?= club_court($next['dom']) ?></strong>
                                    </li>
                                    <li class="mvs"><strong class="vs"><?= L('VS', 'ضد') ?></strong></li>
                                    <li class="team-logo">
                                        <img src="<?= htmlspecialchars($e['logo']) ?>" alt="" style="width:60px;height:60px;object-fit:contain;">
                                        <strong><?= club_court($next['ext']) ?></strong>
                                    </li>
                                </ul>
                                <ul class="nmw-txt">
                                    <li><strong><?= L('Ligue 1', 'الرابطة الأولى') ?> — <?= L('Matchday', 'الجولة') ?> <?= (int)$next['j'] ?></strong></li>
                                    <p><?= match_date($next) ?></p>
                                    <li><?= match_heure($next) ?></li>
                                    <li><span><?= match_stade($next) ?></span></li>
                                    <?php if (!empty($next['slogan_fr'])): ?><li><em>« <?= htmlspecialchars(L($next['slogan_fr'], $next['slogan_ar'])) ?> »</em></li><?php endif; ?>
                                    <?php if (!empty($next['actu'])): ?><li><a href="actualite.php?id=<?= (int)$next['actu'] ?>" style="color:#0a4f0a;font-weight:700;"><?= L("See the poster", 'شاهد الملصق') ?> →</a></li><?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- FORME RECENTE -->
                        <div class="forme-widget">
                            <div class="forme-title">⚽ <?= L('Recent form — CSC', 'آخر النتائج') ?></div>
                            <?php if ($dernier): ?>
                            <div class="dernier-resultat">
                                <span class="dr-lbl"><?= L('Last match', 'آخر مباراة') ?> (<?= L('MD', 'ج') ?><?= (int)$dernier['j'] ?>)</span>
                                <span class="dr-score"><?= club_court($dernier['dom']) ?> <b><?= (int)$dernier['bd'] ?> - <?= (int)$dernier['be'] ?></b> <?= club_court($dernier['ext']) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="forme-badges">
                                <?php foreach ($forme as $m): $r = match_resultat($m); ?>
                                <div class="forme-badge <?= $r ?>" title="<?= $lettres[$r][1] ?> : <?= club_court($m['dom']) ?> <?= (int)$m['bd'] ?>-<?= (int)$m['be'] ?> <?= club_court($m['ext']) ?>"><?= $lettres[$r][0] ?></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="forme-stats">
                                <div class="forme-stat-item"><span class="forme-stat-num"><?= $bilan['v'] ?></span><span class="forme-stat-lbl"><?= L('Wins', 'انتصارات') ?></span></div>
                                <div class="forme-stat-item"><span class="forme-stat-num"><?= $bilan['n'] ?></span><span class="forme-stat-lbl"><?= L('Draws', 'تعادلات') ?></span></div>
                                <div class="forme-stat-item"><span class="forme-stat-num"><?= $bilan['d'] ?></span><span class="forme-stat-lbl"><?= L('Losses', 'هزائم') ?></span></div>
                                <div class="forme-stat-item"><span class="forme-stat-num"><?= $bilan['pts'] ?></span><span class="forme-stat-lbl"><?= L('Points', 'نقاط') ?></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- COL 2 : 3 matchs suivants -->
                    <div class="col-lg-4 col-md-6">
                        <?php foreach (array_slice($avenir, 1, 3) as $m): $d = club_info($m['dom']); $e = club_info($m['ext']); ?>
                        <div class="next-match-fixtures">
                            <ul class="match-teams-vs">
                                <li class="team-logo"><img src="<?= htmlspecialchars($d['logo']) ?>" alt="" style="width:50px;height:50px;object-fit:contain;"><strong><?= club_court($m['dom']) ?></strong></li>
                                <li class="mvs"><p><strong><?= L('Ligue 1', 'الرابطة الأولى') ?> — <?= L('MD', 'ج') ?><?= (int)$m['j'] ?></strong> <?= match_date($m) ?><br><?= match_heure($m) ?></p><strong class="vs"><?= L('VS', 'ضد') ?></strong></li>
                                <li class="team-logo"><img src="<?= htmlspecialchars($e['logo']) ?>" alt="" style="width:50px;height:50px;object-fit:contain;"><strong><?= club_court($m['ext']) ?></strong></li>
                            </ul>
                            <ul class="nmf-loc"><li><i class="fas fa-location-arrow"></i> <?= match_stade($m) ?></li></ul>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- COL 3 : Classement -->
                    <div class="col-lg-4">
                        <div class="point-table-widget">
                            <table>
                                <thead>
                                    <tr><th></th><th><?= L('Team', 'الفريق') ?></th><th><?= L('W', 'ف') ?></th><th><?= L('D', 'ت') ?></th><th><?= L('L', 'خ') ?></th><th><?= L('Pts', 'ن') ?></th></tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try { $classement = getClassmentTable(); } catch (Throwable $e) { $classement = []; }
                                    if (!is_array($classement)) { $classement = []; }
                                    foreach ($classement as $row) {
                                        $csc = (strtolower($row["club"]) === 'csc' || strpos(strtolower($row["club"]), 'constantine') !== false)
                                            ? 'style="background:rgba(10,79,10,0.08);font-weight:bold;"' : '';
                                        echo '<tr '.$csc.'>
                                            <td><strong>'.$row["pos"].'</strong></td>
                                            <td><img src="'.$row["logo"].'" alt="'.htmlspecialchars(club_name($row)).'" style="height:22px;margin-right:5px;"><strong>'.htmlspecialchars(club_name($row)).'</strong></td>
                                            <td>'.$row["g"].'</td>
                                            <td>'.$row["n"].'</td>
                                            <td>'.$row["p"].'</td>
                                            <td><strong>'.$row["points"].'</strong></td>
                                        </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ACTUALITES CAROUSEL -->
        <section class="wf100 p80 sports-news" id="actualites">
            <div class="container">
                <div class="row"><div class="col-md-12"><div class="section-title"><h2><?= L('CSC News', 'أخبار النادي') ?></h2></div></div></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="csc-scroll-wrapper">
                            <div class="csc-scroll-track">
<?php require_once __DIR__ . '/Data/news.php'; foreach (csc_news_all() as $n): ?>
                                <div class="csc-scroll-card news-card-link" data-url="actualite.php?id=<?= (int)$n['id'] ?>">
                                    <img src="<?= htmlspecialchars(news_img($n['image'])) ?>" alt="">
                                    <div class="overlay"></div>
                                    <span class="card-label"><?= htmlspecialchars(nt($n, 'label')) ?></span>
                                    <div class="card-bottom">
                                        <p class="card-title"><?= htmlspecialchars(nt($n, 'titre')) ?></p>
                                        <p class="card-desc<?= $LANG === 'ar' ? ' ar' : '' ?>"><?= htmlspecialchars(nt($n, 'resume')) ?></p>
                                        <div class="card-hashtags"><?php foreach ($n['tags'] as $t): ?><span><?= htmlspecialchars($t) ?></span><?php endforeach; ?></div>
                                        <?php if (!empty($n['bouton'])): ?><a href="<?= htmlspecialchars($n['bouton']['lien']) ?>" target="_blank" class="card-ticket-btn" onclick="event.stopPropagation();"><?= htmlspecialchars(L($n['bouton']['fr'], $n['bouton']['ar'])) ?></a><?php endif; ?>
                                    </div>
                                </div>
<?php endforeach; ?>
                            </div><!-- /.csc-scroll-track -->
                            <button class="csc-scroll-btn csc-scroll-prev">&#8249;</button>
                            <button class="csc-scroll-btn csc-scroll-next">&#8250;</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php $VIDEOS = csc_videos(); if ($VIDEOS): ?>
        <!-- VIDÉOS (YouTube, réglées dans l'admin : Vidéos) -->
        <section class="wf100 csc-tv" id="videos">
            <div class="container">
                <div class="csc-tv-head">
                    <div class="section-title white"><h2><?= L('Videos', 'فيديوهات') ?></h2></div>
                    <a class="csc-tv-all" href="https://www.youtube.com/@CSConstantineTV" target="_blank" rel="noopener"><i class="fab fa-youtube"></i> <?= L('Watch CSC TV', 'شاهد CSC TV') ?></a>
                </div>
                <div class="csc-tv-wrap">
                    <div class="csc-tv-track" id="cscTvTrack">
<?php foreach ($VIDEOS as $i => $vd): ?>
                        <button type="button" class="csc-tv-card<?= $i === 0 ? ' is-first' : '' ?>" data-yt="<?= htmlspecialchars($vd['id']) ?>" aria-label="<?= L('Play video', 'تشغيل الفيديو') ?> : <?= htmlspecialchars($vd['titre']) ?>">
                            <span class="csc-tv-thumb"><img src="https://img.youtube.com/vi/<?= htmlspecialchars($vd['id']) ?>/hqdefault.jpg" alt="" loading="lazy"><span class="csc-tv-play"><i class="fas fa-play"></i></span></span>
                            <span class="csc-tv-title"><?= htmlspecialchars($vd['titre']) ?></span>
                        </button>
<?php endforeach; ?>
                    </div>
                    <button type="button" class="csc-tv-nav csc-tv-prev" aria-label="<?= L('Previous', 'السابق') ?>">&#8249;</button>
                    <button type="button" class="csc-tv-nav csc-tv-next" aria-label="<?= L('Next', 'التالي') ?>">&#8250;</button>
                </div>
            </div>
        </section>
        <div class="csc-tv-modal" id="cscTvModal" role="dialog" aria-modal="true" aria-label="<?= L('Video', 'فيديو') ?>">
            <div class="csc-tv-box"><button type="button" class="csc-tv-close" aria-label="<?= L('Close', 'إغلاق') ?>">&times;</button><div class="csc-tv-frame" id="cscTvFrame"></div></div>
        </div>
        <style>
            .csc-tv{background:#03140c;background:linear-gradient(180deg,#03140c 0%,#06301a 100%);padding:70px 0 60px;color:#fff;}
            .csc-tv-head{display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:10px;}
            .csc-tv-head .section-title{width:auto;float:none;margin:0;}
            .csc-tv-all{color:#fff;border:1px solid rgba(255,255,255,.5);border-radius:30px;padding:8px 20px;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;}
            .csc-tv-all:hover{background:#fff;color:#c00;}
            .csc-tv-wrap{position:relative;}
            .csc-tv-track{display:flex;gap:20px;overflow-x:auto;scroll-snap-type:x mandatory;scrollbar-width:none;padding:14px 2px 6px;}
            .csc-tv-track::-webkit-scrollbar{display:none;}
            .csc-tv-card{flex:0 0 340px;scroll-snap-align:start;align-self:flex-start;display:flex;flex-direction:column;background:none;border:0;padding:0;color:#fff;text-align:start;cursor:pointer;}
            .csc-tv-card.is-first{flex-basis:520px;}
            .csc-tv-thumb{position:relative;display:block;aspect-ratio:16/9;border-radius:12px;overflow:hidden;background:#000;}
            .csc-tv-thumb img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s ease;}
            .csc-tv-thumb:after{content:"";position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.55),rgba(0,0,0,0) 55%);}
            .csc-tv-play{position:absolute;left:14px;bottom:14px;z-index:1;width:46px;height:46px;border-radius:50%;background:#0a7d3b;display:flex;align-items:center;justify-content:center;font-size:15px;padding-left:3px;transition:transform .2s;}
            html[dir="rtl"] .csc-tv-play{left:auto;right:14px;}
            .csc-tv-card:hover .csc-tv-thumb img,.csc-tv-card:focus-visible .csc-tv-thumb img{transform:scale(1.05);}
            .csc-tv-card:hover .csc-tv-play{transform:scale(1.1);background:#fff;color:#0a7d3b;}
            .csc-tv-title{display:block;margin-top:12px;font-weight:600;font-size:15px;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
            .csc-tv-nav{position:absolute;top:calc(50% - 40px);width:42px;height:42px;border-radius:50%;border:0;background:rgba(255,255,255,.9);color:#0a4f0a;font-size:26px;line-height:38px;cursor:pointer;z-index:2;box-shadow:0 4px 14px rgba(0,0,0,.3);}
            .csc-tv-prev{left:-12px;} .csc-tv-next{right:-12px;}
            .csc-tv-modal{display:none;position:fixed;inset:0;z-index:10000;background:rgba(0,0,0,.85);align-items:center;justify-content:center;padding:20px;}
            .csc-tv-modal.open{display:flex;}
            .csc-tv-box{position:relative;width:100%;max-width:1000px;}
            .csc-tv-frame{position:relative;aspect-ratio:16/9;background:#000;}
            .csc-tv-frame iframe{position:absolute;inset:0;width:100%;height:100%;border:0;}
            .csc-tv-close{position:absolute;top:-44px;right:0;width:38px;height:38px;border-radius:50%;border:0;background:#fff;color:#000;font-size:24px;line-height:36px;cursor:pointer;}
            html[dir="rtl"] .csc-tv-close{right:auto;left:0;}
            @media (max-width:767px){
                .csc-tv{padding:50px 0 40px;}
                .csc-tv-card,.csc-tv-card.is-first{flex-basis:78%;}
                .csc-tv-nav{display:none;}
            }
        </style>
        <script>
        (function () {
            var track = document.getElementById('cscTvTrack'), modal = document.getElementById('cscTvModal'), frame = document.getElementById('cscTvFrame');
            if (!track) return;
            var rtl = document.documentElement.dir === 'rtl';
            document.querySelectorAll('.csc-tv-nav').forEach(function (b) {
                b.addEventListener('click', function () {
                    var step = track.clientWidth * 0.8 * (b.classList.contains('csc-tv-next') ? 1 : -1) * (rtl ? -1 : 1);
                    track.scrollBy({ left: step, behavior: 'smooth' });
                });
            });
            function close() { modal.classList.remove('open'); frame.innerHTML = ''; }
            track.addEventListener('click', function (e) {
                var c = e.target.closest('.csc-tv-card');
                if (!c || !/^[A-Za-z0-9_-]{11}$/.test(c.dataset.yt)) return;
                var f = document.createElement('iframe');
                f.src = 'https://www.youtube-nocookie.com/embed/' + c.dataset.yt + '?autoplay=1&rel=0';
                f.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen';
                f.allowFullscreen = true;
                f.title = c.querySelector('.csc-tv-title').textContent;
                frame.innerHTML = ''; frame.appendChild(f);
                modal.classList.add('open');
                modal.querySelector('.csc-tv-close').focus();
            });
            modal.addEventListener('click', function (e) { if (e.target === modal || e.target.closest('.csc-tv-close')) close(); });
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && modal.classList.contains('open')) close(); });
        })();
        </script>
<?php endif; ?>
        <!-- SHARE MODAL -->
        <div class="share-modal-overlay" id="shareModal">
            <div class="share-modal">
                <button class="share-modal-close" id="shareClose">&times;</button>
                <h4 id="shareTitle"></h4>
                <p><?= L('Share this article', 'شارك هذا الخبر') ?></p>
                <div class="share-btns">
                    <button class="share-btn copy" id="copyBtn">&nbsp; <?= L('Copy link', 'نسخ الرابط') ?></button>
                    <button class="share-btn whats" id="whatsBtn">&nbsp; <?= L('Share on WhatsApp', 'مشاركة عبر واتساب') ?></button>
                </div>
                <div class="share-feedback" id="shareFeedback"></div>
            </div>
        </div>

        <!-- JOUEURS -->
        <section class="team-squad wf100 p80-50">
            <div class="container">
                <div class="row">
                    <div class="col-md-12"><div class="section-title white"><h2><?= L('Players', 'اللاعبون') ?></h2><a class="full-team" href="joueurs.php"><?= L('See the full team', 'كل الفريق') ?></a></div></div>
                </div>
                <div class="row">
                    <?php foreach (getHomePlayers() as $pl): ?>
                    <div class="col-md-6"><div class="player-box with-extra-info"><div class="player-thumb"><img src="<?= htmlspecialchars(!empty($pl['img']) ? $pl['img'] : 'images/player-default.png') ?>" alt="<?= htmlspecialchars(player_name($pl)) ?>" width="240"></div><div class="player-txt"><h3><?= htmlspecialchars(player_name($pl)) ?></h3><br><ul class="pb-small-info"><li><?= L('No.', 'الرقم') ?> <strong><?= (int)$pl['dossard'] ?></strong></li><li><?= L('Position', 'المنصب') ?> <strong><?= htmlspecialchars(player_poste($pl)) ?></strong></li><li><?= L('Age', 'العمر') ?> <strong><?= playerAge($pl) ?> <?= L('years', 'سنة') ?></strong></li></ul></div></div></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="wf100 p80 players-squad portfolio filter-gallery">
            <div class="container"><div class="row"><div class="col-md-12"><div class="static-pagetitle"><h2><?= L('Official website of CSC - Club Sportif Constantinois', 'الموقع الرسمي للنادي الرياضي القسنطيني') ?></h2></div></div></div></div>
        </section>

        <!-- PALMARES -->
        <section class="wf100 p80" id="palmares" style="background:#f7fdf7;">
            <div class="container">
                <div class="row"><div class="col-md-12"><div class="section-title"><h2><?= L('Honours', 'الألقاب') ?></h2></div><p style="text-align:center;color:#555;font-size:15px;margin-top:-10px;margin-bottom:40px;"><?= L('Trace the trophy-rich history of one of the pillars of Algerian football.', 'تاريخ حافل بالإنجازات لأحد أعمدة كرة القدم الجزائرية.') ?></p></div></div>
                <div class="row" style="margin-bottom:40px;">
                    <div class="col-md-12">
                        <div class="pal-stat-strip">
                            <div class="pal-stat-item"><span class="pal-stat-num">1898</span><span class="pal-stat-lbl"><?= L('Year founded', 'سنة التأسيس') ?></span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num">02</span><span class="pal-stat-lbl"><?= L('League titles', 'ألقاب البطولة') ?></span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num">06</span><span class="pal-stat-lbl"><?= L('Ligue 2 titles <small>(national record)</small>', 'ألقاب الرابطة الثانية <small>(رقم قياسي وطني)</small>') ?></span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num">06</span><span class="pal-stat-lbl"><?= L('Cup semi-finals', 'أنصاف نهائي الكأس') ?></span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num"><?= L('1<sup>st</sup>', '1') ?></span><span class="pal-stat-lbl"><?= L('African semi-final', 'نصف نهائي إفريقي') ?></span></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🏆</span><h3 class="pal-card-title"><?= L('Ligue 1 Mobilis', 'الرابطة الأولى موبيليس') ?></h3><p class="pal-card-sub"><?= L('Algerian Championship', 'البطولة الجزائرية') ?></p></div><div class="pal-card-body"><div class="pal-trophy champion"><span class="pal-trophy-label">🥇 <?= L('Champions (02)', 'بطل (02)') ?></span><ul class="pal-years"><li>1996 – 1997</li><li>2017 – 2018</li></ul></div><div class="pal-trophy vice"><span class="pal-trophy-label">🥈 <?= L('Runners-up', 'وصيف') ?></span><ul class="pal-years"><li>1970 – 1971</li><li>2023 – 2024</li></ul></div></div></div></div>
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🏆</span><h3 class="pal-card-title"><?= L('Ligue 2', 'الرابطة الثانية') ?></h3><p class="pal-card-sub"><?= L('D2 — National record (06 titles)', 'القسم الثاني — رقم قياسي وطني (06 ألقاب)') ?></p></div><div class="pal-card-body"><div class="pal-trophy champion"><span class="pal-trophy-label">🥇 <?= L('Champions (06)', 'بطل (06)') ?></span><ul class="pal-years"><li>1969 – 1970</li><li>1976 – 1977</li><li>1985 – 1986</li><li>1993 – 1994</li><li>2003 – 2004</li><li>2010 – 2011</li></ul></div></div></div></div>
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🎖️</span><h3 class="pal-card-title"><?= L('Algerian Cup', 'كأس الجزائر') ?></h3><p class="pal-card-sub"><?= L('The Lady Cup', 'السيدة الكأس') ?></p></div><div class="pal-card-body"><div class="pal-trophy semi"><span class="pal-trophy-label"><?= L('Semi-finalists (06)', 'نصف نهائي (06)') ?></span><ul class="pal-years"><li>1986 – 1987</li><li>1991 – 1992</li><li>2011 – 2012</li><li>2018 – 2019</li><li>2024 – 2025</li><li>2025 – 2026</li></ul></div></div></div></div>
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🌍</span><h3 class="pal-card-title"><?= L('African competitions', 'المنافسات الإفريقية') ?></h3><p class="pal-card-sub"><?= L('Continental stage', 'على الساحة القارية') ?></p></div><div class="pal-card-body"><div class="pal-trophy semi"><span class="pal-trophy-label"><?= L('CAF Champions League', 'رابطة أبطال إفريقيا') ?></span><ul class="pal-years"><li><?= L('Quarter-finalists 2018-2019', 'ربع نهائي 2018-2019') ?></li></ul></div><div class="pal-trophy africa-highlight"><span class="pal-trophy-label"><?= L('CAF Confederation Cup', 'كأس الكونفدرالية الإفريقية') ?></span><ul class="pal-years"><li><strong>🏅 <?= L('Semi-finalists 2024-2025', 'نصف نهائي 2024-2025') ?></strong></li><li style="font-size:11px;color:#0a4f0a;font-style:italic;"><?= L('A first in club history!', 'لأول مرة في التاريخ!') ?></li></ul></div></div></div></div>
                </div>
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <div class="pal-doyen-banner">
                            <div class="pal-doyen-left"><img src="images/logo-dark.png?v=3" alt="CSC" style="height:50px;object-fit:contain;"></div>
                            <div class="pal-doyen-center">
                                <span class="pal-doyen-badge">⚽ <?= L('The oldest Algerian club', 'عميد الأندية الجزائرية') ?></span>
                                <p><?= L('Founded in <strong>1898</strong>, CS Constantine has witnessed the whole history of football in Algeria, backed by its loyal <strong>Sanafirs</strong>.', 'تأسس سنة <strong>1898</strong>، النادي الرياضي القسنطيني شاهد تاريخي على تطور كرة القدم في الجزائر، بدعم أنصاره الأوفياء <strong>السنافير</strong>.') ?></p>
                            </div>
                            <div class="pal-doyen-right"><a href="histoire.php" class="pal-history-btn"><?= L('Our history &rarr;', 'تاريخنا &larr;') ?></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTACT -->
        <section class="wf100 p80" id="contact-section" style="background:#f4f9f4;">
            <div class="container">
                <div class="row"><div class="col-md-12 text-center" style="margin-bottom:40px;"><div class="section-title"><h2><?= L('Contact', 'اتصل بنا') ?></h2></div><p style="color:#555;font-size:15px;margin-top:-10px;"><?= L('A question? Contact Club Sportif Constantinois.', 'لديك سؤال؟ تواصل مع النادي الرياضي القسنطيني.') ?></p></div></div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6" style="margin-bottom:20px;">
                        <div style="background:#fff;border-radius:14px;padding:28px 24px;display:flex;align-items:flex-start;gap:18px;box-shadow:0 2px 12px rgba(0,0,0,0.07);height:100%;">
                            <div style="background:#0a4f0a;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-map-marker-alt" style="color:#fff;font-size:20px;"></i></div>
                            <div><h5 style="font-weight:800;margin:0 0 8px;color:#111;"><?= L('Address', 'العنوان') ?></h5><p style="color:#555;font-size:14px;margin:0;line-height:1.6;"><?= L('OPOW Chahid Hamlaoui Annex<br>Constantine, Algeria, 25000', 'ملحق ديوان المركب الأولمبي الشهيد حملاوي<br>قسنطينة، الجزائر، 25000') ?></p></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" style="margin-bottom:20px;">
                        <div style="background:#fff;border-radius:14px;padding:28px 24px;display:flex;align-items:flex-start;gap:18px;box-shadow:0 2px 12px rgba(0,0,0,0.07);height:100%;">
                            <div style="background:#0a4f0a;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-phone" style="color:#fff;font-size:20px;"></i></div>
                            <div><h5 style="font-weight:800;margin:0 0 8px;color:#111;"><?= L('Phone', 'الهاتف') ?></h5><p style="color:#555;font-size:14px;margin:0;"><a href="tel:+21303164882" style="color:#555;text-decoration:none;">+213 031 64 88 21</a></p></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" style="margin-bottom:20px;">
                        <div style="background:#fff;border-radius:14px;padding:28px 24px;display:flex;align-items:flex-start;gap:18px;box-shadow:0 2px 12px rgba(0,0,0,0.07);height:100%;">
                            <div style="background:#0a4f0a;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-envelope" style="color:#fff;font-size:20px;"></i></div>
                            <div><h5 style="font-weight:800;margin:0 0 8px;color:#111;"><?= L('Email', 'البريد الإلكتروني') ?></h5><p style="color:#555;font-size:14px;margin:0;"><a href="mailto:contact@csconstantine.dz" style="color:#0a4f0a;text-decoration:none;font-weight:600;">contact@csconstantine.dz</a></p></div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <div style="border-radius:14px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.1);">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d831.2!2d6.615556!3d36.364722!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12f315b87ac7283d%3A0x8c0679ab56d3c46c!2sStade%20Chahid%20Hamlaoui!5e0!3m2!1sfr!2sdz!4v1" width="100%" height="320" style="border:0;display:block;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div><!-- end main-content -->

    <?php require 'footer.php';?>
</div><!-- end wrapper -->

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery-migrate-3.0.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/mobile-nav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/isotope.js"></script>
<script src="js/jquery.prettyPhoto.js"></script>
<script src="js/jquery.countdown.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/rev-slider/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="js/rev-slider/js/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="js/rev-slider.js"></script>
<script type="text/javascript" src="js/rev-slider/js/extensions/revolution.extension.actions.min.js"></script>
<script type="text/javascript" src="js/rev-slider/js/extensions/revolution.extension.carousel.min.js"></script>
<script type="text/javascript" src="js/rev-slider/js/extensions/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript" src="js/rev-slider/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script type="text/javascript" src="js/rev-slider/js/extensions/revolution.extension.migration.min.js"></script>
<script type="text/javascript" src="js/rev-slider/js/extensions/revolution.extension.navigation.min.js"></script>
<script type="text/javascript" src="js/rev-slider/js/extensions/revolution.extension.parallax.min.js"></script>
<script type="text/javascript" src="js/rev-slider/js/extensions/revolution.extension.slideanims.min.js"></script>
<script type="text/javascript" src="js/rev-slider/js/extensions/revolution.extension.video.min.js"></script>

<script>
/* NEWS SCROLL */
(function(){
    var track   = document.querySelector('.csc-scroll-track');
    var btnPrev = document.querySelector('.csc-scroll-prev');
    var btnNext = document.querySelector('.csc-scroll-next');
    if (!track) return;
    var cardW = function(){ return track.querySelector('.csc-scroll-card').offsetWidth + 20; };
    btnNext.addEventListener('click', function(){ track.scrollBy({ left: cardW(), behavior: 'smooth' }); });
    btnPrev.addEventListener('click', function(){ track.scrollBy({ left: -cardW(), behavior: 'smooth' }); });
    document.querySelectorAll('.csc-scroll-card.news-card-link').forEach(function(card){
        card.addEventListener('click', function(e){
            if (e.target.closest('.card-ticket-btn')) return;
            var url = card.getAttribute('data-url');
            if (url) window.location.href = url;
        });
    });
})();

/* SHARE MODAL */
(function(){
    var modal    = document.getElementById('shareModal');
    var closeBtn = document.getElementById('shareClose');
    var copyBtn  = document.getElementById('copyBtn');
    var whatsBtn = document.getElementById('whatsBtn');
    var feedback = document.getElementById('shareFeedback');
    var titleEl  = document.getElementById('shareTitle');
    var currentUrl = '';
    if (!modal) return;
    closeBtn.addEventListener('click', function(){ modal.classList.remove('active'); });
    modal.addEventListener('click', function(e){ if(e.target === modal) modal.classList.remove('active'); });
    copyBtn.addEventListener('click', function(){
        navigator.clipboard.writeText(currentUrl).then(function(){
            copyBtn.textContent = <?= LJ('Link copied!', 'تم نسخ الرابط!') ?>;
            copyBtn.classList.add('copied');
            feedback.textContent = <?= LJ('The link has been copied to the clipboard.', 'تم نسخ الرابط إلى الحافظة.') ?>;
        }).catch(function(){ feedback.textContent = currentUrl; });
    });
    whatsBtn.addEventListener('click', function(){
        window.open('https://wa.me/?text=' + encodeURIComponent(titleEl.textContent + '\n' + currentUrl), '_blank');
    });
})();
</script>
</body>
</html>