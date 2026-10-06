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
    <title><?= L('Partenaires - CS Constantine', 'الشركاء - النادي الرياضي القسنطيني') ?></title>
  </head>
<body>
    <!--Wrapper Start-->
    <div class="wrapper">
        <?php require 'header.php';?>
        <div class="inner-banner-header wf100">
            <h1 data-generated="<?= L('Partenaires', 'الشركاء') ?>"><?= L('Partenaires du CSC', 'شركاء النادي') ?></h1>
            <div class="gt-breadcrumbs">
                <ul>
                  <li> <a href="index.php" class="active"> <i class="fas fa-home"></i> <?= L('Accueil', 'الرئيسية') ?> </a> </li>
                  <li> <?= L('CLUB', 'النادي') ?> </li>
                  <li> <a href="#"> <?= L('Partenaires', 'الشركاء') ?></a></li>
                </ul>
            </div>
        </div>

        <!--Main Content Start-->
        <div class="main-content innerpagebg wf100">
            <div class="shop wf100 p80">
                <!--<div class="product-slider">
                    <div class="container">
                        <div id="pro-slider" class="owl-carousel owl-theme">
                            <div class="item">
                                <div class="pro-box">
                                    <div class="pro-thumb"> 
                                        <a href="#"><i class="fas fa-link"></i></a> 
                                        <img src="images/parentp.jpg" alt=""> 
                                    </div>
                                    <div class="pro-txt">
                                        <h4><a href="#">ENTP</a> </h4>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="item">
                                <div class="pro-box">
                                    <div class="pro-thumb"> 
                                        <a href="#"><i class="fas fa-link"></i></a> 
                                        <img src="images/parsoummam.jpg" alt=""> 
                                    </div>
                                    <div class="pro-txt">
                                        <h4><a href="#">SOUMMAM</a> </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                <!--Products slider End-->
                <section class="wf100 p80 shop-banners">
                  <div class="container">
                    <div class="row">
                      <div class="col-lg-1"></div>
                      <div class="col-lg-5 col-md-6"><img src="images/1entpbanner.jpg" alt=""></div>
                      <div class="col-lg-5 col-md-6"><img src="images/1soummambanner.jpg" alt=""></div>
                      <div class="col-lg-1"></div>
                    </div>
                      <div class="row">
                      <div class="col-lg-1"></div>
                      <div class="col-lg-5 col-md-6"><img src="images/kcs.png" alt=""></div>
                      <div class="col-lg-5 col-md-6"><img src="images/gymone.png" alt=""></div>
                      <div class="col-lg-1"></div>
                    </div>
                  </div>
                </section>
                
          </div>
          <!--Product Page End--> 
        </div>
        <!--Main Content End--> 
        
        
     <?php require 'footer.php';?>
    </div>
    <!--Wrapper End--> 
    <!-- Optional JavaScript --> 
    <script src="js/jquery-3.3.1.min.js"></script> 
    <script src="js/popper.min.js"></script> 
    <script src="js/bootstrap.min.js"></script> 
<script src="js/mobile-nav.js"></script>  
    <script src="js/owl.carousel.min.js"></script> 
    <script src="js/isotope.js"></script> 
    <script src="js/jquery.prettyPhoto.js"></script> 
    <script src="js/jquery.countdown.js"></script> 
    <script src="js/custom.js"></script>
  </body>
</html>