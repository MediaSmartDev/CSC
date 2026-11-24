<?php require_once __DIR__ . '/Data/lang.php'; ?>
<!-- INNER BANNER -->
<div class="inner-banner-header wf100">
    <h1 data-generated="<?= L('Honours', 'الألقاب') ?>"><?= L('Honours', 'الألقاب') ?></h1>
    <div class="gt-breadcrumbs">
        <ul>
            <li><a href="index.php" class="active"><i class="fas fa-home"></i> <?= L('Home', 'الرئيسية') ?></a></li>
            <li><?= L('CLUB', 'النادي') ?></li>
            <li><a href="#"><?= L('Honours', 'الألقاب') ?></a></li>
        </ul>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content innerpagebg wf100 p80">
    <div class="news-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="news-details-wrap">
                        <div class="news-large-post">
                            <div class="post-txt">

<style>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');
.palmares-wrap { font-family:<?= $LANG === 'ar' ? "'Cairo',sans-serif" : 'inherit' ?>; direction:<?= $DIR ?>; }
.pal-founded { display:flex; align-items:center; gap:20px; background:#f4faf4; border:1.5px solid #b2d8b2; border-radius:14px; padding:1.2rem 1.5rem; margin-bottom:1.5rem; }
.pal-founded .year-big { font-size:48px; font-weight:900; color:#0a4f0a; line-height:1; min-width:90px; text-align:center; border-inline-end:3px solid #0a4f0a; padding-inline-end:20px; }
.pal-founded .year-text { font-size:14px; color:#444; line-height:1.7; }
.pal-founded .year-text strong { display:block; font-size:16px; color:#0a4f0a; margin-bottom:4px; }
.pal-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:18px; margin-bottom:1.5rem; }
.pal-card2 { background:#fff; border:1px solid #d4ead4; border-radius:14px; padding:1.3rem 1.4rem 1.1rem; position:relative; overflow:hidden; box-shadow:0 2px 8px rgba(10,79,10,0.06); }
.pal-card2::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(to left,#0a4f0a,#1a8a1a); }
.pal-card2 h3 { font-size:16px; font-weight:700; color:#0a4f0a; margin:0 0 1rem 0; padding-bottom:0.6rem; border-bottom:1px solid #e0f0e0; }
.pal-label2 { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#888; margin:0.8rem 0 0.3rem 0; }
.pal-row2 { display:flex; align-items:center; gap:8px; padding:6px 0; border-bottom:1px solid #f0f0f0; font-size:13px; color:#333; }
.pal-row2:last-child { border-bottom:none; }
.bdg { display:inline-flex; align-items:center; font-size:11px; font-weight:700; padding:3px 9px; border-radius:20px; white-space:nowrap; flex-shrink:0; }
.bdg-gold { background:#fff7d0; color:#7a5500; border:1px solid #e8c84a; }
.bdg-silver { background:#f2f2f2; color:#444; border:1px solid #ccc; }
.bdg-green { background:#e8f5e8; color:#1a6a1a; border:1px solid #8ec98e; }
.bdg-dark { background:#0a4f0a; color:#fff; border:1px solid #0a4f0a; }
.year-chips2 { display:flex; flex-wrap:wrap; gap:5px; margin-top:6px; }
.year-chip2 { font-size:11px; font-weight:600; background:#f4faf4; border:1px solid #b2d8b2; border-radius:6px; padding:2px 8px; color:#2a6a2a; }
.pal-stats2 { display:flex; gap:8px; margin-top:1rem; }
.pal-stat2 { flex:1; text-align:center; background:#f4faf4; border-radius:10px; padding:10px 4px 8px; border:1px solid #d4ead4; }
.pal-stat2 .num2 { display:block; font-size:28px; font-weight:900; color:#0a4f0a; line-height:1; }
.pal-stat2 .lbl2 { display:block; font-size:10px; color:#777; margin-top:3px; }
.gold-hl { background:#0a4f0a; color:#fff; border-radius:12px; padding:1.1rem 1.5rem; text-align:center; font-size:15px; font-weight:700; display:flex; align-items:center; justify-content:center; gap:10px; }
.gold-hl i { font-size:20px; color:#f5d000; }
@media(max-width:600px){ .pal-grid{grid-template-columns:1fr;} .pal-founded{flex-direction:column;text-align:center;} .pal-founded .year-big{border-right:none;border-bottom:3px solid #0a4f0a;padding-right:0;padding-bottom:10px;} }
</style>

<div class="palmares-wrap">
    <h2 style="font-size:24px;font-weight:900;color:#0a4f0a;text-align:center;margin-bottom:0.5rem;">🏆 <?= L('Club Sportif Constantinois honours', 'السجل الذهبي للنادي الرياضي القسنطيني') ?></h2>
    <p style="text-align:center;color:#555;font-size:14px;line-height:1.7;max-width:600px;margin:0 auto 2rem auto;"><?= L('These honours trace a history full of success for a club that is one of the pillars of Algerian football.', 'يستعرض هذا السجل تاريخاً حافلاً من الإنجازات لنادٍ يُعد أحد أعمدة كرة القدم الجزائرية.') ?></p>

    <div class="pal-founded">
        <div class="year-big">1898</div>
        <div class="year-text">
            <strong><?= L('The oldest sports club in Algeria', 'أقدم نادٍ رياضي في الجزائر') ?></strong>
            <?= L('CS Constantine is the oldest Algerian club and has witnessed more than a century of football history. Its loyal supporters are known as the <strong style="color:#0a4f0a">“Sanafirs / Clubistes”</strong>.', 'يُعدّ النادي الرياضي القسنطيني عميد الأندية الجزائرية وشاهدٌ على تاريخ اللعبة منذ أكثر من قرن. جمهوره الوفي يُعرف بـ <strong style="color:#0a4f0a">"السنافر"</strong>.') ?>
        </div>
    </div>

    <div class="pal-grid">

        <div class="pal-card2">
            <h3>🥇 <?= L('National titles', 'الألقاب الوطنية') ?></h3>
            <div class="pal-label2"><?= L('Ligue 1 — Algerian Championship', 'الرابطة الأولى — البطولة الجزائرية') ?></div>
            <div class="pal-row2"><span class="bdg bdg-gold">🏆 <?= L('Champions', 'بطل') ?></span><span>1996–1997 &nbsp;|&nbsp; 2017–2018</span></div>
            <div class="pal-row2"><span class="bdg bdg-silver">🥈 <?= L('Runners-up', 'وصيف') ?></span><span>1970–1971 &nbsp;|&nbsp; 2023–2024</span></div>
            <div class="pal-label2" style="margin-top:1rem"><?= L('Ligue 2', 'الرابطة الثانية') ?></div>
            <div class="pal-row2"><span class="bdg bdg-gold">🏆 <?= L('Champions × 6', 'بطل × 6') ?></span><strong style="color:#0a4f0a;font-size:12px"><?= L('National record', 'رقم قياسي وطني') ?></strong></div>
            <div class="year-chips2">
                <span class="year-chip2">1969–70</span><span class="year-chip2">1976–77</span><span class="year-chip2">1985–86</span>
                <span class="year-chip2">1993–94</span><span class="year-chip2">2003–04</span><span class="year-chip2">2010–11</span>
            </div>
        </div>

        <div class="pal-card2">
            <h3>🎖️ <?= L('Algerian Cup', 'كأس الجزائر') ?></h3>
            <div class="pal-label2"><?= L('Semi-finalists — 6 times', 'نصف النهائي — 6 مرات') ?></div>
            <div class="pal-row2"><span class="bdg bdg-green"><?= L('Semi-final', 'نصف النهائي') ?></span><span>1986–1987</span></div>
            <div class="pal-row2"><span class="bdg bdg-green"><?= L('Semi-final', 'نصف النهائي') ?></span><span>1991–1992</span></div>
            <div class="pal-row2"><span class="bdg bdg-green"><?= L('Semi-final', 'نصف النهائي') ?></span><span>2011–2012</span></div>
            <div class="pal-row2"><span class="bdg bdg-green"><?= L('Semi-final', 'نصف النهائي') ?></span><span>2018–2019</span></div>
            <div class="pal-row2"><span class="bdg bdg-green"><?= L('Semi-final', 'نصف النهائي') ?></span><span>2024–2025</span></div>
            <div class="pal-row2"><span class="bdg bdg-dark">✓ <?= L('Ongoing', 'جارٍ') ?></span><span>2025–2026 — <?= L('current season', 'الموسم الحالي') ?></span></div>
        </div>

        <div class="pal-card2">
            <h3>🌍 <?= L('African competitions — CAF', 'المنافسات القارية') ?></h3>
            <div class="pal-label2"><?= L('African Champions League', 'دوري أبطال أفريقيا') ?></div>
            <div class="pal-row2"><span class="bdg bdg-green"><?= L('Quarter-final', 'ربع النهائي') ?></span><span>2018–2019 · <?= L('3-0 win against Mazembe', 'فوز 3-0 على مازيمبي') ?></span></div>
            <div class="pal-label2" style="margin-top:0.8rem"><?= L('Confederation Cup — CAF 2024–25', 'كأس الكونفيدرالية — 2024–25') ?></div>
            <div class="pal-row2"><span class="bdg bdg-gold">🏆 <?= L('Historic', 'تاريخي') ?></span><span><?= L('Semi-final — a first in club history!', 'نصف النهائي — للمرة الأولى في التاريخ!') ?></span></div>
            <div class="pal-row2"><span class="bdg bdg-green"><?= L('Quarter-final', 'ربع النهائي') ?></span><span><?= L('USM Alger knocked out 4-3 on penalties', 'تخطّى اتحاد الجزائر 4-3 بركلات الترجيح') ?></span></div>
            <div class="pal-stats2">
                <div class="pal-stat2"><span class="num2">14</span><span class="lbl2"><?= L('Matches', 'مباراة') ?></span></div>
                <div class="pal-stat2"><span class="num2">9</span><span class="lbl2"><?= L('Wins', 'انتصار') ?></span></div>
                <div class="pal-stat2"><span class="num2">2</span><span class="lbl2"><?= L('Draws', 'تعادل') ?></span></div>
                <div class="pal-stat2"><span class="num2">3</span><span class="lbl2"><?= L('Losses', 'خسارة') ?></span></div>
            </div>
        </div>

    </div>

    <div class="gold-hl">
        <i class="fas fa-trophy"></i>
        <?= L('Results that speak for themselves — national and continental success worthy of the oldest Algerian club', 'إنجازات تتحدث عن نفسها — تألق محلي وقاري يليق بعميد الأندية الجزائرية') ?>
        <i class="fas fa-trophy"></i>
    </div>
</div>

                            </div><!-- end post-txt -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end main-content -->
