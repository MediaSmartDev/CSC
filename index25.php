<!doctype html>
<?php
include 'Data/Dbo.php';
?>
<html lang="fr">
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
<!--Rev Slider Start-->
<link rel="stylesheet" href="js/rev-slider/css/settings.css"  type='text/css' media='all' />
<link rel="stylesheet" href="js/rev-slider/css/layers.css"  type='text/css' media='all' />
<link rel="stylesheet" href="js/rev-slider/css/navigation.css"  type='text/css' media='all' />

<!--Rev Slider End-->
<title>Site officiel du CSC - Club Sportif Constantinois</title>
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
        .ar{
            direction: rtl;
            text-align: right;
            font-family: "HelveticaNeue",Helvetica,Arial,sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="wrapper"> 
    <?php require 'header.php';?>
    
  <div class="main-slider">
    <div class="home2-slider rev_slider_wrapper"> 
      <div class="rev_slider_wrapper fullwidthbanner-container">
        <div id="rev-slider2" class="rev_slider fullwidthabanner">
          <ul>
            <li data-transition="fade"> 
                <img src="images/slide4-bg.jpg"  alt="" width="1920" height="750" data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1" >
                <div class="tp-caption  tp-resizeme" 
                              data-x="right" data-hoffset="350" 
                              data-y="top" data-voffset="0" 
                              data-transform_idle="o:1;"         
                              data-transform_in="x:[-75%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;" 
                              data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 
                              data-mask_in="x:[100%];y:0;s:inherit;e:inherit;" 
                              data-splitin="none" 
                              data-splitout="none"
                              data-start="700">
                    <!--<div class="slide-content-box"> <img src="images/slide1-player.png" alt=""> </div>-->
                </div>
                <div class="tp-caption  tp-resizeme" 
                              data-x="right" data-hoffset="850" 
                              data-y="bottom" data-voffset="50" 
                              data-transform_idle="o:1;"         
                              data-transform_in="x:[-75%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;" 
                              data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 
                              data-mask_in="x:[100%];y:0;s:inherit;e:inherit;" 
                              data-splitin="none" 
                              data-splitout="none"
                              data-start="700">
                <div class="slide-content-box"> <img src="images/slide1-football.png" alt=""> </div>
              </div>
                <div class="tp-caption  tp-resizeme" 
                              data-x="left" data-hoffset="400" 
                              data-y="top" data-voffset="205" 
                              data-transform_idle="o:1;"         
                              data-transform_in="x:[-75%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;" 
                              data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 
                              data-mask_in="x:[100%];y:0;s:inherit;e:inherit;" 
                              data-splitin="none" 
                              data-splitout="none"
                              data-start="700">
                <div class="slide-content-box">
<!--                  <h1><span>SAISON 2023/2024</span><br>
                    CLUB SPORTIF CONSTANTINOIS </h1>-->
                </div>
              </div>
                <div class="tp-caption  tp-resizeme" 
                              data-x="left" data-hoffset="400" 
                              data-y="top" data-voffset="430" 
                              data-transform_idle="o:1;"         
                              data-transform_in="x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;" 
                              data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 
                              data-mask_in="x:[100%];y:0;s:inherit;e:inherit;" 
                              data-splitin="none" 
                              data-splitout="none"
                              data-start="700">
                <!--<div class="slide-content-box"> <a href="#">PLUS</a> </div>-->
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="main-content wf100"> 
    <div class="slider-tabs wf100">
      <div class="container">
        <div class="row">
          <ul>
            <li class="col-lg-4">
              <div class="slidetab-box"> <span>#</span>
                <h6><a href="#">Lancement du site web officiel du club</a> </h6>
                <strong>CSC - Club Sportif Constantinois</strong> </div>
            </li>
            <li class="col-lg-4">
              <div class="slidetab-box"> <span>#</span>
                  <h6><a href="joueurs.php">Effectif du CS Constantine de la saison 2025-2026</a></h6>
                <strong>Ligue 1</strong> </div>
            </li>
            <li class="col-lg-4">
              <div class="slidetab-box"> <span>#</span>
                  <h6><a href="resultats.php">Résultat du dernier match </a></h6>
                <strong>LIGUE 1</strong> </div>
            </li>
            
          </ul>
        </div>
      </div>
    </div>
    <section class="wf100 p80">
      <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6"> 
                <div class="next-match-widget">
                    <h5 class="title">Prochain Match</h5>
                    <div class="nmw-wrap">
                        <ul class="match-teams-vs">
                            <li class="team-logo"><img src="images/CSConstantine.png" alt=""> <strong>CS Constantine</strong> </li>
                            <li class="mvs"> <strong class="vs">VS</strong> </li>
                            <li class="team-logo"><img src="images/CSConstantine.png" alt=""> <strong>Equipe <br>X</strong> </li>
                            
                        </ul>
                        <ul class="nmw-txt">
                            <li><strong>Competition </strong></li>
                            <li>A programmer</li>
                            <li>--:--</li>
                            <li><span>Stade Chahid Hamlaoui, CNE</span></li>
                        </ul><br><br><br>
                        <!--<div class="defaultCountdown"></div>-->
                        <div class="buy-ticket"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <!--#1-->
                <div class="next-match-fixtures">
                    <ul class="match-teams-vs">
                        <li class="team-logo"><img src="images/logocsc51.png" alt=""> <strong>CS Constantine</strong> </li>
                        <li class="mvs">
                            <p> <strong>Competition</strong> A programmer
                            <br>--:-- </p>
                            <strong class="vs">VS</strong></li>
                        <li class="team-logo"><img src="images/logo_elbayadh_t2.png" alt=""> <strong>Equipe <br>X</strong> </li>
                    </ul>
                    <ul class="nmf-loc">
                        <li><i class="fas fa-location-arrow"></i>Stade Chahid Hamlaoui, CNE</li>
                    </ul>
                </div>
                
                <div class="next-match-fixtures">
                    <ul class="match-teams-vs">
                        <li class="team-logo"><img src="images/logocsc51.png" alt=""> <strong>Equipe <br>X</strong> </li>
                        <li class="mvs">
                          <p> <strong>Competition</strong> A programmer
                            <br>--:-- </p>
                          <strong class="vs">VS</strong> </li>
                        <li class="team-logo"><img src="images/logocsc51.png" alt=""> <strong>CS Constantine</strong> </li>
                    </ul>
                    <ul class="nmf-loc">
                      <li><i class="fas fa-location-arrow"></i> Stade Benjamin Mkapa, Dar es Salam</li>
                    </ul>
                </div>
                
                <div class="next-match-fixtures">
                    <ul class="match-teams-vs">
                        <li class="team-logo"><img src="ressources/logo/logo_oakbou_t2.png" alt=""> <strong>Equipe <br>X</strong> </li>
                        <li class="mvs">
                          <p> <strong>Competition</strong> A programmer
                            <br>--:-- </p>
                          <strong class="vs">VS</strong> </li>
                        
                        <li class="team-logo"><img src="images/logocsc51.png" alt=""> <strong>CS Constantine</strong> </li>
                    </ul>
                    <ul class="nmf-loc">
                        <li><i class="fas fa-location-arrow"></i>Stade Unité Maghrebine, Bejaia</li>
                    </ul>
                </div>
                

            </div>

        <div class="col-lg-4">
            <div class="point-table-widget">
              <table>
                <thead>
                  <tr>
                    <th> </th>
                    <th>Equipe</th>
                    <th>G</th>
                    <th>N</th>
                    <th>P</th>
                    <th>Pts</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $content = '';
                    $classement = getClassmentTable();
                    foreach ($classement as $row){
                        $content .= '<tr>
                                    <td>'.$row["position"].'</td>
                                    <td><img src="'.$row["logo"].'" alt="'.$row["club"].'" style="height:24px;"> <strong>'.$row["club"].'</strong></td>
                                    <td>'.$row["g"].'</td>
                                    <td>'.$row["n"].'</td>
                                    <td>'.$row["p"].'</td>
                                    <td><strong>'.$row["points"].'</strong></td>
                                  </tr>';
                    }
                    echo $content;
                    ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!--<div class="banner-wrap text-center wf100 mb-80"> <img src="images/placeyourbanner.png" alt=""> </div>-->

    <section class="wf100 p80 sports-news">
      <div class="container">
        <div class="row">
            <div class="col-md-12">
              <div class="section-title">
                <h2>Actualités du CSC</h2>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"> 
                <div class="news-list-post">
                    <div class="post-thumb"> <a href="https://www.facebook.com/photo/?fbid=753849450507221&set=pb.100076465170925.-2207520000"><i class="fas fa-link"></i></a> <img src="ressources/2026/statement.jpg" alt=""></div>
                    <div class="post-txt">
                        <ul class="post-author">
                            <li><i class="fas fa-bookmark"></i> <strong>EQUIPE PREMIERE</strong></li>
                            <li class="share"><i class="fas fa-share-alt"></i></li> 
                        </ul>
                        <h4><a href="#">Communiqué explicatif de la direction du Club Sportif Constantinois</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 27 Juin 2025</li>
                        </ul>

                        <p class="ar">
    تبعًا لما تم تداوله في الساعات الأخيرة بخصوص قضية اللاعب <strong>النيجيري سامسون دار قباديبو</strong>، وفي وقت حساس يتزامن مع الاستعدادات للموسم الرياضي الجديد، تود إدارة الشركة الرياضية ذات الأسهم للنادي الرياضي القسنطيني أن توضح للرأي العام الحقائق التالية، وذلك إيمانًا منها بمبدأ الشفافية وحرصًا على قطع الطريق أمام كل أشكال التأويل والتضليل: (نظرا لحساسية الموضوع سيتم ذكر بعض التفاصيل الدقيقة)
  </p>

  <ol class="ar">
    <li>تنفي إدارة النادي بشكل قاطع وجود أي علاقة تعاقدية باللاعب المعني (عدم امضاء أي عقد بين الطرفين).</li>
    <li>باقتراح من المدرب السابق للنادي السيد عمراني تم استدعاء اللاعب للقدوم الى الجزائر.</li>
    <li>تمت دعوة اللاعب للقدوم للجزائر وتم انتظاره حتى آخر يوم من فترة التسجيلات الصيفية للتعاقد معه والدليل أن الفريق استعمل إلا أربعة اجازات أجنبية من أصل خمسة.</li>
    <li>تقدم اللاعب بشكوى ضد النادي أمام الهيئات المختصة لدى الاتحاد الدولي لكرة القدم (فيفا)، مطالبًا بمستحقات مزعومة لا أساس قانوني لها.</li>
    <li>الهيئة القانونية للفيفا، وفي مرحلة أولى، اعتمدت على هذه النقطة الشكلية للنظر في الشكوى المرفوعة، دون التحقق العميق من الخلفيات القانونية التي تثبت أن اللاعب لا يمت بأي صلة رسمية بالنادي.</li>
    <li>وبالموازاة مع ذلك، قامت المصالح القانونية للشركة باتخاذ كافة الإجراءات القانونية اللازمة لتعليق تنفيذ هذا القرار الجائر، والعمل جاري من أجل نقضه وفق الطرق القانونية المعمول بها.</li>
    <li>تستغرب إدارة النادي التوقيت المريب لتسريب مثل هكذا قرار القابل للطعن، في وقت لا يزال فيه الملف محل دراسة قانونية وعدم استنفاذه طرق الطعن المتاحة، مما يثير الشكوك حول خلفيات وأهداف هذا التسريب، ويعكس محاولات يائسة للتشويش على عمل الإدارة، وزرع البلبلة وسط الجماهير الوفية.</li>
    <li>وإذ تؤكد الشركة أن مثل هذه القضايا أصبحت ظاهرة معروفة في مختلف البطولات، أبطالها بعض اللاعبين، وكلاؤهم وبعض المدربين ممن يسعون إلى الربح السريع بأساليب مشبوهة، فإنها تُجدد التزامها بالدفاع عن حقوقها ومصالح النادي بكل الوسائل القانونية المتاحة، كما تحتفظ بحقها في متابعة كل من تسول له نفسه المساس بسمعة وكرامة النادي ومكوناته.</li>
    <li> وختامًا، تطمئن، تؤكد وتلتزم إدارة الشركة الرياضية للنادي الرياضي القسنطيني أمام كافة أنصار النادي الأوفياء، أن هذه القضية سيتم الفصل فيها نهائيًا لصالح النادي، وستتخذ الشركة كافة التدابير اللازمة لحماية النادي من أي استهداف داخلي أو خارجي، بما يضمن له الاستقرار المطلوب لإنجاح مشروعه الرياضي للموسم 2025-2026 وسوف تقوم بانتدابات وتأهيل اللاعبين بصفة عادية جدا.</li>
  </ol>
                    </div>
                </div>
            </div>
        </div>

          
        <div class="row">
            <!--Boucle-->
            <div class="col-lg-4 col-md-6">
                <div class="ng-box">
                    <div class="thumb">
                        <a href="#"><i class="fas fa-link"></i></a>
                        <img src="images/ng-img1.jpg" alt="">
                    </div>
                    <div class="ng-txt">
                        <h4><a href="#">Communiqué explicatif de la direction du Club Sportif Constantinois</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 27 Nov, 2025</li>
                            <li><i class="far fa-comment"></i> EQUIPE PREMIERE</li>
                        </ul>
                        <p> Deserunt Sunt in culpa qui officia mollit anim id est laborn Neque porro quisquam est, qui dolorem ipsum. </p>
                        <a href="#" class="rm">Voir plus</a> 
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="ng-box">
                    <div class="thumb">
                        <a href="#"><i class="fas fa-link"></i></a>
                        <img src="images/ng-img1.jpg" alt="">
                    </div>
                    <div class="ng-txt">
                        <h4><a href="#">Communiqué explicatif de la direction du Club Sportif Constantinois</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 27 Nov, 2025</li>
                            <li><i class="far fa-comment"></i> EQUIPE PREMIERE</li>
                        </ul>
                        <p> Deserunt Sunt in culpa qui officia mollit anim id est laborn Neque porro quisquam est, qui dolorem ipsum. </p>
                        <a href="#" class="rm">Voir plus</a> 
                    </div>
                </div>
            </div>  
            <div class="col-lg-4 col-md-6">
                <div class="ng-box">
                    <div class="thumb">
                        <a href="#"><i class="fas fa-link"></i></a>
                        <img src="images/ng-img1.jpg" alt="">
                    </div>
                    <div class="ng-txt">
                        <h4><a href="#">Communiqué explicatif de la direction du Club Sportif Constantinois</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 27 Nov, 2025</li>
                            <li><i class="far fa-comment"></i> EQUIPE PREMIERE</li>
                        </ul>
                        <p> Deserunt Sunt in culpa qui officia mollit anim id est laborn Neque porro quisquam est, qui dolorem ipsum. </p>
                        <a href="#" class="rm">Voir plus</a> 
                    </div>
                </div>
            </div>  
            <div class="col-lg-4 col-md-6">
                <div class="ng-box">
                    <div class="thumb">
                        <a href="#"><i class="fas fa-link"></i></a>
                        <img src="images/ng-img1.jpg" alt="">
                    </div>
                    <div class="ng-txt">
                        <h4><a href="#">Communiqué explicatif de la direction du Club Sportif Constantinois</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 27 Nov, 2025</li>
                            <li><i class="far fa-comment"></i> EQUIPE PREMIERE</li>
                        </ul>
                        <p> Deserunt Sunt in culpa qui officia mollit anim id est laborn Neque porro quisquam est, qui dolorem ipsum. </p>
                        <a href="#" class="rm">Voir plus</a> 
                    </div>
                </div>
            </div>  
        </div>      
    </section>
    <!--News & Media Gallery End--> 
    <!--Team Squad Start--> 
    <section class="team-squad wf100 p80-50">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-title white">
                <h2>Joueurs</h2>
                <a class="full-team" href="joueurs.php">Voir toute l'équipe</a> </div>
          </div>
        </div>
        <div class="row">
            
            <div class="col-md-6">
                <div class="player-box with-extra-info">
                    <div class="player-thumb"><img src="ressources/BRAHIM_DIB.jpg" alt="DIB Brahim" width="240"></div>
                    <div class="player-txt">
                        <h3>DIB Brahim</h3>
                        <br>
                        <ul class="pb-small-info">
                            <li>Poste<strong>Attaquant</strong></li>
                            <li>Age <strong>30 Ans</strong></li>
                            <li>Taille<strong>181 Cm</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="player-box with-extra-info">
                    <div class="player-thumb"><img src="ressources/ACHRAF_BOUDRAMA.jpg" alt="ACHRAF BOUDRAMA" width="240"></div>
                    <div class="player-txt">
                        <h3>BOUDRAMA Achraf</h3><br>
                        <ul class="pb-small-info">
                            <li>Poste<strong>Défenseur</strong></li>
                            <li>Age <strong>28 Ans</strong></li>
                            <!--<li>Taille<strong>167 Cm</strong></li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="player-box with-extra-info">
                    <div class="player-thumb"><img src="ressources/MESSALA_MERBAH.jpg" alt="MESSALA MERBAH" width="240"></div>
                    <div class="player-txt">
                        <h3>MERBAH Messala</h3><br>
                        <ul class="pb-small-info">
                            <li>Poste<strong>Milieu Défensif</strong></li>
                            <li>Age <strong>30 Ans</strong></li>
                            <!--<li>Taille<strong>167 Cm</strong></li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="player-box with-extra-info">
                    <div class="player-thumb"><img src="ressources/KHEIREDDINE_MADOUI.jpg" alt="KHEIREDDINE MADOUI" width="240"></div>
                    <div class="player-txt">
                        <h3>MADOUI Kheir eddine</h3><br>
                        <ul class="pb-small-info">
                            <li>Poste<strong>Entraineur</strong></li>
                            <li>Age <strong>48 Ans</strong></li>
                            <!--<li>Taille<strong>192 Cm</strong></li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
    <!--Team Squad End-->
  
 
  <section class="wf100 p80 players-squad portfolio filter-gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="static-pagetitle">
                  <h2>Site officiel du CSC - Club Sportif Constantinois</h2>
                </div>
            </div>
        </div>
    </div>
  </section>
 
  <!--League Players Squad End--> 
  
    <section class="team-squad wf100 p80-50">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title white">
                        <h2>PARTENAIRES PRINCIPAUX DU CLUB</h2>
                        <!--<a class="full-team" href="#">Voir tous les Partenaires</a>--> 
                    </div>
                </div>
            </div>
            <div class="row">
                <ul class="row">
                    <li class="col-md-3"> <a href="#"><img src="images/soummam.png" style="width: 200px;" alt=""></a> </li>
                    <li class="col-md-3"> <a href="#"><img src="images/Logo_entp.png" style="width: 200px;" alt="" style="width: 60%;"></a> </li>  
                    <li class="col-md-3"> <a href="#"><img src="images/kcs.png" alt="" style="width:  200px;"></a> </li>
                    <li class="col-md-3"> <a href="#"><img src="images/gymone.png" alt="" style="width:  200px;"></a> </li>
                </ul>
            </div>
        </div>
    </section>
</div>
<!--Main Content End--> 
<?php require 'footer.php';?>
</div>
<!--Wrapper End--> 



<!-- Optional JavaScript --> 
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
<!--Rev Slider Start--> 
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
</body>
</html>