<?php require_once __DIR__ . '/Data/lang.php'; ?>
<?php
/* Page de détail d'une actualité : actualite.php?id=...
 * Les actualités se trouvent dans Data/actualites.php */
$ACTUS = require __DIR__ . '/Data/actualites.php';
$id = (int)($_GET['id'] ?? 0);
$article = null;
foreach ($ACTUS as $a) { if ((int)$a['id'] === $id) { $article = $a; break; } }
if (!$article) http_response_code(404);

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$pageUrl = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'csconstantine.dz') . strtok($_SERVER['REQUEST_URI'] ?? '', '?') . '?id=' . $id;
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
    <title><?= $article ? $e(nt($article, 'titre')) . L(' - CS Constantine', ' - النادي الرياضي القسنطيني') : L('Actualité introuvable', 'الخبر غير موجود') ?></title>
    <?php if ($article): ?>
    <!-- Aperçu quand le lien est partagé (WhatsApp, Facebook...) -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= $e(nt($article, 'titre')) ?>">
    <meta property="og:description" content="<?= $e(nt($article, 'resume')) ?>">
    <?php $ogi = news_img($article['image']); ?>
    <meta property="og:image" content="<?= $e(preg_match('#^https?://#', $ogi) ? $ogi : dirname($pageUrl) . '/' . $ogi) ?>">
    <meta property="og:url" content="<?= $e($pageUrl) ?>">
    <?php endif; ?>
    <style>
        .art-hero{width:100%;max-height:520px;overflow:hidden;background:#03140c;line-height:0;}
        .art-hero img{width:100%;max-height:520px;object-fit:cover;object-position:center;}
        .art-wrap{max-width:860px;margin:0 auto;padding:45px 15px 60px;}
        .art-label{display:inline-block;background:#0a4f0a;color:#fff;font-size:12px;font-weight:700;padding:4px 12px;border-radius:20px;margin-bottom:14px;}
        .art-title{font-size:30px;font-weight:800;color:#111;line-height:1.4;margin:0 0 10px;}
        .art-meta{color:#888;font-size:13px;margin-bottom:28px;display:flex;gap:14px;flex-wrap:wrap;}
        .art-body p{font-size:17px;line-height:2;color:#333;margin:0 0 16px;}
        
        .art-tags{display:flex;flex-wrap:wrap;gap:8px;margin:25px 0;}
        .art-tags span{background:#eef7ee;color:#0a4f0a;font-weight:700;font-size:13px;padding:4px 12px;border-radius:20px;}
        .art-btn-main{display:inline-block;background:#f0c040;color:#06210f;font-weight:800;padding:12px 26px;border-radius:30px;text-decoration:none;margin-bottom:10px;}
        .art-btn-main:hover{background:#0a4f0a;color:#fff;text-decoration:none;}
        .art-share{border-top:1px solid #eee;padding-top:22px;margin-top:10px;}
        .art-share h6{font-size:12px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#555;margin-bottom:12px;}
        .art-share-btns{display:flex;flex-wrap:wrap;gap:10px;}
        .art-share-btns button,.art-share-btns a{border:0;border-radius:8px;padding:10px 18px;font-weight:700;font-size:14px;color:#fff;cursor:pointer;display:inline-flex;align-items:center;gap:8px;text-decoration:none;}
        .art-share-btns .copy{background:#0a4f0a;}
        .art-share-btns .copy.done{background:#1a7a1a;}
        .art-share-btns .art-wa{background:#25d366;}
        .art-share-btns .art-fb{background:#1877f2;}
        .art-share-btns a:hover,.art-share-btns button:hover{opacity:.9;color:#fff;}
        .art-feedback{font-size:13px;color:#1a7a1a;margin-top:8px;min-height:18px;}
        .art-back{display:inline-flex;align-items:center;gap:8px;background:#06210f;color:#fff;font-weight:700;padding:11px 24px;border-radius:30px;text-decoration:none;margin-top:25px;}
        .art-back:hover{background:#0a4f0a;color:#fff;text-decoration:none;}
        .art-more{background:#f4f9f4;padding:50px 0;}
        .art-more h3{font-weight:800;color:#0a4f0a;margin-bottom:25px;}
        .art-more-card{display:block;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 14px rgba(0,0,0,.07);text-decoration:none;color:#111;height:100%;transition:.25s;}
        .art-more-card:hover{transform:translateY(-4px);text-decoration:none;color:#0a4f0a;}
        .art-more-card img{width:100%;height:170px;object-fit:cover;}
        .art-more-card div{padding:14px 16px;font-weight:700;}
        .art-gal-title{font-size:13px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#0a4f0a;margin:30px 0 12px;}
        .art-gal{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:10px;}
        .art-gal a{display:block;border-radius:10px;overflow:hidden;line-height:0;}
        .art-gal img{width:100%;height:150px;object-fit:cover;transition:.3s;}
        .art-gal a:hover img{transform:scale(1.06);}
        .art-lb{direction:ltr;display:none;position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:99999;align-items:center;justify-content:center;}
        .art-lb.on{display:flex;}
        .art-lb img{max-width:92vw;max-height:88vh;border-radius:6px;}
        .art-lb button{position:absolute;background:none;border:0;color:#fff;font-size:42px;cursor:pointer;padding:10px 18px;}
        .art-lb .lb-x{top:10px;right:15px;}
        .art-lb .lb-p{left:10px;top:50%;transform:translateY(-50%);}
        .art-lb .lb-n{right:10px;top:50%;transform:translateY(-50%);}
        .art-404{text-align:center;padding:90px 15px;}
        @media(max-width:576px){.art-title{font-size:23px;}.art-body p{font-size:16px;}}
    </style>
</head>
<body>
<div class="wrapper">
    <?php require 'header.php'; ?>

<?php if (!$article): ?>
    <div class="art-404">
        <h2><?= L('Actualité introuvable', 'الخبر غير موجود') ?></h2>
        <p><?= L("Cet article n'existe pas ou a été retiré.", 'هذا الخبر غير موجود أو تم حذفه.') ?></p>
        <a href="index.php#actualites" class="art-back"><?= L('← Retour aux actualités', 'العودة إلى الأخبار →') ?></a>
    </div>
<?php else:
    $contenu = trim(nt($article, 'contenu')) !== '' ? nt($article, 'contenu') : nt($article, 'resume');
    $paras = array_filter(array_map('trim', preg_split("/\r\n|\n/", $contenu)));
?>
    <div class="art-hero"><img src="<?= $e(news_img($article['image'])) ?>" alt="<?= $e(nt($article, 'titre')) ?>"></div>

    <article class="art-wrap">
        <div>
            <span class="art-label"><?= $e(nt($article, 'label')) ?></span>
            <h1 class="art-title"><?= $e(nt($article, 'titre')) ?></h1>
        </div>
        <div class="art-meta">
            <?php if ($article['date']): ?><span><i class="far fa-calendar-alt"></i> <?= news_date($article['date']) ?></span><?php endif; ?>
            <span><i class="fas fa-shield-alt"></i> <?= L('Club Sportif Constantinois', 'النادي الرياضي القسنطيني') ?></span>
        </div>

        <div class="art-body">
            <?php foreach ($paras as $p): ?><p><?= nl2br($e($p)) ?></p><?php endforeach; ?>
        </div>

        <?php if (!empty($article['galerie']) && count($article['galerie']) > 1): ?>
        <h6 class="art-gal-title"><i class="fas fa-images"></i> <?= L('Photos', 'الصور') ?> (<?= count($article['galerie']) ?>)</h6>
        <div class="art-gal">
            <?php foreach ($article['galerie'] as $gi => $g): ?>
            <a href="<?= $e($g) ?>" data-i="<?= $gi ?>"><img src="<?= $e($g) ?>" alt="" loading="lazy"></a>
            <?php endforeach; ?>
        </div>
        <div class="art-lb" id="artLb"><button class="lb-x" aria-label="close">&times;</button><button class="lb-p" aria-label="prev">&#10094;</button><img src="" alt=""><button class="lb-n" aria-label="next">&#10095;</button></div>
        <?php endif; ?>

        <?php if (!empty($article['tags'])): ?>
        <div class="art-tags"><?php foreach ($article['tags'] as $t): ?><span><?= $e($t) ?></span><?php endforeach; ?></div>
        <?php endif; ?>

        <?php if (!empty($article['bouton'])): ?>
            <a class="art-btn-main" href="<?= $e($article['bouton']['lien']) ?>" target="_blank" rel="noopener"><?= $e(nt($article['bouton'], $LANG)) ?></a>
        <?php endif; ?>

        <div class="art-share">
            <h6><?= L('Partager cet article', 'شارك هذا الخبر') ?></h6>
            <div class="art-share-btns">
                <button type="button" class="copy" id="artCopy"><i class="fas fa-link"></i> <span><?= L('Copier le lien', 'نسخ الرابط') ?></span></button>
                <a class="art-wa" target="_blank" rel="noopener" href="https://wa.me/?text=<?= rawurlencode(nt($article, 'titre') . "\n" . $pageUrl) ?>"><i class="fab fa-whatsapp"></i> <?= L('WhatsApp', 'واتساب') ?></a>
                <a class="art-fb" target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode($pageUrl) ?>"><i class="fab fa-facebook-f"></i> <?= L('Facebook', 'فيسبوك') ?></a>
            </div>
            <div class="art-feedback" id="artFeedback"></div>
        </div>

        <a href="index.php#actualites" class="art-back"><?= L('← Retour aux actualités', 'العودة إلى الأخبار →') ?></a>
    </article>

    <?php $autres = array_slice(array_values(array_filter($ACTUS, fn($a) => (int)$a['id'] !== $id)), 0, 3); ?>
    <?php if ($autres): ?>
    <section class="art-more">
        <div class="container">
            <h3><?= L('Autres actualités', 'أخبار أخرى') ?></h3>
            <div class="row">
                <?php foreach ($autres as $o): ?>
                <div class="col-md-4" style="margin-bottom:20px;">
                    <a class="art-more-card" href="actualite.php?id=<?= (int)$o['id'] ?>">
                        <img src="<?= $e(news_img($o['image'])) ?>" alt="">
                        <div><?= $e(nt($o, 'titre')) ?></div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
<?php endif; ?>

    <?php require 'footer.php'; ?>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/mobile-nav.js"></script>
<script>
(function(){
    var btn = document.getElementById('artCopy'), fb = document.getElementById('artFeedback');
    if (!btn) return;
    var url = <?= json_encode($pageUrl) ?>;
    btn.addEventListener('click', function(){
        var done = function(){
            btn.classList.add('done');
            btn.querySelector('span').textContent = <?= LJ('Lien copié !', 'تم نسخ الرابط!') ?>;
            fb.textContent = <?= LJ('Le lien a été copié, vous pouvez le coller où vous voulez.', 'تم نسخ الرابط، يمكنك لصقه أينما تريد.') ?>;
        };
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(done, function(){ fb.textContent = url; });
        } else {   // http (sans https) : méthode de secours
            var t = document.createElement('textarea'); t.value = url; document.body.appendChild(t); t.select();
            try { document.execCommand('copy'); done(); } catch (err) { fb.textContent = url; }
            document.body.removeChild(t);
        }
    });
})();
</script>
<script>
(function(){
    var lb = document.getElementById('artLb'); if (!lb) return;
    var links = [].slice.call(document.querySelectorAll('.art-gal a')), img = lb.querySelector('img'), cur = 0;
    function show(i){ cur = (i + links.length) % links.length; img.src = links[cur].getAttribute('href'); lb.classList.add('on'); }
    links.forEach(function(a, i){ a.addEventListener('click', function(ev){ ev.preventDefault(); show(i); }); });
    lb.querySelector('.lb-x').onclick = function(){ lb.classList.remove('on'); };
    lb.querySelector('.lb-p').onclick = function(ev){ ev.stopPropagation(); show(cur - 1); };
    lb.querySelector('.lb-n').onclick = function(ev){ ev.stopPropagation(); show(cur + 1); };
    lb.addEventListener('click', function(ev){ if (ev.target === lb) lb.classList.remove('on'); });
    document.addEventListener('keydown', function(ev){ if (!lb.classList.contains('on')) return;
        if (ev.key === 'Escape') lb.classList.remove('on'); if (ev.key === 'ArrowRight') show(cur + 1); if (ev.key === 'ArrowLeft') show(cur - 1); });
})();
</script>
</body>
</html>
