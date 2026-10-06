<?php require_once __DIR__ . '/Data/lang.php'; ?>
<!doctype html>
<?php
/* =====================================================================
 * ÉQUIPE FÉMININE - CS Constantine
 * Pour compléter : remplir 'nom' et 'num' de chaque joueuse ci-dessous.
 * (laisser '' tant que l'info n'est pas connue : rien ne s'affiche)
 * ===================================================================== */
$equipe = [
    'Gardiennes' => [
        ['img' => 'gardienne-01.jpg', 'nom' => '', 'num' => ''],
        ['img' => 'gardienne-02.jpg', 'nom' => '', 'num' => ''],
    ],
    'Joueuses' => [],
    'Staff technique' => [
        ['img' => 'staff-01.jpg', 'nom' => '', 'num' => '', 'role' => 'Staff'],
        ['img' => 'staff-02.jpg', 'nom' => '', 'num' => '', 'role' => 'Staff'],
    ],
];
for ($i = 1; $i <= 24; $i++) {
    $equipe['Joueuses'][] = ['img' => sprintf('joueuse-%02d.jpg', $i), 'nom' => '', 'num' => ''];
}
$roles = ['Gardiennes' => L('Gardienne', 'حارسة مرمى'), 'Joueuses' => L('Joueuse', 'لاعبة'), 'Staff technique' => L('Staff', 'الطاقم الفني')];
$titres = ['Gardiennes' => L('Gardiennes', 'حارسات المرمى'), 'Joueuses' => L('Joueuses', 'اللاعبات'), 'Staff technique' => L('Staff technique', 'الطاقم الفني')];
$slug  = ['Gardiennes' => 'gardiennes', 'Joueuses' => 'joueuses', 'Staff technique' => 'staff'];
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
    <title><?= L('Équipe féminine - CS Constantine', 'الفريق النسوي - النادي الرياضي القسنطيني') ?></title>
    <style>
        .fem-intro{text-align:center;max-width:720px;margin:0 auto 35px;}
        .fem-intro h2{font-weight:800;color:#0a4f0a;margin-bottom:10px;}
        .fem-intro p{color:#555;margin:0;}
        .fem-filters{display:flex;flex-wrap:wrap;justify-content:center;gap:10px;margin-bottom:40px;}
        .fem-filters button{border:2px solid #0a4f0a;background:#fff;color:#0a4f0a;font-weight:700;padding:8px 20px;border-radius:30px;cursor:pointer;transition:.2s;}
        .fem-filters button.active,.fem-filters button:hover{background:#0a4f0a;color:#fff;}
        .fem-group{margin-bottom:50px;}
        .fem-group-title{display:flex;align-items:center;gap:14px;margin-bottom:25px;}
        .fem-group-title h3{margin:0;font-weight:800;color:#111;}
        .fem-group-title span.count{background:#0a4f0a;color:#fff;font-size:13px;font-weight:700;border-radius:20px;padding:2px 12px;}
        .fem-group-title:after{content:"";flex:1;height:3px;background:linear-gradient(90deg,#1a7a1a,transparent);border-radius:3px;}
        .fem-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:22px;}
        .fem-card{position:relative;border-radius:14px;overflow:hidden;background:#1b1b1b;aspect-ratio:2/3;cursor:pointer;box-shadow:0 6px 18px rgba(0,0,0,.12);transition:transform .3s,box-shadow .3s;}
        .fem-card img{width:100%;height:100%;object-fit:cover;object-position:top center;display:block;transition:transform .5s;}
        .fem-card:hover{transform:translateY(-6px);box-shadow:0 14px 30px rgba(10,79,10,.35);}
        .fem-card:hover img{transform:scale(1.06);}
        .fem-card .fem-info{position:absolute;left:0;right:0;bottom:0;padding:50px 16px 14px;background:linear-gradient(transparent,rgba(3,20,12,.92));color:#fff;}
        .fem-card .fem-info h5{color:#fff;margin:0 0 2px;font-weight:700;font-size:17px;}
        .fem-card .fem-info small{color:#7fdc8f;font-weight:700;text-transform:uppercase;letter-spacing:1px;font-size:12px;}
        .fem-card .fem-num{position:absolute;top:12px;right:12px;background:#0a4f0a;color:#fff;font-weight:800;min-width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:17px;border:2px solid rgba(255,255,255,.6);}
        .fem-lightbox{position:fixed;inset:0;background:rgba(0,0,0,.9);display:none;align-items:center;justify-content:center;z-index:99999;padding:20px;}
        .fem-lightbox.open{display:flex;}
        .fem-lightbox img{max-width:100%;max-height:90vh;border-radius:10px;}
        .fem-lightbox .fem-close,.fem-lightbox .fem-nav{position:absolute;background:rgba(255,255,255,.12);border:0;color:#fff;width:48px;height:48px;border-radius:50%;font-size:22px;cursor:pointer;}
        .fem-lightbox .fem-close{top:20px;right:20px;}
        .fem-lightbox .fem-prev{left:20px;top:50%;transform:translateY(-50%);}
        .fem-lightbox .fem-next{right:20px;top:50%;transform:translateY(-50%);}
        @media(max-width:576px){.fem-grid{grid-template-columns:repeat(2,1fr);gap:12px;}.fem-card .fem-info h5{font-size:14px;}}
    </style>
</head>
<body>
<div class="wrapper">
    <?php require 'header.php'; ?>

    <div class="inner-banner-header wf100">
        <h1 data-generated="<?= L('Féminine', 'النسوي') ?>"><?= L('Équipe féminine', 'الفريق النسوي') ?></h1>
        <div class="gt-breadcrumbs">
            <ul>
                <li><a href="index.php" class="active"><i class="fas fa-home"></i> <?= L('Accueil', 'الرئيسية') ?></a></li>
                <li><a href="#"><?= L('Équipe féminine', 'الفريق النسوي') ?></a></li>
            </ul>
        </div>
    </div>

    <div class="main-content innerpagebg wf100">
        <div class="wf100 p80">
            <div class="container">
                <div class="fem-intro">
                    <h2><?= L('Les Sanafirettes du CSC', 'سنافيرات النادي الرياضي القسنطيني') ?></h2>
                    <p><?= L('L\'effectif de l\'équipe féminine du Club Sportif Constantinois.', 'تشكيلة الفريق النسوي للنادي الرياضي القسنطيني.') ?></p>
                </div>

                <div class="fem-filters">
                    <button class="active" data-filter="all"><?= L('Tout l\'effectif', 'كل التشكيلة') ?></button>
                    <?php foreach ($equipe as $groupe => $liste): ?>
                        <button data-filter="<?= $slug[$groupe] ?>"><?= $titres[$groupe] ?></button>
                    <?php endforeach; ?>
                </div>

                <?php foreach ($equipe as $groupe => $liste): ?>
                <div class="fem-group" data-group="<?= $slug[$groupe] ?>">
                    <div class="fem-group-title"><h3><?= $titres[$groupe] ?></h3><span class="count"><?= count($liste) ?></span></div>
                    <div class="fem-grid">
                        <?php foreach ($liste as $p): $role = isset($p['role']) ? Lv($p['role']) : $roles[$groupe]; ?>
                        <div class="fem-card" data-src="images/feminine/<?= $p['img'] ?>">
                            <img src="images/feminine/<?= $p['img'] ?>" alt="<?= htmlspecialchars($p['nom'] ?: $role) ?>" loading="lazy">
                            <?php if ($p['num'] !== ''): ?><div class="fem-num"><?= htmlspecialchars($p['num']) ?></div><?php endif; ?>
                            <div class="fem-info">
                                <?php if ($p['nom'] !== ''): ?><h5><?= htmlspecialchars($p['nom']) ?></h5><?php endif; ?>
                                <small><?= htmlspecialchars($role) ?></small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="fem-lightbox" id="femLightbox">
        <button class="fem-close" aria-label="<?= L('Fermer', 'إغلاق') ?>">&times;</button>
        <button class="fem-nav fem-prev" aria-label="Précédente">&#8249;</button>
        <img src="" alt="">
        <button class="fem-nav fem-next" aria-label="Suivante">&#8250;</button>
    </div>

    <?php require 'footer.php'; ?>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/mobile-nav.js"></script>
<script>
(function(){
    // Filtres
    var btns = document.querySelectorAll('.fem-filters button');
    btns.forEach(function(b){
        b.addEventListener('click', function(){
            btns.forEach(function(x){ x.classList.remove('active'); });
            b.classList.add('active');
            var f = b.getAttribute('data-filter');
            document.querySelectorAll('.fem-group').forEach(function(g){
                g.style.display = (f === 'all' || g.getAttribute('data-group') === f) ? '' : 'none';
            });
        });
    });
    // Visionneuse photo
    var lb = document.getElementById('femLightbox'), img = lb.querySelector('img'), list = [], idx = 0;
    function visibleCards(){ return Array.prototype.filter.call(document.querySelectorAll('.fem-card'), function(c){ return c.offsetParent !== null; }); }
    function show(i){ idx = (i + list.length) % list.length; img.src = list[idx].getAttribute('data-src'); }
    document.querySelectorAll('.fem-card').forEach(function(c){
        c.addEventListener('click', function(){ list = visibleCards(); show(list.indexOf(c)); lb.classList.add('open'); });
    });
    lb.querySelector('.fem-close').onclick = function(){ lb.classList.remove('open'); };
    lb.querySelector('.fem-prev').onclick = function(e){ e.stopPropagation(); show(idx - 1); };
    lb.querySelector('.fem-next').onclick = function(e){ e.stopPropagation(); show(idx + 1); };
    lb.addEventListener('click', function(e){ if (e.target === lb) lb.classList.remove('open'); });
    document.addEventListener('keydown', function(e){
        if (!lb.classList.contains('open')) return;
        if (e.key === 'Escape') lb.classList.remove('open');
        if (e.key === 'ArrowLeft') show(idx - 1);
        if (e.key === 'ArrowRight') show(idx + 1);
    });
})();
</script>
</body>
</html>
