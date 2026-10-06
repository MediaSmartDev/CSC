<?php require_once __DIR__ . '/Data/lang.php'; ?>
<!doctype html>
<?php 
include 'Data/Dbo.php';
?>
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
    <title><?= L('Classement - CS Constantine', 'الترتيب - النادي الرياضي القسنطيني') ?></title>
    <style type="text/css">
        .page_title{
            text-align: center;
               //background: linear-gradient(90deg,#cd122d,#154284);
                background: linear-gradient(90deg,#0a6833 0,#020e01);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                color: #fff;
        }
        .header_time-info{
            text-align: right;
            margin-bottom: 1rem;
        }
        .last-updated{
            text-transform: uppercase;
            font-size: 12px;
            line-height: 1.2rem;
        }
        .season-info{
            font-weight: 400;
            line-height: 2.2rem;
            
        }
        .match-week-info{
            font-size: 12px;
            color: #222;
        }
    </style>
  </head>
  <body>
    <!--Wrapper Start-->
    <div class="wrapper">
        <?php require 'header.php';?>
      <!--Main Slider Start-->
      <div class="inner-banner-header wf100">
        <h1 data-generated="<?= L('Classement', 'الترتيب') ?>"><?= L('Classement', 'الترتيب') ?></h1>
        <div class="gt-breadcrumbs">
          <ul>
            <li> <a href="index.php" class="active"> <i class="fas fa-home"></i> <?= L('Accueil', 'الرئيسية') ?> </a> </li>
            <li> <?= L('Équipe première', 'الفريق الأول') ?> </li>
            <li> <a href="#"> <?= L('Classement', 'الترتيب') ?> </a> </li>
          </ul>
        </div>
      </div>
      <!--Main Slider Start--> 
      <!--Main Content Start-->
      <div class="main-content solidbg wf100">
        <!--team Page Start-->
        <div class="team wf100 p80">
          <!--Start-->
          <div class="point-table">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                    <h1 class="page_title"><?= L('Championnat d\'Algérie de football Ligue 1', 'البطولة الجزائرية لكرة القدم - الرابطة الأولى') ?></h1>
                    <br>
                    <div class="header_time-info">
                        <?php $info = getClassementInfo(); ?>
                        <?php if ($info): ?>
                        <div class="last-updated"><?= L('Dernière mise à jour :', 'آخر تحديث:') ?> <?= date('d/m/Y H:i', strtotime($info['mise_a_jour'])) ?></div>
                        <span class="season-info"><?= L('Saison', 'موسم') ?> <?= htmlspecialchars($info['saison']) ?> :</span>
                        <span class="match-week-info"><?= $LANG === 'ar' ? 'الجولة ' . (int)$info['journee'] : (int)$info['journee'] . ($info['journee'] == 1 ? 'ère' : 'ème') . ' journée' ?></span>
                        <?php endif; ?>
                    </div>
                  <div class="point-table-widget">
                    <table>
                        <thead>
                          <tr>
                            <th> </th>
                            <th><?= L('Équipe', 'الفريق') ?></th>
                            <th><?= L('J', 'لعب') ?></th>
                            <th><?= L('G', 'ف') ?></th>
                            <th><?= L('N', 'ت') ?></th>
                            <th><?= L('P', 'خ') ?></th>
                            <th><?= L('BP', 'له') ?></th>
                            <th><?= L('BC', 'عليه') ?></th>
                            <th><?= L('DB', 'الفارق') ?></th>
                            <th><?= L('Points', 'النقاط') ?></th>
                          </tr>
                        </thead>
                <tbody>
                    <?php
                    $content = '';
                    $classement = getClassmentTable();
                    if (empty($classement)) {
                        $content = '<tr><td colspan="10" style="text-align:center;">'.L('Classement indisponible pour le moment.', 'الترتيب غير متوفر حاليا.').'</td></tr>';
                    }
                    foreach ($classement as $row){
                        $isCsc = strtoupper($row["club"]) === 'CSC';
                        $content .= '<tr'.($isCsc ? ' style="background:rgba(10,79,10,0.10);font-weight:bold;"' : '').'>
                                    <td>'.$row["position"].'</td>
                                    <td><img src="'.$row["logo"].'" alt="'.htmlspecialchars(club_name($row)).'" style="height:24px;"> <strong>'.htmlspecialchars(club_name($row)).'</strong></td>
                                    <td>'.$row["j"].'</td>
                                    <td>'.$row["g"].'</td>
                                    <td>'.$row["n"].'</td>
                                    <td>'.$row["p"].'</td>
                                    <td>'.$row["bp"].'</td>
                                    <td>'.$row["bc"].'</td>
                                    <td>'.($row["db"] > 0 ? '+' : '').$row["db"].'</td>
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
          </div>
          <!--End--> 
        </div>
        <!--team Page End--> 
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