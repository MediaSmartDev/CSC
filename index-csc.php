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
            text-align: right;
            font-family: "HelveticaNeue",Helvetica,Arial,sans-serif;
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
                <img src="images/slide1-bg.png"  alt="" width="1920" height="750" data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1" >
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
                              data-y="bottom" data-voffset="100" 
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
                  <h1><span>SAISON 2021/2022</span><br>
                    CLUB SPORTIF CONSTANTINOIS </h1>
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
                  <h6><a href="joueurs.php">Effectif du CS Constantine de la saison 2021-2022</a></h6>
                <strong>Ligue 1</strong> </div>
            </li>
            <li class="col-lg-4">
              <div class="slidetab-box"> <span>#</span>
                  <h6><a href="https://www.facebook.com/csconstantine.official" target="blank">Lancement de la page facebook officielle </a></h6>
                <strong>CSC - Club Sportif Constantinois</strong> </div>
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
                            <li class="team-logo"><img src="images/logocsc51.png" alt=""> <strong>CS <br>Constantine</strong> </li>
                            <li class="mvs"> <strong class="vs">VS</strong> </li>
                            <li class="team-logo"><img src="ressources/logo_nahd_t2.png" alt=""> <strong>NA Hussein Dey</strong> </li>
                        </ul>
                        <ul class="nmw-txt">
                            <li><strong>Championnat d'Algérie de football Ligue 1 </strong></li>
                            <li>Mardi 28 Dec 2021</li>
                            <li>14:30</li>
                            <li><span>Stade Benabdelmalek Ramdane, CNE</span></li>
                        </ul><br><br><br>
                        <!--<div class="defaultCountdown"></div>-->
                        <div class="buy-ticket"></div>
                    </div>
                </div>
            </div>
          <div class="col-lg-4 col-md-6"> 
            
<!--            <div class="next-match-fixtures">
              <ul class="match-teams-vs">
                <li class="team-logo"><img src="images/logocsc51.png" alt=""> <strong>CS Constantine</strong> </li>
                <li class="mvs">
                  <p> <strong>Ligue 1</strong> Mar 28 Dec 2021<br>
                    A DEFINIR </p>
                  <strong class="vs">VS</strong> </li>
                <li class="team-logo"><img src="ressources/logo_nahd_t2.png" alt=""> <strong>NA Hussein Dey</strong> </li>
              </ul>
              <ul class="nmf-loc">
                <li><i class="fas fa-location-arrow"></i> Stade Benabdelmalek Ramdane, CNE</li>
              </ul>
            </div>-->

            <div class="next-match-fixtures">
                <ul class="match-teams-vs">
                    <li class="team-logo"><img src="ressources/logo_rca_t2.png" alt=""> <strong>RC Arbaa</strong> </li>
                    <li class="mvs">
                        <p> <strong>Ligue 1</strong> Sam 01 Jan 2022<br>
                        A DEFINIR </p>
                      <strong class="vs">VS</strong> </li>
                    <li class="team-logo"><img src="images/logocsc51.png" alt=""> <strong>CS Constantine</strong> </li>
                </ul>
                <ul class="nmf-loc">
                    <li><i class="fas fa-location-arrow"></i>Stade Ismaïl Makhlouf, Larbâa</li>
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
                    <div class="post-thumb"> <a href="#"><i class="fas fa-link"></i></a> <img src="ressources/photo_27122021.jpg" alt=""></div>
                    <div class="post-txt">
                        <ul class="post-author">
                            <li><i class="fas fa-bookmark"></i> <strong>EQUIPE PREMIERE</strong></li>
                            <li class="share"><i class="fas fa-share-alt"></i></li> 
                        </ul>
                        <h4 class="ar"><a href="#">تنصيب خلية الاعلام والاتصال</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 27 Decembre 2021</li>
                        </ul>
                        <p class="ar" style="font-size: 20px;">يسر إدارة النادي الرياضي القسنطيني أن تعلم كافة مناصريها بأنه تم اليوم الإثنين تنصيب خلية الاعلام والاتصال التي ستعمل على موافاتكم بكل ما يتعلق بأخبار الفريق. ويأتي هذا الاجراء في إطار الاستراتيجية الرامية الى تدعيم الهيكلة الإدارية بخبرات في ميدان الاعلام.
</p>
<p class="ar" style="font-size: 20px;text-align: left;">دمتم أوفياء للنادي الرياضي القسنطيني </p>

                    </div>
                </div>
            </div>
            
            <div class="col-lg-12"> 
                <div class="news-list-post">
                    <div class="post-thumb"> <a href="#"><i class="fas fa-link"></i></a> <img src="ressources/fr_communique_27122021.jpg" alt=""></div>
                    <div class="post-txt">
                        <ul class="post-author">
                            <li><i class="fas fa-bookmark"></i> <strong>EQUIPE RESERVE</strong></li>
                            <li class="share"><i class="fas fa-share-alt"></i></li> 
                        </ul>
                        <h4><a href="#">Accès des supporteurs aux matchs des réserves</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 27 Decembre 2021</li>
                        </ul>
                        <!--<p class="ar"></p>-->
                    </div>
                </div>
            </div>
            <div class="col-lg-12"> 
                <div class="news-list-post">
                    <div class="post-thumb"> <a href="#"><i class="fas fa-link"></i></a> <img src="ressources/fr_communique_26122021.jpg" alt=""></div>
                    <div class="post-txt">
                        <ul class="post-author">
                            <li><i class="fas fa-bookmark"></i> <strong>EQUIPE PREMIERE</strong></li>
                            <li class="share"><i class="fas fa-share-alt"></i></li> 
                        </ul>
                        <h4><a href="#">CS Constantine - NA Hussein Dey : Début de la vente des billets ce lundi a 08:00</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 26 Decembre 2021</li>
                        </ul>
                        <!--<p class="ar"></p>-->
                    </div>
                </div>
            </div>
            <div class="col-lg-12"> 
                <div class="news-list-post">
                    <div class="post-thumb"> <a href="#"><i class="fas fa-link"></i></a> <img src="ressources/condoleance_25122021.jpg" alt=""></div>
                    <div class="post-txt">
                        <ul class="post-author">
                            <li><i class="fas fa-bookmark"></i> <strong>CONDOLEANCE</strong></li>
                            <li class="share"><i class="fas fa-share-alt"></i></li> 
                        </ul>
                        <h4><a href="#">Décès du joueur du MC Saïda Sofiane Loukar</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 25 Decembre 2021</li>
                        </ul>
                        <!--<p class="ar"></p>-->
                    </div>
                </div>
            </div>
            <div class="col-lg-12"> 
                <div class="news-list-post">
                    <div class="post-thumb"> <a href="#"><i class="fas fa-link"></i></a> <img src="ressources/fr_communique_15122021.jpg" alt=""></div>
                    <div class="post-txt">
                        <ul class="post-author">
                            <li><i class="fas fa-bookmark"></i> <strong>EQUIPE PREMIERE</strong></li>
                            <li class="share"><i class="fas fa-share-alt"></i></li> 
                        </ul>
                        <h4><a href="#">CS Constantine - O Médéa : Début de la vente des billets ce mercredi a 15:00</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 15 Decembre 2021</li>
                        </ul>
                        <!--<p class="ar"></p>-->
                    </div>
                </div>
            </div>
            <div class="col-lg-12"> 
                <div class="news-list-post">
                    <div class="post-thumb"> <a href="#"><i class="fas fa-link"></i></a> <img src="ressources/rencontre_pdg_entp.jpg" alt=""></div>
                    <div class="post-txt">
                        <ul class="post-author">
                            <li><i class="fas fa-bookmark"></i> <strong>EQUIPE PREMIERE</strong></li>
                            <li class="share"><i class="fas fa-share-alt"></i></li> 
                        </ul>
                        <h4><a href="#">Rencontre avec le Président Directeur Général de l'ENTP</a></h4>
                        <ul class="post-meta">
                            <li><i class="fas fa-calendar-alt"></i> 12 Decembre 2021</li>
                        </ul>
                        <p class="ar">صورة للذكرى رفقة الرئيس المدير العام للمؤسسة الوطنية للأشغال في الآبار بمناسبة تنصيبه و الذي أعطى خلال هذا اللقاء توجيهات بتوفير كل الإمكانيات المتاحة لنيل الألقاب وحث على تضافر الجهود لرؤية العميد في مكانه الأصلي وحصد كل الألقاب، القادم أفضل بحول الله يحيا الفريق العريق النادي الرياضي القسنطيني</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12"> 
                <div class="news-list-post">
                  <div class="post-thumb"> <a href="#"><i class="fas fa-link"></i></a> <img src="ressources/lancement_site.jpg" alt=""></div>
                  <div class="post-txt">
                    <ul class="post-author">
                      <li><i class="fas fa-bookmark"></i> <strong>EQUIPE PREMIERE</strong></li>
                      <li class="share"><i class="fas fa-share-alt"></i></li> 
                    </ul>
                    <h4><a href="#">Lancement du site web officiel du CSC</a></h4>
                    <ul class="post-meta">
                      <li><i class="fas fa-calendar-alt"></i> 08 Decembre 2021</li>
                    </ul>
                    <p>Le Club Sportif Constantinois a le plaisir d'annoncer le lancement de son site web officiel.</p>
                    <a href="#" class="rm">Voir Plus</a> </div>
                </div>
                <!--News Box Start
                <div class="news-list-post">
                  <div class="post-thumb"> <a href="#"><i class="fas fa-link"></i></a> <img src="images/news-media-img2.jpg" alt=""></div>
                  <div class="post-txt">
                    <ul class="post-author">
                      <li><i class="fas fa-bookmark"></i> <strong>EQUIPE PREMIERE</strong></li>
                      <li class="share"><i class="fas fa-share-alt"></i></li>
                    </ul>
                    <h4><a href="#">Mercato : Marcellin Koukpo rejoint le CS Constantine</a></h4>
                    <ul class="post-meta">
                      <li><i class="fas fa-calendar-alt"></i> 07 Octobre 2021</li>
                    </ul>
                    <p>L’avant-centre béninois, Marcellin Koukpo, a décidé de continuer son aventure au sein du championnat algérien en rejoignant, cette semaine, le CS Constantine.</p>
                    <a href="#" class="rm">Voir Plus</a> </div>
                </div>-->
            </div>
            
      </div>
        <!--<div class="videonews wf100">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div id="videonews-slider" class="owl-carousel owl-theme"> 

                  <div class="hvideo-box"> <span class="vtime">02:10</span> <img src="images/vid-01.jpg" alt="">
                    <div class="hv-info gallery"> <a href="../../../vimeo.com/46882189.html" data-rel="prettyPhoto[]" class="play"><i class="fas fa-play"></i></a>
                      <h4><a href="#" >Nicolson Goals are like Storm</a></h4>
                    </div>
                  </div>

                  <div class="hvideo-box"> <span class="vtime">02:10</span> <img src="images/vid-02.jpg" alt="">
                    <div class="hv-info"> <a href="#" class="play"><i class="fas fa-play"></i></a>
                      <h4><a href="#">Opportunities at Ciclista al Pais Vasco</a></h4>
                    </div>
                  </div>

                  <div class="hvideo-box"> <span class="vtime">02:10</span> <img src="images/vid-03.jpg" alt="">
                    <div class="hv-info"> <a href="#" class="play"><i class="fas fa-play"></i></a>
                      <h4><a href="#">Top Head LIaVettel beats Hamilton</a></h4>
                    </div>
                  </div>

                  <div class="hvideo-box"> <span class="vtime">02:10</span> <img src="images/vid-01.jpg" alt="">
                    <div class="hv-info"> <a href="#" class="play"><i class="fas fa-play"></i></a>
                      <h4><a href="#">Nicolson Goals are like Storm</a></h4>
                    </div>
                  </div>

                  <div class="hvideo-box"> <span class="vtime">02:10</span> <img src="images/vid-02.jpg" alt="">
                    <div class="hv-info"> <a href="#" class="play"><i class="fas fa-play"></i></a>
                      <h4><a href="#">Opportunities at Ciclista al Pais Vasco</a></h4>
                    </div>
                  </div>

                  <div class="hvideo-box"> <span class="vtime">02:10</span> <img src="images/vid-03.jpg" alt="">
                    <div class="hv-info"> <a href="#" class="play"><i class="fas fa-play"></i></a>
                      <h4><a href="#">Top Head LIaVettel beats Hamilton</a></h4>
                    </div>
                  </div>

                  <div class="hvideo-box"> <span class="vtime">02:10</span> <img src="images/vid-01.jpg" alt="">
                    <div class="hv-info"> <a href="#" class="play"><i class="fas fa-play"></i></a>
                      <h4><a href="#">Nicolson Goals are like Storm</a></h4>
                    </div>
                  </div>

                  <div class="hvideo-box"> <span class="vtime">02:10</span> <img src="images/vid-02.jpg" alt="">
                    <div class="hv-info"> <a href="#" class="play"><i class="fas fa-play"></i></a>
                      <h4><a href="#">Opportunities at Ciclista al Pais Vasco</a></h4>
                    </div>
                  </div>

                  <div class="hvideo-box"> <span class="vtime">02:10</span> <img src="images/vid-03.jpg" alt="">
                    <div class="hv-info"> <a href="#" class="play"><i class="fas fa-play"></i></a>
                      <h4><a href="#">Top Head LIaVettel beats Hamilton</a></h4>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>--> 
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
                    <div class="player-thumb"><img src="ressources/RAHMANI.jpg" alt="RAHMANI CHEMESSDINNE" width="240"></div>
                    <div class="player-txt">
                        <h3>RAHMANI CHEMESSDINNE</h3><br>
                        <ul class="pb-small-info">
                            <li>Poste<strong>GARDIEN DE BUT</strong></li>
                            <li>Age <strong>31 Ans</strong></li>
                            <li>Taille<strong>189.8 Cm</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="player-box with-extra-info">
                    <div class="player-thumb"><img src="ressources/CHAKAL.jpg" alt="CHAKAL AFFARI BALHADJ" width="240"></div>
                    <div class="player-txt">
                        <h3>CHAKAL AFFARI BALHADJ</h3>
                        <br>
                        <ul class="pb-small-info">
                            <li>Poste<strong>MILIEU DE TERRAIN</strong></li>
                            <li>Age <strong>18 Ans</strong></li>
                            <li>Taille<strong>179,4 Cm</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
    <!--Team Squad End-->
  
  <!--Tweets + Banner Start
  <section class="tweets-banner wf100">
    <div class="container">
        <div class="row">
        <div class="col-md-12"><div class="section-title white">
              <h2>Joueurs</h2>
            </div></div>
        </div>    
          
          <ul class="row">
            <li class="col-md-4">
              <div class="tweet-box"> <a href="#" class="tshare"><i class="fas fa-share"></i></a>
                <h5>Ben Roots</h5>
                <p> Cras in velit lacus. Maecenas sodales dui id libero scelerisque elementum. Fusce lacinia egestas maximus. Alqua erat volutpat fusce ac lacinia </p>
                <div class="tw-foot"> @ben.roots<br>
                  03 April, 2020 <i class="fab fa-twitter"></i> </div>
              </div>
            </li>
            <li class="col-md-4">
              <div class="tweet-box active"> <a href="#" class="tshare"><i class="fas fa-share"></i></a>
                <h5>Jack Denly</h5>
                <p> Orci varius natoque penatibus et magnis dis parturient montes, nasce ridiculus mus. Quisque non nunc ac ex faucibus dignissim aliquet eget </p>
                <div class="tw-foot"> @jack.denly<br>
                  03 April, 2020 <i class="fab fa-twitter"></i> </div>
              </div>
            </li>
            <li class="col-md-4">
              <div class="tweet-box"> <a href="#" class="tshare"><i class="fas fa-share"></i></a>
                <h5>Ben Roots</h5>
                <p> Cras in velit lacus. Maecenas sodales dui id libero scelerisque elementum. Fusce lacinia egestas maximus. Alqua erat volutpat fusce ac lacinia </p>
                <div class="tw-foot"> @ben.roots<br>
                  03 April, 2020 <i class="fab fa-twitter"></i> </div>
              </div>
            </li> 
          </ul> 
    </div>
  </section>-->

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
  <!--GALERIE: League Players Squad Start
    <section class="wf100 p80 players-squad portfolio filter-gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="section-title">
                  <h2>Galerie</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div id="filters" class="button-group">
                    <button class="button is-checked" data-filter="*">Tous</button>
                    <button class="button" data-filter=".f1">Photos</button>
                    <button class="button" data-filter=".f2">Videos </button>
                    <!--//<a href="#" class="live-show"><i class="fas fa-circle"></i> Live Show</a>--><!--
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <ul class="gallery isotope items">
              <li class="item f1">
                <div class="gthumb">
                  <div class="hv-info"> <a href="#" class="play"><i class="far fa-image"></i></a>
                    <h6><a href="#">Rapide Relizane - CS Constantine</a></h6>
                  </div>
                  <a class="gt-link" href="images/squadgallery-1.jpg" data-rel="prettyPhoto[gallery1]"><i class="far fa-image"></i></a><img src="images/squadgallery-1.jpg" alt=""></div>
              </li>
              <li class="item f2">
                <div class="gthumb active">
                  <div class="hv-info"> <a href="#" class="play"><i class="fas fa-play"></i></a>
                    <h6><a href="#">Match d'entraînement</a></h6>
                  </div>
                  <a class="gt-link" href="../../../www.youtube.com/watch8888.html?v=SLi2gT5H6m8&amp;t=11s" data-rel="prettyPhoto[gallery1]"><i class="fas fa-play"></i></a><img src="images/squadgallery-2.jpg" alt=""></div>
              </li>
              <li class="item f1">
                <div class="gthumb">
                  <div class="hv-info"> <a href="#" class="play"><i class="fas fa-search"></i></a>
                    <h6><a href="#">Match d'entraînement</a></h6>
                  </div>
                  <a class="gt-link" href="images/squadgallery-2.jpg" data-rel="prettyPhoto[gallery1]"><i class="fas fa-search"></i></a><img src="images/squadgallery-3.jpg" alt=""></div>
              </li>
              <li class="item f2">
                <div class="gthumb">
                  <div class="hv-info"> <a href="#" class="play"><i class="fas fa-play"></i></a>
                    <h6><a href="#">Match d'entraînement</a></h6>
                  </div>
                  <a class="gt-link" href="../../../www.youtube.com/watch8888.html?v=SLi2gT5H6m8&amp;t=11s" data-rel="prettyPhoto[gallery1]"><i class="fas fa-play"></i></a><img src="images/squadgallery-4.jpg" alt=""></div>
              </li>
            </ul>
          </div>
        </div>
    </div>
  </section>-->
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
                    <li class="col-md-4"> <a href="#"><img src="images/Logo_entp.png" alt="" style="width: 80%;"></a> </li>
                    <li class="col-md-4"> <a href="#"><img src="images/soummam.png" alt=""></a> </li>
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