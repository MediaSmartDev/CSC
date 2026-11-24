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
    <title><?= L('Identity - CS Constantine', 'الهوية - النادي الرياضي القسنطيني') ?></title>
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
          <h1 data-generated="<?= L('Identity', 'الهوية') ?>"><?= L('Identity', 'الهوية') ?></h1>
          <div class="gt-breadcrumbs">
            <ul>
              <li> <a href="index.php" class="active"> <i class="fas fa-home"></i> <?= L('Home', 'الرئيسية') ?> </a> </li>
              <li> <a href="#"> <?= L('CLUB', 'النادي') ?> </a> </li>
              <li> <a href="#"> <?= L('Identity', 'الهوية') ?> </a> </li>
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
                                    <h1 class="static-pagetitle">Colours and the history of the crest</h1>
                                    <p style="text-align: justify;">The club's main colours are green and black: green stands for hope and black for mourning ("hope in mourning").
The club's crests carry the three symbolic letters CSC, the short name of Club Sportif Constantinois.</p>
                                    <!--<ul class="post-meta">
                                      <li><i class="fas fa-user"></i> Phillips Hunt</li>
                                      <li><i class="fas fa-calendar-alt"></i> 27 June, 2020</li>
                                      <li><i class="far fa-comment"></i> 89 Comments</li>
                                      <li><i class="far fa-heart"></i> 52 Likes</li>
                                    </ul>-->
                                    <blockquote style="text-align: center;">
                                      <p>1898 is the year Ikbal Emancipation was founded.</p>
                                    </blockquote>
                                    <img src="images/blason_evol.jpg" alt="">
                                    <!--<ul class="small-gallery">
                                        <li><img src="images/blason_evol.jpg" alt=""></li>
                                    </ul>-->
                                    <h2 style="text-align: justify;margin-bottom: 1.1rem;">The eagle</h2>
                                    <p style="text-align: justify;">The eagle is used as a sign of belonging on the supporters' banners, and it also appears on the club crest. For the club and its fans, it stands for strength and courage. One of the club's sporting traditions is to bring a giant eagle sculpture, painted in the club's green and black, to the stadium on match days. It served as a lucky charm and, by being there, fired up the crowds, especially in the 1993-94 season, when the club beat its rival "MOC" 3-0, then finished the season as Ligue 2 champions and was promoted to Ligue 1. The city of Constantine is often called "the city of eagles" or "the eagle's nest".</p>
                                    <h2 style="text-align: justify;margin-bottom: 1.1rem;">Mascot</h2>
                                    <p style="text-align: justify;">Since the 2017-18 season, the club's mascot has been a Smurf wearing the club's green and black (green top with a hat, black trousers, shoes and long socks). It also wears the club logo and the three letters CSC (the club's short name) in green on the trousers.
It has become one of the emblems of the club and of its supporters, who are called the Sanafers or Sanafirs, literally "the Smurfs" in Arabic.
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