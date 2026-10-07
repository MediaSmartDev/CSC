<?php require_once __DIR__ . '/Data/lang.php'; ?>
<?php
/* =====================================================================
 * CATÉGORIES JEUNES - CS Constantine
 * Pour remplir une catégorie : ajouter ses joueurs dans 'joueurs'
 *   ['nom' => '...', 'num' => '7', 'poste' => 'Milieu', 'img' => 'images/jeunes/xxx.jpg']
 * et (optionnel) le nom de l'entraîneur dans 'coach'.
 * Tant que 'joueurs' est vide, la carte affiche « Effectif bientôt disponible ».
 * ===================================================================== */
$CATEGORIES = [
    ['code' => 'U21', 'fr' => 'Réserve (U21)', 'ar' => 'الآمال (أقل من 21 سنة)', 'coach' => '', 'joueurs' => []],
    ['code' => 'U19', 'fr' => 'Juniors (U19)', 'ar' => 'الأواسط (أقل من 19 سنة)', 'coach' => '', 'joueurs' => []],
    ['code' => 'U17', 'fr' => 'Cadets (U17)',  'ar' => 'الأشبال (أقل من 17 سنة)', 'coach' => '', 'joueurs' => []],
    ['code' => 'U15', 'fr' => 'Minimes (U15)', 'ar' => 'الأصاغر (أقل من 15 سنة)', 'coach' => '', 'joueurs' => []],
    ['code' => 'U13', 'fr' => 'Benjamins (U13)', 'ar' => 'البراعم (أقل من 13 سنة)', 'coach' => '', 'joueurs' => []],
];
$e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
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
    <title><?= L('Catégories jeunes - CS Constantine', 'الفئات الشبانية - النادي الرياضي القسنطيني') ?></title>
    <style>
        .jn-intro{text-align:center;max-width:760px;margin:0 auto 40px;}
        .jn-intro h2{font-weight:800;color:#0a4f0a;margin-bottom:10px;}
        .jn-intro p{color:#555;margin:0;}
        .jn-tabs{display:flex;flex-wrap:wrap;justify-content:center;gap:10px;margin-bottom:35px;}
        .jn-tabs button{border:2px solid #0a4f0a;background:#fff;color:#0a4f0a;font-weight:700;padding:8px 20px;border-radius:30px;cursor:pointer;transition:.2s;}
        .jn-tabs button.active,.jn-tabs button:hover{background:#0a4f0a;color:#fff;}
        .jn-cat{display:none;}
        .jn-cat.active{display:block;}
        .jn-head{display:flex;align-items:center;gap:18px;background:linear-gradient(135deg,#06210f,#0a4f0a 60%,#1a7a1a);border-radius:16px;padding:24px 30px;color:#fff;margin-bottom:28px;box-shadow:0 10px 28px rgba(10,79,10,.25);}
        .jn-head .jn-code{background:#f0c040;color:#06210f;font-weight:900;font-size:22px;border-radius:12px;padding:10px 16px;}
        .jn-head h3{color:#fff;margin:0;font-weight:800;}
        .jn-head small{color:rgba(255,255,255,.8);}
        .jn-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:20px;}
        .jn-card{position:relative;border-radius:14px;overflow:hidden;background:#0a3d1a;aspect-ratio:4/5;box-shadow:0 6px 18px rgba(0,0,0,.12);}
        .jn-card img{width:100%;height:100%;object-fit:cover;object-position:top;}
        .jn-card .jn-info{position:absolute;left:0;right:0;bottom:0;padding:40px 14px 12px;background:linear-gradient(transparent,rgba(3,20,12,.92));color:#fff;}
        .jn-card .jn-info h5{color:#fff;margin:0;font-size:16px;font-weight:700;}
        .jn-card .jn-info small{color:#7fdc8f;font-weight:700;text-transform:uppercase;font-size:11px;}
        .jn-card .jn-num{position:absolute;top:10px;right:10px;background:#0a4f0a;color:#fff;font-weight:800;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid rgba(255,255,255,.6);}
        .jn-empty{text-align:center;background:#fff;border:2px dashed #b2d8b2;border-radius:16px;padding:50px 20px;color:#555;}
        .jn-empty i{font-size:42px;color:#1a7a1a;margin-bottom:12px;}
        .jn-empty h4{color:#0a4f0a;font-weight:800;}
        .jn-empty a{display:inline-block;margin-top:14px;background:#f0c040;color:#06210f;font-weight:800;padding:10px 24px;border-radius:30px;text-decoration:none;}
        html[dir="rtl"] .jn-card .jn-num{right:auto;left:10px;}
    </style>
</head>
<body>
<div class="wrapper">
    <?php require 'header.php'; ?>

    <div class="inner-banner-header wf100">
        <h1 data-generated="<?= L('Jeunes', 'الشبان') ?>"><?= L('Catégories jeunes', 'الفئات الشبانية') ?></h1>
        <div class="gt-breadcrumbs">
            <ul>
                <li><a href="index.php" class="active"><i class="fas fa-home"></i> <?= L('Accueil', 'الرئيسية') ?></a></li>
                <li><a href="#"><?= L('Catégories jeunes', 'الفئات الشبانية') ?></a></li>
            </ul>
        </div>
    </div>

    <div class="main-content innerpagebg wf100">
        <div class="wf100 p80">
            <div class="container">
                <div class="jn-intro">
                    <h2><?= L('L\'avenir du Doyen', 'مستقبل العميد') ?></h2>
                    <p><?= L('Les équipes de jeunes du Club Sportif Constantinois, de la réserve aux benjamins.', 'فرق الشبان للنادي الرياضي القسنطيني، من الآمال إلى البراعم.') ?></p>
                </div>

                <div class="jn-tabs">
                    <?php foreach ($CATEGORIES as $i => $c): ?>
                        <button type="button" class="<?= $i === 0 ? 'active' : '' ?>" data-cat="<?= $e($c['code']) ?>"><?= $e($c['code']) ?></button>
                    <?php endforeach; ?>
                </div>

                <?php foreach ($CATEGORIES as $i => $c): ?>
                <div class="jn-cat <?= $i === 0 ? 'active' : '' ?>" id="cat-<?= $e($c['code']) ?>">
                    <div class="jn-head">
                        <span class="jn-code"><?= $e($c['code']) ?></span>
                        <div>
                            <h3><?= $e(L($c['fr'], $c['ar'])) ?></h3>
                            <?php if ($c['coach']): ?><small><?= L('Entraîneur', 'المدرب') ?> : <?= $e($c['coach']) ?></small><?php endif; ?>
                        </div>
                    </div>
                    <?php if (empty($c['joueurs'])): ?>
                        <div class="jn-empty">
                            <i class="fas fa-users"></i>
                            <h4><?= L('Effectif bientôt disponible', 'التشكيلة ستتوفر قريباً') ?></h4>
                            <p><?= L('La liste des joueurs de cette catégorie sera publiée prochainement.', 'سيتم نشر قائمة لاعبي هذه الفئة قريباً.') ?></p>
                            <a href="index.php#contact-section"><?= L('Contacter le club', 'اتصل بالنادي') ?></a>
                        </div>
                    <?php else: ?>
                        <div class="jn-grid">
                            <?php foreach ($c['joueurs'] as $j): ?>
                            <div class="jn-card">
                                <img src="<?= $e($j['img'] ?? '' ?: 'images/player-default.png') ?>" alt="<?= $e($j['nom']) ?>" loading="lazy">
                                <?php if (!empty($j['num'])): ?><div class="jn-num"><?= $e($j['num']) ?></div><?php endif; ?>
                                <div class="jn-info"><h5><?= $e($j['nom']) ?></h5><small><?= $e(Lv($j['poste'] ?? '')) ?></small></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php require 'footer.php'; ?>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/mobile-nav.js"></script>
<script>
document.querySelectorAll('.jn-tabs button').forEach(function(b){
    b.addEventListener('click', function(){
        document.querySelectorAll('.jn-tabs button').forEach(function(x){ x.classList.remove('active'); });
        document.querySelectorAll('.jn-cat').forEach(function(x){ x.classList.remove('active'); });
        b.classList.add('active');
        document.getElementById('cat-' + b.getAttribute('data-cat')).classList.add('active');
    });
});
</script>
</body>
</html>
