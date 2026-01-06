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
    <title>Site officiel du CSC - Club Sportif Constantinois</title>
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
        <h1 data-generated="Classement">Classement</h1>
        <div class="gt-breadcrumbs">
          <ul>
            <li> <a href="#" class="active"> <i class="fas fa-home"></i> Accueil </a> </li>
            <li> Equipe première </li>
            <li> <a href="#"> Classement </a> </li>
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
                    <h1 class="page_title">Championnat d'Algérie de football Ligue 1</h1>
                    <br>
                    <div class="header_time-info">
                        <div class="last-updated">Dernière mise à jour: 09:09am mardi 09 déc. 2025</div>
                        <span class="season-info">Saison 2025/2026:</span>
                        <span class="match-week-info">19ème journée</span>
                    </div>
                  <div class="point-table-widget">
                    <table>
                        <thead>
                          <tr>
                            <th> </th>
                            <th>Equipe</th>
                            <th>G</th>
                            <th>N</th>
                            <th>P</th>
                            <th>BP</th>
                            <th>BC</th>
                            <th>DB</th>
                            <th>Points</th>
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
                                    <td>'.$row["bp"].'</td>
                                    <td>'.$row["bc"].'</td>
                                    <td>'.$row["db"].'</td>
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