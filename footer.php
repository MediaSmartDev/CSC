<footer class="wf100 main-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget about-widget">
                    <a href="index.php" class="csc-footer-logo"><img src="images/logo-light.png?v=3" alt="<?= L('CS Constantine', 'النادي الرياضي القسنطيني') ?>"></a>
                    <address>
                        <ul>
                            <li><i class="fas fa-map-marker-alt"></i> <?= L('Stade Chahid Hamlaoui, Constantine, Algérie', 'ملعب الشهيد حملاوي، قسنطينة، الجزائر') ?></li>
                            <li><i class="fas fa-envelope"></i> contact@csconstantine.dz</li>
                        </ul>
                    </address>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h4><?= L('Liens rapides', 'روابط سريعة') ?></h4>
                    <ul class="footer-links">
                        <li><a href="index.php"><i class="fas fa-angle-double-right"></i> <?= L('Accueil', 'الرئيسية') ?></a></li>
                        <li><a href="identite.php"><i class="fas fa-angle-double-right"></i> <?= L('Identité du club', 'هوية النادي') ?></a></li>
                        <li><a href="histoire.php"><i class="fas fa-angle-double-right"></i> <?= L('Histoire', 'التاريخ') ?></a></li>
                        <li><a href="palmares.php"><i class="fas fa-angle-double-right"></i> <?= L('Palmarès', 'الألقاب') ?></a></li>
                        <li><a href="joueurs.php"><i class="fas fa-angle-double-right"></i> <?= L('Joueurs', 'اللاعبون') ?></a></li>
                        <li><a href="classement.php"><i class="fas fa-angle-double-right"></i> <?= L('Classement', 'الترتيب') ?></a></li>
                        <li><a href="resultats.php"><i class="fas fa-angle-double-right"></i> <?= L('Résultats', 'النتائج') ?></a></li>
                        <li><a href="equipe-feminine.php"><i class="fas fa-angle-double-right"></i> <?= L('Équipe féminine', 'الفريق النسوي') ?></a></li>
                        <li><a href="inscription.php"><i class="fas fa-angle-double-right"></i> <?= L('Inscription', 'التسجيل') ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h4><?= L('Réseaux sociaux', 'مواقع التواصل') ?></h4>
                    <ul class="footer-links">
                        <li><a href="https://www.facebook.com/csconstantine.official" target="_blank"><i class="fab fa-facebook-f"></i> <?= L('Facebook', 'فيسبوك') ?></a></li>
                        <li><a href="https://www.instagram.com/csconstantine_officiel/" target="_blank"><i class="fab fa-instagram"></i> <?= L('Instagram', 'إنستغرام') ?></a></li>
                        <li><a href="https://www.youtube.com/@CSConstantineTV" target="_blank"><i class="fab fa-youtube"></i> <?= L('YouTube — CSC TV', 'يوتيوب — قناة النادي') ?></a></li>
                        <li><a href="https://www.tiktok.com/@clubsportifconstantinois" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="13" fill="currentColor" style="vertical-align:-1px;margin-right:4px;"><path d="M448 209.9a210.1 210.1 0 0 1-122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/></svg> <?= L('TikTok', 'تيك توك') ?></a></li>
                        <li><a href="https://t.me/+Eb8qO-lZuXwyYTY0" target="_blank"><i class="fab fa-telegram"></i> <?= L('Telegram', 'تيليغرام') ?></a></li>
                        <li><a href="https://whatsapp.com/channel/0029VayARgfHFxOv1xDBSl3n" target="_blank"><i class="fab fa-whatsapp"></i> <?= L('WhatsApp', 'واتساب') ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container brtop">
        <div class="row">
            <div class="col-12 text-center">
                <p class="copyr">© <?= date('Y') ?> <?= L('CS Constantine', 'النادي الرياضي القسنطيني') ?> — <?= L('Tous droits réservés', 'جميع الحقوق محفوظة') ?></p>
            </div>
        </div>
    </div>
</footer>
<style>
    .main-footer .csc-footer-logo{display:inline-block;background:none;padding:0;margin-bottom:25px;}
    .main-footer .csc-footer-logo img{height:50px !important;width:auto !important;max-width:100%;display:block;margin:0 !important;}
</style>

<?php /* ===== ESPACE PUBLICITAIRE (réglages dans Data/pub.php) ===== */
$PUB = require __DIR__ . '/Data/pub.php';
if (!empty($PUB['actif'])): ?>
<div class="csc-pub-bar" id="cscPubBar" role="complementary" aria-label="<?= L('Publicité', 'إعلان') ?>">
    <?php if (!empty($PUB['lien'])): ?><a href="<?= htmlspecialchars($PUB['lien']) ?>" target="_blank" rel="noopener sponsored"><?php endif; ?>
    <?php if ($PUB['type'] === 'video'): ?>
        <video src="<?= htmlspecialchars($PUB['fichier']) ?>" <?= !empty($PUB['poster']) ? 'poster="' . htmlspecialchars($PUB['poster']) . '"' : '' ?> autoplay muted loop playsinline preload="metadata" aria-label="<?= htmlspecialchars($PUB['alt']) ?>"></video>
    <?php else: ?>
        <img src="<?= htmlspecialchars($PUB['fichier']) ?>" alt="<?= htmlspecialchars($PUB['alt']) ?>">
    <?php endif; ?>
    <?php if (!empty($PUB['lien'])): ?></a><?php endif; ?>
    <button type="button" class="csc-pub-close" aria-label="<?= L('Fermer la publicité', 'إغلاق الإعلان') ?>" onclick="document.getElementById('cscPubBar').style.display='none';document.body.classList.remove('has-pub-bar');">&times;</button>
</div>
<script>document.body.classList.add('has-pub-bar');</script>
<style>
    .csc-pub-bar{position:fixed;left:0;right:0;bottom:0;z-index:9990;background:#000;line-height:0;box-shadow:0 -4px 18px rgba(0,0,0,.35);}
    .csc-pub-bar a{display:block;}
    .csc-pub-bar video,.csc-pub-bar img{display:block;width:100%;height:auto;max-height:96px;object-fit:cover;object-position:center;margin:0 auto;}
    .csc-pub-close{position:absolute;top:4px;right:6px;width:22px;height:22px;border-radius:50%;border:0;background:rgba(255,255,255,.2);color:#fff;font-size:15px;line-height:22px;padding:0;cursor:pointer;}
    .csc-pub-close:hover{background:#fff;color:#000;}
    html[dir="rtl"] .csc-pub-close{right:auto;left:6px;}
    /* espace sous le footer pour que la bande ne cache pas le bas de page */
    body.has-pub-bar .main-footer{padding-bottom:calc(5vw + 10px);}
    @media(min-width:1920px){body.has-pub-bar .main-footer{padding-bottom:106px;}}
    @media(max-width:768px){
        .csc-pub-bar video,.csc-pub-bar img{height:48px;max-height:none;}   /* sur mobile on garde une bande lisible */
        body.has-pub-bar .main-footer{padding-bottom:58px;}
    }
</style>
<?php endif; ?>
