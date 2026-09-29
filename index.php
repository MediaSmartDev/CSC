<!doctype html>
<?php
include 'Data/Dbo.php';
$today = new DateTime();
?>
<html lang="fr">
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
<title>Site officiel du CSC - Club Sportif Constantinois</title>
<style type="text/css">
    .static-pagetitle { background:linear-gradient(145deg,#0f830a 0,#020e01); -webkit-background-clip:text; -webkit-text-fill-color:transparent; color:#fff; text-align:center; margin:30px !important; font-weight:bold !important; }
    .ar { direction:rtl; text-align:right; font-family:"HelveticaNeue",Helvetica,Arial,sans-serif; font-size:14px; }
    .slider-tabs.wf100 { margin-top:20px !important; position:relative; z-index:1; }
    .point-table-widget { overflow-x:auto !important; }
    .point-table-widget table { min-width:300px !important; width:100% !important; }
    .point-table-widget table td, .point-table-widget table th { display:table-cell !important; visibility:visible !important; opacity:1 !important; white-space:nowrap !important; padding:6px 8px !important; font-size:12px !important; }

    /* SPONSORS STRIP */
    .sponsor-strip { width:100%; background:#fff; overflow:hidden; position:relative; z-index:99; padding:25px 0; border-top:1px solid #eee; border-bottom:1px solid #eee; }
    .sponsor-strip::before,.sponsor-strip::after { content:""; height:100%; position:absolute; width:15%; z-index:2; pointer-events:none; }
    .sponsor-strip::before { left:0; top:0; background:linear-gradient(to right,#fff 0%,transparent 100%); }
    .sponsor-strip::after  { right:0; top:0; background:linear-gradient(to left,#fff 0%,transparent 100%); }
    .sponsor-track-outer { display:flex; overflow:hidden; user-select:none; }
    .sponsor-track { display:flex; align-items:center; flex-shrink:0; animation:scrollSponsors 35s linear infinite; }
    .sponsor-track:hover { animation-play-state:paused; }
    .sponsor-item { margin:0 50px; transition:transform 0.3s ease; }
    .sponsor-item img { max-height:55px; max-width:160px; object-fit:contain; display:block; }
    .sponsor-item:hover { transform:scale(1.1); }
    @keyframes scrollSponsors { from{transform:translateX(0)} to{transform:translateX(-50%)} }
    @media(max-width:768px){ .sponsor-strip{padding:15px 0} .sponsor-item{margin:0 25px} .sponsor-item img{max-height:35px;max-width:100px} .sponsor-track{animation-duration:20s} }

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
</style>
</head>
<body>
<div class="wrapper"> 
    <?php require 'header.php';?>

    <!-- SLIDER -->
    <div class="main-slider">
        <div class="home2-slider rev_slider_wrapper"> 
            <div class="rev_slider_wrapper fullwidthbanner-container">
                <div id="rev-slider2" class="rev_slider fullwidthabanner">
                    <ul>
                        <li data-transition="fade"> 
                            <img src="images/couverture.png" alt="" width="1920" height="750" data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1">
                            <div class="tp-caption tp-resizeme" data-x="right" data-hoffset="850" data-y="bottom" data-voffset="50" data-transform_idle="o:1;" data-transform_in="x:[-75%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;" data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" data-mask_in="x:[100%];y:0;s:inherit;e:inherit;" data-splitin="none" data-splitout="none" data-start="700">
                                <div class="slide-content-box"><img src="images/slide1-football.png" alt=""></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content wf100"> 
        <!-- SLIDER TABS -->
        <div class="slider-tabs wf100">
            <div class="container">
                <div class="row">
                    <ul>
                        <li class="col-lg-4"><div class="slidetab-box"><span>#</span><h6><a href="#">Lancement du site web officiel du club</a></h6><strong>CSC - Club Sportif Constantinois</strong></div></li>
                        <li class="col-lg-4"><div class="slidetab-box"><span>#</span><h6><a href="joueurs.php">Effectif du CS Constantine de la saison 2025-2026</a></h6><strong>Ligue 1</strong></div></li>
                        <li class="col-lg-4"><div class="slidetab-box"><span>#</span><h6><a href="resultats.php">Résultat du dernier match</a></h6><strong>LIGUE 1</strong></div></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- PROCHAIN MATCH + CLASSEMENT -->
        <section class="wf100 p80" id="calendrier" style="padding-top:30px !important;">
            <div class="container">
                <div class="row">
                    <!-- COL 1 : Prochain Match + Forme Récente -->
                    <div class="col-lg-4 col-md-6">
                        <div class="next-match-widget">
                            <h5 class="title">Prochain Match</h5>
                            <div class="nmw-wrap">
                                <ul class="match-teams-vs">
                                    <li class="team-logo">
                                        <img src="ressources/logo/logo_jss_t2.png" alt="JSS" style="width:60px;height:60px;object-fit:contain;">
                                        <strong>JSS</strong>
                                    </li>
                                    <li class="mvs"><strong class="vs">VS</strong></li>
                                    <li class="team-logo">
                                        <img src="images/logo-dark.png" alt="CSC" style="width:60px;height:60px;object-fit:contain;">
                                        <strong>CSC</strong>
                                    </li>
                                </ul>
                                <ul class="nmw-txt">
                                    <li><strong>Ligue 1</strong></li>
                                    <p>23 Mai 2026</p>
                                    <li>--:--</li>
                                    <li><span>Stade 20 Aout 1955, Béchar</span></li>
                                </ul>
                            </div>
                        </div>
                        <!-- FORME RECENTE -->
                        <div class="forme-widget">
                            <div class="forme-title">⚽ Forme Récente — CSC</div>
                            <div class="forme-badges">
                                <div class="forme-badge v" title="Victoire">V</div>
                                <div class="forme-badge n" title="Nul">N</div>
                                <div class="forme-badge v" title="Victoire">V</div>
                                <div class="forme-badge d" title="Défaite">D</div>
                                <div class="forme-badge v" title="Victoire">V</div>
                            </div>
                            <div class="forme-stats">
                                <div class="forme-stat-item"><span class="forme-stat-num">11</span><span class="forme-stat-lbl">Victoires</span></div>
                                <div class="forme-stat-item"><span class="forme-stat-num">10</span><span class="forme-stat-lbl">Nuls</span></div>
                                <div class="forme-stat-item"><span class="forme-stat-num">8</span><span class="forme-stat-lbl">Défaites</span></div>
                                <div class="forme-stat-item"><span class="forme-stat-num">43</span><span class="forme-stat-lbl">Points</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- COL 2 : Fixtures -->
                    <div class="col-lg-4 col-md-6">
                        <div class="next-match-fixtures">
                            <ul class="match-teams-vs">
                                <li class="team-logo"><img src="images/logo-dark.png" alt="CSC" style="width:50px;height:50px;object-fit:contain;"><strong>CSC</strong></li>
                                <li class="mvs"><p><strong>Ligue 1</strong> 10 Avr 2026<br>17:45</p><strong class="vs">VS</strong></li>
                                <li class="team-logo"><img src="ressources/logo/logo_jsk_t2.png" alt="JSK" style="width:50px;height:50px;object-fit:contain;"><strong>JSK</strong></li>
                            </ul>
                            <ul class="nmf-loc"><li><i class="fas fa-location-arrow"></i> Stade Chahid Hamlaoui, Constantine</li></ul>
                        </div>
                        <div class="next-match-fixtures">
                            <ul class="match-teams-vs">
                                <li class="team-logo"><img src="images/logo-dark.png" alt="CSC" style="width:50px;height:50px;object-fit:contain;"><strong>CSC</strong></li>
                                <li class="mvs"><p><strong>Ligue 1</strong> 17 Avr 2026<br>--:--</p><strong class="vs">VS</strong></li>
                                <li class="team-logo"><img src="ressources/logo/logo_mca_t2.png" alt="MCA" style="width:50px;height:50px;object-fit:contain;"><strong>MCA</strong></li>
                            </ul>
                            <ul class="nmf-loc"><li><i class="fas fa-location-arrow"></i> Stade Chahid Hamlaoui, Constantine</li></ul>
                        </div>
                        <div class="next-match-fixtures">
                            <ul class="match-teams-vs">
                                <li class="team-logo"><img src="images/logo-dark.png" alt="CSC" style="width:50px;height:50px;object-fit:contain;"><strong>CSC</strong></li>
                                <li class="mvs"><p><strong>Coupe — Demi</strong> 24 Avr 2026<br>--:--</p><strong class="vs">VS</strong></li>
                                <li class="team-logo"><img src="ressources/logo/logo_crb_t2.png" alt="CRB" style="width:50px;height:50px;object-fit:contain;"><strong>CRB</strong></li>
                            </ul>
                            <ul class="nmf-loc"><li><i class="fas fa-location-arrow"></i> Stade Chahid Hamlaoui, Constantine</li></ul>
                        </div>
                    </div>

                    <!-- COL 3 : Classement -->
                    <div class="col-lg-4">
                        <div class="point-table-widget">
                            <table>
                                <thead>
                                    <tr><th></th><th>Equipe</th><th>G</th><th>N</th><th>P</th><th>Pts</th></tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $classement = getClassmentTable();
                                    foreach ($classement as $row) {
                                        $csc = (strtolower($row["club"]) === 'csc' || strpos(strtolower($row["club"]), 'constantine') !== false)
                                            ? 'style="background:rgba(10,79,10,0.08);font-weight:bold;"' : '';
                                        echo '<tr '.$csc.'>
                                            <td><strong>'.$row["pos"].'</strong></td>
                                            <td><img src="'.$row["logo"].'" alt="'.$row["club"].'" style="height:22px;margin-right:5px;"><strong>'.$row["club"].'</strong></td>
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
        <section class="wf100 p80 sports-news">
            <div class="container">
                <div class="row"><div class="col-md-12"><div class="section-title"><h2>Actualités du CSC</h2></div></div></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="csc-scroll-wrapper">
                            <div class="csc-scroll-track">

                                <div class="csc-scroll-card news-card-link" data-url="actualite.php?id=7">
                                    <img src="images/Actualite/news3.jpeg" alt="">
                                    <div class="overlay"></div>
                                    <span class="card-label">🎉 تهنئة</span>
                                    <div class="card-bottom">
                                        <p class="card-title">تهنئة الأندية الصاعدة 🎉</p>
                                        <p class="card-desc ar">تتقدم إدارة النادي الرياضي القسنطيني بأسمى التهاني إلى أندية شبيبة الأبيار، شباب تموشنت وإتحاد بسكرة.</p>
                                        <div class="card-hashtags"><span>#TheDean1898</span><span>#DimaCsc</span></div>
                                    </div>
                                </div>

                                <div class="csc-scroll-card news-card-link" data-url="actualite.php?id=6">
                                    <img src="images/Actualite/statement.jpeg" alt="">
                                    <div class="overlay"></div>
                                    <span class="card-label">📋 بيان رسمي</span>
                                    <div class="card-bottom">
                                        <p class="card-title">بيان — STATEMENT</p>
                                        <p class="card-desc ar">تُعلم إدارة النادي الرياضي القسنطيني أن كل ما يتم تداوله بخصوص ملف الانتدابات الصيفية يبقى مجرد إشاعات.</p>
                                        <div class="card-hashtags"><span>#TheDean1898</span><span>#DimaCsc</span></div>
                                    </div>
                                </div>

                                <div class="csc-scroll-card news-card-link" data-url="actualite.php?id=5">
                                    <img src="images/Actualite/ticket-news.jpeg" alt="">
                                    <div class="overlay"></div>
                                    <span class="card-label">🎫 Billetterie</span>
                                    <div class="card-bottom">
                                        <p class="card-title">ᴛɪᴄᴋᴇᴛɪɴɢ 🎫 ⚫️🟢</p>
                                        <p class="card-desc ar">مباراة العميد ضد إتحاد خنشلة — الثلاثاء 19 ماي 2026 على الساعة 17:45 بملعب الشهيد حملاوي.</p>
                                        <div class="card-hashtags"><span>#TheDean1898</span><span>#CSCUSMK</span></div>
                                        <a href="https://digiticket.dz" target="_blank" class="card-ticket-btn" onclick="event.stopPropagation();">🎟️ اشترِ تذكرتك</a>
                                    </div>
                                </div>

                                <div class="csc-scroll-card news-card-link" data-url="actualite.php?id=4">
                                    <img src="images/Actualite/usmaNews.jpeg" alt="">
                                    <div class="overlay"></div>
                                    <span class="card-label">تهنئة</span>
                                    <div class="card-bottom">
                                        <p class="card-title">تهنئة 🇩🇿🏆</p>
                                        <p class="card-desc ar">تقدم النادي الرياضي القسنطيني بأحر التهاني لنادي اتحاد العاصمة بمناسبة فوزه بكأس الكونفدرالية الإفريقية.</p>
                                        <div class="card-hashtags"><span>#TheDean1898</span><span>#USMA</span></div>
                                    </div>
                                </div>

                                <div class="csc-scroll-card news-card-link" data-url="actualite.php?id=1">
                                    <img src="images/Actualite/Ooredoonews.jpeg" alt="">
                                    <div class="overlay"></div>
                                    <span class="card-label">🤝 شراكة رسمية</span>
                                    <div class="card-bottom">
                                        <p class="card-title">🤝 رسمياً: "Ooredoo" ممول جديد 🟢🖤</p>
                                        <p class="card-desc ar">تعلن إدارة النادي الرياضي القسنطيني عن إبرام عقد رعاية مع شركة "Ooredoo" لمدة سنتين.</p>
                                        <div class="card-hashtags"><span>#TheDean1898</span><span>#Ooredoo</span></div>
                                    </div>
                                </div>

                                <div class="csc-scroll-card news-card-link" data-url="actualite.php?id=2">
                                    <img src="images/Actualite/news7.jpg" alt="">
                                    <div class="overlay"></div>
                                    <span class="card-label">الموقع الرسمي</span>
                                    <div class="card-bottom">
                                        <p class="card-title">"العميد" يعزز ريادته الرقمية 🟢⚫🌐</p>
                                        <p class="card-desc ar">يسعدنا إعلان إطلاق الموقع الإلكتروني الرسمي للنادي الرياضي القسنطيني.</p>
                                        <div class="card-hashtags"><span>#TheDean1898</span><span>#DimaCsc</span></div>
                                    </div>
                                </div>

                                <div class="csc-scroll-card news-card-link" data-url="actualite.php?id=3">
                                    <img src="images/Actualite/news2.jpeg" alt="">
                                    <div class="overlay"></div>
                                    <span class="card-label">🇩🇿 CALLED UP</span>
                                    <div class="card-bottom">
                                        <p class="card-title">𝐂𝐀𝐋𝐋𝐄𝐃 𝐔𝐏 🇩🇿 — استدعاء لاعبي العميد</p>
                                        <p class="card-desc ar">تلقى لاعبو العميد "بن عدلة"، "بن موسى" و"خلفاوي" استدعاءً للمنتخب الوطني.</p>
                                        <div class="card-hashtags"><span>#TheDean1898</span><span>#DimaCsc</span></div>
                                    </div>
                                </div>

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
                <p>Partager cet article</p>
                <div class="share-btns">
                    <button class="share-btn copy" id="copyBtn">&nbsp; Copier le lien</button>
                    <button class="share-btn whats" id="whatsBtn">&nbsp; Partager sur WhatsApp</button>
                </div>
                <div class="share-feedback" id="shareFeedback"></div>
            </div>
        </div>

        <!-- JOUEURS -->
        <section class="team-squad wf100 p80-50">
            <div class="container">
                <div class="row">
                    <div class="col-md-12"><div class="section-title white"><h2>Joueurs</h2><a class="full-team" href="joueurs.php">Voir toute l'équipe</a></div></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><div class="player-box with-extra-info"><div class="player-thumb"><img src="images/Homme/Milieux17.jpeg" alt="LAHMERI Aimen" width="240"></div><div class="player-txt"><h3>LAHMERI Aimen A.</h3><br><ul class="pb-small-info"><li>N° <strong>17</strong></li><li>Poste <strong>Milieu</strong></li><li>Age <strong>29 Ans</strong></li></ul></div></div></div>
                    <div class="col-md-6"><div class="player-box with-extra-info"><div class="player-thumb"><img src="images/Homme/Milieux24.jpeg" alt="GUENAOUI Ghiles" width="240"></div><div class="player-txt"><h3>GUENAOUI Ghiles</h3><br><ul class="pb-small-info"><li>N° <strong>24</strong></li><li>Poste <strong>Milieu</strong></li><li>Age <strong>27 Ans</strong></li></ul></div></div></div>
                    <div class="col-md-6"><div class="player-box with-extra-info"><div class="player-thumb"><img src="images/Homme/Def4.jpeg" alt="AIT ABDESSELAM Ahmed" width="240"></div><div class="player-txt"><h3>AIT ABDESSELAM Ahmed</h3><br><ul class="pb-small-info"><li>N° <strong>4</strong></li><li>Poste <strong>Défenseur</strong></li><li>Age <strong>28 Ans</strong></li></ul></div></div></div>
                    <div class="col-md-6"><div class="player-box with-extra-info"><div class="player-thumb"><img src="images/Homme/Attaquant9.jpeg" alt="AGBAGNO Yawo" width="240"></div><div class="player-txt"><h3>AGBAGNO Yawo M. Evra</h3><br><ul class="pb-small-info"><li>N° <strong>9</strong></li><li>Poste <strong>Attaquant</strong></li><li>Age <strong>25 Ans</strong></li></ul></div></div></div>
                </div>
            </div>
        </section>

        <section class="wf100 p80 players-squad portfolio filter-gallery">
            <div class="container"><div class="row"><div class="col-md-12"><div class="static-pagetitle"><h2>Site officiel du CSC - Club Sportif Constantinois</h2></div></div></div></div>
        </section>

        <!-- PALMARES -->
        <section class="wf100 p80" id="palmares" style="background:#f7fdf7;">
            <div class="container">
                <div class="row"><div class="col-md-12"><div class="section-title"><h2>Palmarès</h2></div><p style="text-align:center;color:#555;font-size:15px;margin-top:-10px;margin-bottom:40px;">Retracez l'histoire riche en succès de l'un des piliers du football algérien.</p></div></div>
                <div class="row" style="margin-bottom:40px;">
                    <div class="col-md-12">
                        <div class="pal-stat-strip">
                            <div class="pal-stat-item"><span class="pal-stat-num">1898</span><span class="pal-stat-lbl">Année de fondation</span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num">02</span><span class="pal-stat-lbl">Titres Championnat</span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num">06</span><span class="pal-stat-lbl">Titres Ligue 2 <small>(Record National)</small></span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num">06</span><span class="pal-stat-lbl">Demi-finales Coupe</span></div>
                            <div class="pal-stat-divider"></div>
                            <div class="pal-stat-item"><span class="pal-stat-num">1<sup>er</sup></span><span class="pal-stat-lbl">Demi-finale africaine</span></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🏆</span><h3 class="pal-card-title">Ligue 1 Mobilis</h3><p class="pal-card-sub">Championnat d'Algérie</p></div><div class="pal-card-body"><div class="pal-trophy champion"><span class="pal-trophy-label">🥇 Champion (02)</span><ul class="pal-years"><li>1996 – 1997</li><li>2017 – 2018</li></ul></div><div class="pal-trophy vice"><span class="pal-trophy-label">🥈 Vice-champion</span><ul class="pal-years"><li>1970 – 1971</li><li>2023 – 2024</li></ul></div></div></div></div>
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🏆</span><h3 class="pal-card-title">Ligue 2</h3><p class="pal-card-sub">D2 — Record National (06 titres)</p></div><div class="pal-card-body"><div class="pal-trophy champion"><span class="pal-trophy-label">🥇 Champion (06)</span><ul class="pal-years"><li>1969 – 1970</li><li>1976 – 1977</li><li>1985 – 1986</li><li>1993 – 1994</li><li>2003 – 2004</li><li>2010 – 2011</li></ul></div></div></div></div>
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🎖️</span><h3 class="pal-card-title">Coupe d'Algérie</h3><p class="pal-card-sub">La Dame Coupe</p></div><div class="pal-card-body"><div class="pal-trophy semi"><span class="pal-trophy-label">Demi-finaliste (06)</span><ul class="pal-years"><li>1986 – 1987</li><li>1991 – 1992</li><li>2011 – 2012</li><li>2018 – 2019</li><li>2024 – 2025</li><li>2025 – 2026</li></ul></div></div></div></div>
                    <div class="col-lg-3 col-md-6 pal-col"><div class="pal-card"><div class="pal-card-header"><span class="pal-icon">🌍</span><h3 class="pal-card-title">Compétitions Africaines</h3><p class="pal-card-sub">Scène continentale</p></div><div class="pal-card-body"><div class="pal-trophy semi"><span class="pal-trophy-label">CAF Champions League</span><ul class="pal-years"><li>Quart-finaliste 2018-2019</li></ul></div><div class="pal-trophy africa-highlight"><span class="pal-trophy-label">Coupe de la CAF</span><ul class="pal-years"><li><strong>🏅 Demi-finaliste 2024-2025</strong></li><li style="font-size:11px;color:#0a4f0a;font-style:italic;">1ère fois de l'histoire !</li></ul></div></div></div></div>
                </div>
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <div class="pal-doyen-banner">
                            <div class="pal-doyen-left"><img src="images/logo-dark.png" alt="CSC" style="height:50px;object-fit:contain;"></div>
                            <div class="pal-doyen-center">
                                <span class="pal-doyen-badge">⚽ Le Doyen des Clubs Algériens</span>
                                <p>Fondé en <strong>1898</strong>, le CS Constantine est le témoin historique de l'évolution du football en Algérie, soutenu par ses fidèles <strong>Sanafirs</strong>.</p>
                            </div>
                            <div class="pal-doyen-right"><a href="histoire.php" class="pal-history-btn">Notre Histoire &rarr;</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTACT -->
        <section class="wf100 p80" id="contact-section" style="background:#f4f9f4;">
            <div class="container">
                <div class="row"><div class="col-md-12 text-center" style="margin-bottom:40px;"><div class="section-title"><h2>Contact</h2></div><p style="color:#555;font-size:15px;margin-top:-10px;">Une question ? Contactez le Club Sportif Constantinois.</p></div></div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6" style="margin-bottom:20px;">
                        <div style="background:#fff;border-radius:14px;padding:28px 24px;display:flex;align-items:flex-start;gap:18px;box-shadow:0 2px 12px rgba(0,0,0,0.07);height:100%;">
                            <div style="background:#0a4f0a;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-map-marker-alt" style="color:#fff;font-size:20px;"></i></div>
                            <div><h5 style="font-weight:800;margin:0 0 8px;color:#111;">Adresse</h5><p style="color:#555;font-size:14px;margin:0;line-height:1.6;">Annexe OPOW Chahid Hamlaoui<br>Constantine, Algeria, 25000</p></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" style="margin-bottom:20px;">
                        <div style="background:#fff;border-radius:14px;padding:28px 24px;display:flex;align-items:flex-start;gap:18px;box-shadow:0 2px 12px rgba(0,0,0,0.07);height:100%;">
                            <div style="background:#0a4f0a;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-phone" style="color:#fff;font-size:20px;"></i></div>
                            <div><h5 style="font-weight:800;margin:0 0 8px;color:#111;">Téléphone</h5><p style="color:#555;font-size:14px;margin:0;"><a href="tel:+21303164882" style="color:#555;text-decoration:none;">+213 031 64 88 21</a></p></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" style="margin-bottom:20px;">
                        <div style="background:#fff;border-radius:14px;padding:28px 24px;display:flex;align-items:flex-start;gap:18px;box-shadow:0 2px 12px rgba(0,0,0,0.07);height:100%;">
                            <div style="background:#0a4f0a;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-envelope" style="color:#fff;font-size:20px;"></i></div>
                            <div><h5 style="font-weight:800;margin:0 0 8px;color:#111;">Email</h5><p style="color:#555;font-size:14px;margin:0;"><a href="mailto:contact@csconstantine.dz" style="color:#0a4f0a;text-decoration:none;font-weight:600;">contact@csconstantine.dz</a></p></div>
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

        <!-- SPONSORS ANIMÉS -->
        <div class="sponsor-strip" id="sponsors-section">
            <div class="sponsor-track-outer">
                <div class="sponsor-track">
                    <div class="sponsor-item"><img src="images/entp.jpeg" alt="ENTP"></div>
                    <div class="sponsor-item"><img src="images/hayat.jpeg" alt="Hayat"></div>
                    <div class="sponsor-item"><img src="images/kcs.jpeg" alt="KCS"></div>
                    <div class="sponsor-item"><img src="images/ooredoo.jpeg" alt="Ooredoo"></div>
                    <div class="sponsor-item"><img src="images/soumam.jpeg" alt="Soummam"></div>
                    <div class="sponsor-item"><img src="images/entp.jpeg" alt="ENTP"></div>
                    <div class="sponsor-item"><img src="images/hayat.jpeg" alt="Hayat"></div>
                    <div class="sponsor-item"><img src="images/kcs.jpeg" alt="KCS"></div>
                    <div class="sponsor-item"><img src="images/ooredoo.jpeg" alt="Ooredoo"></div>
                    <div class="sponsor-item"><img src="images/soumam.jpeg" alt="Soummam"></div>
                    <div class="sponsor-item"><img src="images/entp.jpeg" alt="ENTP"></div>
                    <div class="sponsor-item"><img src="images/hayat.jpeg" alt="Hayat"></div>
                    <div class="sponsor-item"><img src="images/kcs.jpeg" alt="KCS"></div>
                    <div class="sponsor-item"><img src="images/ooredoo.jpeg" alt="Ooredoo"></div>
                    <div class="sponsor-item"><img src="images/soumam.jpeg" alt="Soummam"></div>
                    <div class="sponsor-item"><img src="images/entp.jpeg" alt="ENTP"></div>
                    <div class="sponsor-item"><img src="images/hayat.jpeg" alt="Hayat"></div>
                    <div class="sponsor-item"><img src="images/kcs.jpeg" alt="KCS"></div>
                    <div class="sponsor-item"><img src="images/ooredoo.jpeg" alt="Ooredoo"></div>
                    <div class="sponsor-item"><img src="images/soumam.jpeg" alt="Soummam"></div>
                </div>
            </div>
        </div>

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
            copyBtn.textContent = 'Lien copié !';
            copyBtn.classList.add('copied');
            feedback.textContent = 'Le lien a été copié dans le presse-papiers.';
        }).catch(function(){ feedback.textContent = currentUrl; });
    });
    whatsBtn.addEventListener('click', function(){
        window.open('https://wa.me/?text=' + encodeURIComponent(titleEl.textContent + '\n' + currentUrl), '_blank');
    });
})();
</script>
</body>
</html>