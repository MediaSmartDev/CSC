<?php require_once __DIR__ . '/Data/lang.php'; ?>
<!doctype html>
<html lang="<?= $LANG ?>" dir="<?= $DIR ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="images/fav.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/prettyPhoto.css">
    <link rel="stylesheet" href="css/audioplayer.css">
    <title><?= L('Identité - CS Constantine', 'الهوية - النادي الرياضي القسنطيني') ?></title>
    <style type="text/css">
        .static-pagetitle {
            background: linear-gradient(145deg,#0f830a 0,#020e01);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            color: #fff;
        }
        .static-pagetitle {
            text-align: center;
            margin: 30px !important;
            font-weight: bold !important; 
        }
        .news-large-post{
            background: url(images/pagebg3.jpg) no-repeat;
        }
    </style>
</head>
<body>
    <!--Wrapper Start-->
    <div class="wrapper">
        <?php require 'header.php';?>
       
      <!--Main Slider Start-->
        <div class="inner-banner-header wf100">
          <h1 data-generated="<?= L('Identité', 'الهوية') ?>"><?= L('Identité', 'الهوية') ?></h1>
          <div class="gt-breadcrumbs">
            <ul>
              <li> <a href="index.php" class="active"> <i class="fas fa-home"></i> <?= L('Accueil', 'الرئيسية') ?> </a> </li>
              <li> <a href="#"> <?= L('CLUB', 'النادي') ?> </a> </li>
              <li> <a href="#"> <?= L('Identité', 'الهوية') ?> </a> </li>
            </ul>
          </div>
        </div>

        <div class="main-content innerpagebg wf100 p80">
            <div class="news-details">
              <div class="container">
                <div class="row">
                    <!--News Start-->
                    <div class="col-lg-12">
                        <div class="news-details-wrap">
                            <div class="news-large-post">
                                <!--<div class="post-thumb"> <img src="images/nlarge2.jpg" alt=""></div>-->
                                <div class="post-txt">
<?php if ($LANG === 'ar'): ?>
                                    <h1 class="static-pagetitle">الألوان وتطور الشعار</h1>
                                    <p style="text-align: justify;">الألوان الرئيسية للنادي هي الأخضر والأسود؛ يرمز الأخضر إلى الأمل ويرمز الأسود إلى الحداد (الأمل في الحداد).
ويحمل شعار النادي ثلاثة أحرف رمزية تمثل الاسم المختصر للنادي الرياضي القسنطيني.</p>
                                    <blockquote style="text-align: center;">
                                      <p>1898 هو تاريخ تأسيس "إقبال التحرر".</p>
                                    </blockquote>
                                    <img src="images/blason_evol.jpg" alt="">
                                    <h2 style="text-align: justify;margin-bottom: 1.1rem;">رمزية النسر</h2>
                                    <p style="text-align: justify;">يُتخذ رمز النسر علامةً للانتماء على لافتات الأنصار، كما يظهر على شعار النادي. ويرمز في مخيال النادي وأنصاره إلى القوة والرجولة. ومن التقاليد الرياضية للنادي إحضار مجسّم لنسر عملاق إلى الملعب، مطليّ بألوان النادي الأخضر والأسود، خلال المباريات التي يخوضها الفريق. وكان بمثابة تميمة حظ للنادي، إذ كان حضوره في الملعب يُلهب حماس الجماهير، خاصة خلال موسم 1993-94 حين فاز النادي على غريمه "مولودية قسنطينة" بنتيجة لا تقبل الجدل 3-0، ليُنهي الموسم بطلاً للرابطة الثانية ويصعد بذلك إلى الرابطة الأولى. وتُعرف مدينة قسنطينة عادةً بـ«مدينة النسور» أو «عش النسر».</p>
                                    <h2 style="text-align: justify;margin-bottom: 1.1rem;">التميمة</h2>
                                    <p style="text-align: justify;">في موسم 2017-18، أصبحت تميمة النادي "سنفوراً" يرتدي ألوان النادي الأخضر والأسود (لباس أخضر مع قبعة، وسروال وحذاء وجوارب طويلة سوداء)، ويحمل أيضاً شعار النادي والأحرف الثلاثة للاسم المختصر للنادي باللون الأخضر على السروال.
وقد فرض نفسه كأحد رموز النادي وأنصاره الذين يُلقَّبون بـ"السنافر".</p>
<?php else: ?>
                                    <h1 class="static-pagetitle">Couleurs et évolutions du blason</h1>
                                    <p style="text-align: justify;">Les couleurs principales du club sont le Vert et le Noir, le vert symbolise l'espérance et le noir symbolise le deuil (L’espérance en deuil).
Sur les blasons du club figure les trois lettres symbolique CSC, indiquent le nom abrégé du club Club Sportif Constantinois.</p>
                                    <!--<ul class="post-meta">
                                      <li><i class="fas fa-user"></i> Phillips Hunt</li>
                                      <li><i class="fas fa-calendar-alt"></i> 27 June, 2020</li>
                                      <li><i class="far fa-comment"></i> 89 Comments</li>
                                      <li><i class="far fa-heart"></i> 52 Likes</li>
                                    </ul>-->
                                    <blockquote style="text-align: center;">
                                      <p>1898 est la date de fondation du l'Ikbal Emancipation.</p>
                                    </blockquote>
                                    <img src="images/blason_evol.jpg" alt="">
                                    <!--<ul class="small-gallery">
                                        <li><img src="images/blason_evol.jpg" alt=""></li>
                                    </ul>-->
                                    <h2 style="text-align: justify;margin-bottom: 1.1rem;">La symbolique de l'aigle</h2>
                                    <p style="text-align: justify;">Le symbole de l'aigle est repris comme signe d'appartenance sur les banderoles des supporters, il existe aussi sur le blason du club. Il symbolise dans l'imaginaire du club et de ses supporters, la force et la virilité. Une des traditions sportives du club, c'est d'apporter au stade, une sculpture d'un aigle géant, peint aux couleurs du club verts et noir lors des matches disputés par le club. Il faisait office de porte bonheur pour le club qui par sa présence au stade, galvanise les foules notamment durant la saison : 1993-94 ou il remporte le match disputé avec son rival ‘’le MOC’’ par un score sans appel de 3-0 et qui finira la saison comme champion de la ligue 2 et se voit accéder ainsi en ligue 1. La ville de Constantine est communément appelée « la ville des aigles » ou bien « le nid d'aigle ».</p>
                                    <h2 style="text-align: justify;margin-bottom: 1.1rem;">Mascotte</h2>
                                    <p style="text-align: justify;">La saison 2017-18, la mascotte du club est un Schtroumpf qui porte les couleurs du club de Vert et Noir (vêtue du vert avec un bonnet et d'un pantalon, chaussure et chaussettes montantes noirs), il porte aussi le logo du club et les trois lettres CSC (le nom abrégé du club) en vert sur le pantalon.
Il s'impose comme l'un des emblèmes du club et des supporters qui sont appelés les Sanafers ou Sanafirs littéralement en arabe les Schtroumpfs.
</p>
<?php endif; ?>
                                  </div>
                                
                            </div>
                        </div>
                    </div>
                    <!--News End--> 
                  
                </div>
              </div>
            </div>  
        </div>
        <?php require 'footer.php';?>
      
      <!--Main Footer End--> 
    </div>
    <!--Wrapper End--> 
    <!-- Optional JavaScript --> 
    <script src="js/jquery-3.3.1.min.js"></script> 
    <script src="js/jquery-migrate-3.0.1.js"></script> 
    <script src="js/popper.min.js"></script> 
    <script src="js/bootstrap.min.js"></script> 
<script src="js/mobile-nav.js"></script>  
    <script src="js/owl.carousel.min.js"></script> 
    <script src="js/jquery.prettyPhoto.js"></script> 
    <script src="js/jquery.countdown.js"></script> 
    <script src="js/audioplayer.min.js"></script> 
    <script src="js/custom.js"></script>
  </body>
</html>