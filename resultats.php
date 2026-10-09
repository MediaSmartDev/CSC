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
   <title><?= L('Résultats - CS Constantine', 'النتائج - النادي الرياضي القسنطيني') ?></title>
   <style type="text/css">
       .fixture-date{
            font-weight: 600;
            text-transform: uppercase !important;
            font-size: 16px !important;
            color: #222 !important;
            min-width: 5rem;
       }
       .fixture-competition{
            ext-align: center;
            white-space: nowrap;
            min-width: 5rem;
       }
       .fixture-info{
           flex-grow: 1;
           justify-content: center;
        }
       
       #fixture {
           
       }
       
       .fixture-stage {
            font-weight: 600;
            font-size: 16px;
            line-height: 1.3rem;
            color: #222;
        }
        .fixture-stage-location {
            font-weight: 400;
            color: #222;
            font-size: 10px;
            line-height: 1rem;
        }
        
        .fixture-stage-container {
            display: flex;
            flex-direction: column;
            text-align: left;
            width: 10rem;
            padding: 0 0.8rem;
        }
        
        .fixture-info{
            flex-grow: 1;
            justify-content: center;
        }
        .fixture-info-container{
            display: flex;
            align-items: center;
        }
        .fixture-info-name{
            font-weight: 800;
            color: #222;
            font-size: 18px;
            //width: 21rem;
        }
        .fixture-info-name-home {
            text-align: right;
            margin-left: 1.2rem;
        }
        .fixture-info-badge{
            padding: 0 0.8rem;
            height: 4rem;
        }
        .fixture-info-match{
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        .fixture-info-score{
            height: 4rem;
            text-align: center;
        }
        
        .fixture-info-container-away {
            flex-direction: row-reverse;
        }



        
        .fixture-info-score>span {
            font-weight: 800;
            display: inline-block;
            height: 3.9rem;
            font-size: 24px;
            line-height: 3.6rem;
            text-align: center;
            color: #fff;
            background: linear-gradient(180deg,#2c4481 0,#181733);
            width: auto;
            min-width: 5rem;
            margin: 0 0.1rem;
            padding: 0 1rem;
    }
   </style>
</head>
<body>
    <!--Wrapper Start-->
    <div class="wrapper">
       <?php require 'header.php';?>

        <div class="match-header wf100">
           <div class="container">
               <div class="row">
                   <div class="col-md-12">
                       <h5><?= L('Coupe de la CAF', 'كأس الكونفدرالية الإفريقية') ?></h5>
                       <p><?= L('Phase de groupes - Groupe A', 'دور المجموعات - المجموعة أ') ?></p>
                       <ul class="teamz">
                           <li class="mt-left"><img src="images/CSConstantine.png" alt=""> <strong><?= L('CS Constantine', 'ش.قسنطينة') ?></strong> </li>
                           <li class="mt-center-score">
                               <div class="score-left"> <span>4</span></div>
                               <div class="score-right"> <span>0</span></div>
                           </li>
                           <li class="mt-right"><img src="ressources/logo/fcbravos_do_maquis_t4.png" alt=""> <strong><?= L('Bravos do Maquis', 'برافوس دو ماكيس') ?></strong> </li>
                       </ul>
                       <ul class="match-score">
                            <li class="text-right">
                                <p><?= L('Miloud Rebiaï', 'ميلود ربيعي') ?> <span>(41')</span> <i class="fas fa-futbol"></i></p>
                                <p><?= L('Tosin Omoyele', 'توسين أومويلي') ?> <span>(45+1')</span> <i class="fas fa-futbol"></i></p>
                                <p><?= L('Abdennour Belhocini', 'عبد النور بلحوسيني') ?> <span>(86')</span> <i class="fas fa-futbol"></i></p>
                                <p><?= L('Dadi El Hocine Mouaki', 'دادي الحسين مواكي') ?> <span>(89')</span> <i class="fas fa-futbol"></i></p>
                            </li>
                            <li class="text-left">
                                
                            </li>
                       </ul>
                   </div>
               </div>
           </div>
            <ul class="m-date-loc">
               <li><i class="fas fa-calendar-alt"></i> <?= L('17 Mai 2024', '17 ماي 2024') ?></li>
               <li class="pipeline"> | </li>
               <li><i class="fas fa-map-marker-alt"></i> <?= L('Stade Chahid Hamlaoui, Constantine', 'ملعب الشهيد حملاوي، قسنطينة') ?></li>
            </ul>
        </div>
        <div class="main-content innerpagebg wf100 p80">
            <!--News Large Page Start--> 
            <!--Start-->
            <div class="news-large">
               <div class="container">
                  <div class="row">
                     <!--News Start-->
                     <div class="col-lg-12">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="match-results-table">
                                <h4><?= L('Résultats des matchs', 'نتائج المباريات') ?></h4>

                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
               </div>
            </div>
            <!--End--> 
         </div>
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
      <script src="js/jquery.prettyPhoto.js"></script> 
      <script src="js/jquery.countdown.js"></script> 
      <script src="js/audioplayer.min.js"></script> 
      <script src="js/custom.js"></script>
   </body>
</html>