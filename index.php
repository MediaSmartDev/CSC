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
        .actualities{
            height: 280px;
        }
        .t-center{
            text-align: center;
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
            <!--Boucle-->
            <div class="col-lg-4 col-md-6">
                <div class="ng-box">
                    <div class="thumb">
                        <a href="#"><i class="fas fa-link"></i></a>
                        <img style="height: 280px;" src="ressources/2026/statement.jpg" alt="">
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
                        <img style="height: 280px;" src="ressources/2026/statement.jpg" alt="">
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
                        <img style="height: 280px;" src="ressources/2026/statement.jpg" alt="">
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
                        <img style="height: 280px;" src="ressources/2026/statement.jpg" alt="">
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
            <?php
            $data = getFeaturedPlayers();
            foreach ($data as $row){
                $birth = new DateTime($row['date_naissance']);
                $age = $today->diff($birth)->y;
                $content = '<div class="col-md-6">
                                <div class="player-box with-extra-info">
                                    <div class="player-thumb"><img src="'.$row["img"].'" alt="'.$row["img"].'" width="240"></div>
                                    <div class="player-txt">
                                        <h3>'.$row["nom"].' '.$row["prenom"].'</h3>
                                        <br>
                                        <ul class="pb-small-info">
                                            <li>Poste<strong>'.$row["poste"].'</strong></li>
                                            <li>Age <strong>'.$age.' Ans</strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>';
                echo $content;
            }
            ?>
        </div>
      </div>
    </section>
 
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