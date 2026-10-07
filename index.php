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
<title><?= L('Site officiel du CSC - Club Sportif Constantinois', 'الموقع الرسمي للنادي الرياضي القسنطيني') ?></title>
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

    <!-- BANNIÈRE -->
    <section class="csc-banner">
        <img src="images/banner-csc.jpg" alt="<?= L('CS Constantine 1898', 'النادي الرياضي القسنطيني 1898') ?>">
    </section>
    <style>
        .csc-banner{width:100%;background:#03140c;line-height:0;overflow:hidden;}
        .csc-banner img{display:block;width:100%;height:auto;max-height:620px;object-fit:cover;object-position:center;}
    </style>

    <div class="main-content wf100"> 
        <!-- SPONSORS ANIMÉS -->
        <div class="sponsor-strip" id="sponsors-section">
            <div class="sponsor-track-outer">
                <div class="sponsor-track"><div class="sponsor-item"><img src="images/sponsors/entp.jpeg" alt="ENTP"></div><div class="sponsor-item"><img src="images/sponsors/hayat.jpeg" alt="Hayat"></div><div class="sponsor-item"><img src="images/sponsors/macron.jpeg" alt="Macron"></div><div class="sponsor-item"><img src="images/sponsors/ooredoo.jpeg" alt="Ooredoo"></div><div class="sponsor-item"><img src="images/sponsors/soumam.jpeg" alt="Soummam"></div></div>
                <div class="sponsor-track" aria-hidden="true"><div class="sponsor-item"><img src="images/sponsors/entp.jpeg" alt="ENTP"></div><div class="sponsor-item"><img src="images/sponsors/hayat.jpeg" alt="Hayat"></div><div class="sponsor-item"><img src="images/sponsors/macron.jpeg" alt="Macron"></div><div class="sponsor-item"><img src="images/sponsors/ooredoo.jpeg" alt="Ooredoo"></div><div class="sponsor-item"><img src="images/sponsors/soumam.jpeg" alt="Soummam"></div></div>
            </div>
        </div>

        <!-- APPEL À L'INSCRIPTION -->
        <section class="csc-cta-inscription">
            <div class="container">
                <div class="csc-cta-box">
                    <div>
                        <h3><?= L('Envie de rejoindre le CSC ?', 'هل ترغب في الانضمام إلى النادي؟') ?></h3>
                        <p><?= L('Administration, marketing, logistique, communication : proposez vos compétences au club.', 'الإدارة، التسويق، اللوجستيك، الاتصال: اقترح كفاءاتك على النادي.') ?></p>
                    </div>
                    <a href="inscription.php" class="csc-cta-btn"><i class="fas fa-user-plus"></i> <?= L('S\'inscrire maintenant', 'سجّل الآن') ?></a>
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
                    $lettres = ['v' => [L('V', 'ف'), L('Victoire', 'فوز')], 'n' => [L('N', 'ت'), L('Nul', 'تعادل')], 'd' => [L('D', 'خ'), L('Défaite', 'خسارة')]];
                    ?>
                    <!-- COL 1 : Prochain Match + Forme Récente -->
                    <div class="col-lg-4 col-md-6">
                        <?php if ($next): $d = club_info($next['dom']); $e = club_info($next['ext']); ?>
                        <div class="next-match-widget">
                            <h5 class="title"><?= L('Prochain match', 'المباراة القادمة') ?></h5>
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
                                    <li><strong><?= L('Ligue 1', 'الرابطة الأولى') ?> — <?= L('Journée', 'الجولة') ?> <?= (int)$next['j'] ?></strong></li>
                                    <p><?= match_date($next) ?></p>
                                    <li><?= match_heure($next) ?></li>
                                    <li><span><?= match_stade($next) ?></span></li>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- FORME RECENTE -->
                        <div class="forme-widget">
                            <div class="forme-title">⚽ <?= L('Forme récente — CSC', 'آخر النتائج') ?></div>
                            <?php if ($dernier): ?>
                            <div class="dernier-resultat">
                                <span class="dr-lbl"><?= L('Dernier match', 'آخر مباراة') ?> (<?= L('J', 'ج') ?><?= (int)$dernier['j'] ?>)</span>
                                <span class="dr-score"><?= club_court($dernier['dom']) ?> <b><?= (int)$dernier['bd'] ?> - <?= (int)$dernier['be'] ?></b> <?= club_court($dernier['ext']) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="forme-badges">
                                <?php foreach ($forme as $m): $r = match_resultat($m); ?>
                                <div class="forme-badge <?= $r ?>" title="<?= $lettres[$r][1] ?> : <?= club_court($m['dom']) ?> <?= (int)$m['bd'] ?>-<?= (int)$m['be'] ?> <?= club_court($m['ext']) ?>"><?= $lettres[$r][0] ?></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="forme-stats">
                                <div class="forme-stat-item"><span class="forme-stat-num"><?= $bilan['v'] ?></span><span class="forme-stat-lbl"><?= L('Victoires', 'انتصارات') ?></span></div>
                                <div class="forme-stat-item"><span class="forme-stat-num"><?= $bilan['n'] ?></span><span class="forme-stat-lbl"><?= L('Nuls', 'تعادلات') ?></span></div>
                                <div class="forme-stat-item"><span class="forme-stat-num"><?= $bilan['d'] ?></span><span class="forme-stat-lbl"><?= L('Défaites', 'هزائم') ?></span></div>
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
                                <li class="mvs"><p><strong><?= L('Ligue 1', 'الرابطة الأولى') ?> — <?= L('J', 'ج') ?><?= (int)$m['j'] ?></strong> <?= match_date($m) ?><br><?= match_heure($m) ?></p><strong class="vs"><?= L('VS', 'ضد') ?></strong></li>
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
                                    <tr><th></th><th><?= L('Équipe', 'الفريق') ?></th><th><?= L('G', 'ف') ?></th><th><?= L('N', 'ت') ?></th><th><?= L('P', 'خ') ?></th><th><?= L('Pts', 'ن') ?></th></tr>
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
                <div class="row"><div class="col-md-12"><div class="section-title"><h2><?= L('Actualités du CSC', 'أخبار النادي') ?></h2></div></div></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="csc-scroll-wrapper">
                            <div class="csc-scroll-track">
<?php foreach ((require __DIR__ . '/Data/actualites.php') as $n): ?>
                                <div class="csc-scroll-card news-card-link" data-url="actualite.php?id=<?= (int)$n['id'] ?>">
                                    <img src="<?= htmlspecialchars(news_img($n['image'])) ?>" alt="">
                                    <div class="overlay"></div>
                                    <span class="card-label"><?= htmlspecialchars(nt($n, 'label')) ?></span>
                                    <div class="card-bottom">
                                        <p class="card-title"><?= htmlspecialchars(nt($n, 'titre')) ?></p>
                                        <p class="card-desc<?= $LANG === 'ar' ? ' ar' : '' ?>"><?= htmlspecialchars(nt($n, 'resume')) ?></p>
                                        <div class="card-hashtags"><?php foreach ($n['tags'] as $t): ?><span><?= htmlspecialchars($t) ?></span><?php endforeach; ?></div>
                                        <?php if (!empty($n['bouton'])): ?><a href="<?= htmlspecialchars($n['bouton']['lien']) ?>" target="_blank" class="card-ticket-btn" onclick="event.stopPropagation();"><?= htmlspecialchars(nt($n['bouton'], $LANG)) ?></a><?php endif; ?>
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

        <!-- SHARE MODAL -->
        <div class="share-modal-overlay" id="shareModal">
            <div class="share-modal">
                <button class="share-modal-close" id="shareClose">&times;</button>
                <h4 id="shareTitle"></h4>
                <p><?= L('Partager cet article', 'شارك هذا الخبر') ?></p>
                <div class="share-btns">
                    <button class="share-btn copy" id="copyBtn">&nbsp; <?= L('Copier le lien', 'نسخ الرابط') ?></button>
                    <button class="share-btn whats" id="whatsBtn">&nbsp; <?= L('Partager sur WhatsApp', 'مشاركة عبر واتساب') ?></button>
                </div>
                <div class="share-feedback" id="shareFeedback"></div>
            </div>
        </div>

        <!-- JOUEURS -->
        <section class="team-squad wf100 p80-50">
            <div class="container">
                <div class="row">
                    <div class="col-md-12"><div class="section-title white"><h2><?= L('Joueurs', 'اللاعبون') ?></h2><a class="full-team" href="joueurs.php"><?= L('Voir toute l\'équipe', 'كل الفريق') ?></a></div></div>
                </div>
                <div class="row">
                    <?php foreach (getHomePlayers() as $pl): ?>
                    <div class="col-md-6"><div class="player-box with-extra-info"><div class="player-thumb"><img src="<?= htmlspecialchars(!empty($pl['img']) ? $pl['img'] : 'images/player-default.png') ?>" alt="<?= htmlspecialchars(player_name($pl)) ?>" width="240"></div><div class="player-txt"><h3><?= htmlspecialchars(player_name($pl)) ?></h3><br><ul class="pb-small-info"><li><?= L('N°', 'الرقم') ?> <strong><?= (int)$pl['dossard'] ?></strong></li><li><?= L('Poste', 'المنصب') ?> <strong><?= htmlspecialchars(Lv($pl['poste'])) ?></strong></li><li><?= L('Âge', 'العمر') ?> <strong><?= playerAge($pl) ?> <?= L('ans', 'سنة') ?></strong></li></ul></div></div></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="wf100 p80 players-squad portfolio filter-gallery">
            <div class="container"><div class="row"><div class="col-md-12"><div class="static-pagetitle"><h2><?= L('Site officiel du CSC - Club Sportif Constantinois', 'الموقع الرسمي للنادي الرياضي القسنطيني') ?></h2></div></div></div></div>
        </section>

        <!-- PALMARES -->
        <section class="wf100 p80" id="palmares" style="background:#f7fdf7;">
            <div class="container">
                <div class="row"><div class="col-md-12"><div class="section-title"><h2><?= L('Palmarès', 'الألقاب') ?></h2></div><p style="text-align:center;color:#555;font-size:15px;margin-top:-10px;margin-bottom:40px;"><?= L('Retracez l\'histoire riche en succès de l\'un des piliers du football algérien.', 'تاريخ حافل بالإنجازات لأحد أعمدة كرة القدم الجزائرية.') ?></p></div></div>
                <div class="row" style="margin-bottom:40px;">
                    <div class="col-md-12">
                        <div class="pal-stat-strip">
                            <div class="pal-stat-item"><span class="pal-stat-num">1898</span><span class="pal-stat-lbl"><?= L('Année de fondation', 'سنة التأسيس') ?></span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num">02</span><span class="pal-stat-lbl"><?= L('Titres de champion', 'ألقاب البطولة') ?></span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num">06</span><span class="pal-stat-lbl"><?= L('Titres Ligue 2 <small>(Record national)</small>', 'ألقاب الرابطة الثانية <small>(رقم قياسي وطني)</small>') ?></span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num">06</span><span class="pal-stat-lbl"><?= L('Demi-finales de Coupe', 'أنصاف نهائي الكأس') ?></span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num"><?= L('1<sup>er</sup>', '1') ?></span><span class="pal-stat-lbl"><?= L('Demi-finale africaine', 'نصف نهائي إفريقي') ?></span></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🏆</span><h3 class="pal-card-title"><?= L('Ligue 1 Mobilis', 'الرابطة الأولى موبيليس') ?></h3><p class="pal-card-sub"><?= L('Championnat d\'Algérie', 'البطولة الجزائرية') ?></p></div><div class="pal-card-body"><div class="pal-trophy champion"><span class="pal-trophy-label">🥇 <?= L('Champion (02)', 'بطل (02)') ?></span><ul class="pal-years"><li>1996 – 1997</li><li>2017 – 2018</li></ul></div><div class="pal-trophy vice"><span class="pal-trophy-label">🥈 <?= L('Vice-champion', 'وصيف') ?></span><ul class="pal-years"><li>1970 – 1971</li><li>2023 – 2024</li></ul></div></div></div></div>
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🏆</span><h3 class="pal-card-title"><?= L('Ligue 2', 'الرابطة الثانية') ?></h3><p class="pal-card-sub"><?= L('D2 — Record national (06 titres)', 'القسم الثاني — رقم قياسي وطني (06 ألقاب)') ?></p></div><div class="pal-card-body"><div class="pal-trophy champion"><span class="pal-trophy-label">🥇 <?= L('Champion (06)', 'بطل (06)') ?></span><ul class="pal-years"><li>1969 – 1970</li><li>1976 – 1977</li><li>1985 – 1986</li><li>1993 – 1994</li><li>2003 – 2004</li><li>2010 – 2011</li></ul></div></div></div></div>
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🎖️</span><h3 class="pal-card-title"><?= L('Coupe d\'Algérie', 'كأس الجزائر') ?></h3><p class="pal-card-sub"><?= L('La Dame Coupe', 'السيدة الكأس') ?></p></div><div class="pal-card-body"><div class="pal-trophy semi"><span class="pal-trophy-label"><?= L('Demi-finaliste (06)', 'نصف نهائي (06)') ?></span><ul class="pal-years"><li>1986 – 1987</li><li>1991 – 1992</li><li>2011 – 2012</li><li>2018 – 2019</li><li>2024 – 2025</li><li>2025 – 2026</li></ul></div></div></div></div>
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🌍</span><h3 class="pal-card-title"><?= L('Compétitions africaines', 'المنافسات الإفريقية') ?></h3><p class="pal-card-sub"><?= L('Scène continentale', 'على الساحة القارية') ?></p></div><div class="pal-card-body"><div class="pal-trophy semi"><span class="pal-trophy-label"><?= L('CAF Champions League', 'رابطة أبطال إفريقيا') ?></span><ul class="pal-years"><li><?= L('Quart-finaliste 2018-2019', 'ربع نهائي 2018-2019') ?></li></ul></div><div class="pal-trophy africa-highlight"><span class="pal-trophy-label"><?= L('Coupe de la CAF', 'كأس الكونفدرالية الإفريقية') ?></span><ul class="pal-years"><li><strong>🏅 <?= L('Demi-finaliste 2024-2025', 'نصف نهائي 2024-2025') ?></strong></li><li style="font-size:11px;color:#0a4f0a;font-style:italic;"><?= L('1ère fois de l\'histoire !', 'لأول مرة في التاريخ!') ?></li></ul></div></div></div></div>
                </div>
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <div class="pal-doyen-banner">
                            <div class="pal-doyen-left"><img src="images/logo-dark.png" alt="CSC" style="height:50px;object-fit:contain;"></div>
                            <div class="pal-doyen-center">
                                <span class="pal-doyen-badge">⚽ <?= L('Le doyen des clubs algériens', 'عميد الأندية الجزائرية') ?></span>
                                <p><?= L('Fondé en <strong>1898</strong>, le CS Constantine est le témoin historique de l\'évolution du football en Algérie, soutenu par ses fidèles <strong>Sanafirs</strong>.', 'تأسس سنة <strong>1898</strong>، النادي الرياضي القسنطيني شاهد تاريخي على تطور كرة القدم في الجزائر، بدعم أنصاره الأوفياء <strong>السنافير</strong>.') ?></p>
                            </div>
                            <div class="pal-doyen-right"><a href="histoire.php" class="pal-history-btn"><?= L('Notre histoire &rarr;', 'تاريخنا &larr;') ?></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTACT -->
        <section class="wf100 p80" id="contact-section" style="background:#f4f9f4;">
            <div class="container">
                <div class="row"><div class="col-md-12 text-center" style="margin-bottom:40px;"><div class="section-title"><h2><?= L('Contact', 'اتصل بنا') ?></h2></div><p style="color:#555;font-size:15px;margin-top:-10px;"><?= L('Une question ? Contactez le Club Sportif Constantinois.', 'لديك سؤال؟ تواصل مع النادي الرياضي القسنطيني.') ?></p></div></div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6" style="margin-bottom:20px;">
                        <div style="background:#fff;border-radius:14px;padding:28px 24px;display:flex;align-items:flex-start;gap:18px;box-shadow:0 2px 12px rgba(0,0,0,0.07);height:100%;">
                            <div style="background:#0a4f0a;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-map-marker-alt" style="color:#fff;font-size:20px;"></i></div>
                            <div><h5 style="font-weight:800;margin:0 0 8px;color:#111;"><?= L('Adresse', 'العنوان') ?></h5><p style="color:#555;font-size:14px;margin:0;line-height:1.6;"><?= L('Annexe OPOW Chahid Hamlaoui<br>Constantine, Algérie, 25000', 'ملحق ديوان المركب الأولمبي الشهيد حملاوي<br>قسنطينة، الجزائر، 25000') ?></p></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" style="margin-bottom:20px;">
                        <div style="background:#fff;border-radius:14px;padding:28px 24px;display:flex;align-items:flex-start;gap:18px;box-shadow:0 2px 12px rgba(0,0,0,0.07);height:100%;">
                            <div style="background:#0a4f0a;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-phone" style="color:#fff;font-size:20px;"></i></div>
                            <div><h5 style="font-weight:800;margin:0 0 8px;color:#111;"><?= L('Téléphone', 'الهاتف') ?></h5><p style="color:#555;font-size:14px;margin:0;"><a href="tel:+21303164882" style="color:#555;text-decoration:none;">+213 031 64 88 21</a></p></div>
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
            copyBtn.textContent = <?= LJ('Lien copié !', 'تم نسخ الرابط!') ?>;
            copyBtn.classList.add('copied');
            feedback.textContent = <?= LJ('Le lien a été copié dans le presse-papiers.', 'تم نسخ الرابط إلى الحافظة.') ?>;
        }).catch(function(){ feedback.textContent = currentUrl; });
    });
    whatsBtn.addEventListener('click', function(){
        window.open('https://wa.me/?text=' + encodeURIComponent(titleEl.textContent + '\n' + currentUrl), '_blank');
    });
})();
</script>
</body>
</html>