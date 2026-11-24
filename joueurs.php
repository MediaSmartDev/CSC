<?php require_once __DIR__ . '/Data/lang.php'; ?>
<!doctype html>
<?php 
include 'Data/Dbo.php';
$today = new DateTime();
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
    <title><?= L('Players - CS Constantine', 'اللاعبون - النادي الرياضي القسنطيني') ?></title>
  </head>
  <body>
    <!--Wrapper Start-->
    <div class="wrapper">
        <?php require 'header.php';?>
      <!--Main Slider Start-->
      <div class="inner-banner-header wf100">
        <h1 data-generated="<?= L('Players', 'اللاعبون') ?>"><?= L('Players', 'اللاعبون') ?></h1>
        <div class="gt-breadcrumbs">
          <ul>
            <li> <a href="index.php" class="active"> <i class="fas fa-home"></i> <?= L('Home', 'الرئيسية') ?> </a> </li>
            <li> <?= L('First team', 'الفريق الأول') ?> </li>
            <li> <a href="#"> <?= L('Players', 'اللاعبون') ?> </a> </li>
          </ul>
        </div>
      </div>
      <!--Main Slider Start--> 
      <!--Main Content Start-->
      <div class="main-content innerpagebg wf100">
        <!--Product Page Start-->
        <div class="team-four wf100 p80-p50">

            <div class="team-grid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="team-main-title"><?= L('Goalkeepers', 'حراس المرمى') ?></h2>
                        </div>
                        <?php
                        $content = '';
                        $data = getPlaersByCateg(1);
                        foreach ($data as $row){
                            $age = playerAge($row);
                            $content .= '<div class="col-lg-3 col-md-6">
                                            <div class="team-squad-box">
                                                <div class="num">'.$row['dossard'].'</div>
                                                <div class="ts-cap">
                                                    <h4>'.htmlspecialchars(player_name($row)).'</h4>
                                                    <p>'.htmlspecialchars(player_poste($row)).'</p>
                                                    <ul>
                                                        <li>'.$age.' <span>'.L('Years', 'سنة').'</span></li>
                                                        
                                                    </ul>
                                                </div>
                                                <img src="'.(!empty($row['img']) ? $row['img'] : 'images/player-default.png').'" alt="'.htmlspecialchars(player_name($row)).'"> 
                                            </div>
                                        </div>';
                        }
                        echo $content;
                        ?>
                    </div>
                </div>
            </div>
          
            <div class="team-grid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="team-main-title"><?= L('Defenders', 'المدافعون') ?></h2>
                        </div>
                        <?php
                        $content = '';
                        $data = getPlaersByCateg(2);
                        foreach ($data as $row){
                            $age = playerAge($row);
                            $content .= '<div class="col-lg-3 col-md-6">
                                            <div class="team-squad-box">
                                                <div class="num">'.$row['dossard'].'</div>
                                                <div class="ts-cap">
                                                    <h4>'.htmlspecialchars(player_name($row)).'</h4>
                                                    <p>'.htmlspecialchars(player_poste($row)).'</p>
                                                    <ul>
                                                        <li>'.$age.' <span>'.L('Years', 'سنة').'</span></li>
                                                        
                                                    </ul>
                                                </div>
                                                <img src="'.(!empty($row['img']) ? $row['img'] : 'images/player-default.png').'" alt="'.htmlspecialchars(player_name($row)).'"> 
                                            </div>
                                        </div>';
                        }
                        echo $content;
                        ?>
                    </div>
                </div>
            </div>
          
            <div class="team-grid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="team-main-title"><?= L('Midfielders', 'وسط الميدان') ?></h2>
                        </div>
                        <?php
                        $content = '';
                        $data = getPlaersByCateg(3);
                        foreach ($data as $row){
                            $age = playerAge($row);
                            $content .= '<div class="col-lg-3 col-md-6">
                                            <div class="team-squad-box">
                                                <div class="num">'.$row['dossard'].'</div>
                                                <div class="ts-cap">
                                                    <h4>'.htmlspecialchars(player_name($row)).'</h4>
                                                    <p>'.htmlspecialchars(player_poste($row)).'</p>
                                                    <ul>
                                                        <li>'.$age.' <span>'.L('Years', 'سنة').'</span></li>                                                    
                                                    </ul>
                                                </div>
                                                <img src="'.(!empty($row['img']) ? $row['img'] : 'images/player-default.png').'" alt="'.htmlspecialchars(player_name($row)).'"> 
                                            </div>
                                        </div>';
                        }
                        echo $content;
                        ?>
                    </div>
                </div>
            </div>
          
            <div class="team-grid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="team-main-title"><?= L('Forwards', 'المهاجمون') ?></h2>
                        </div>
                        <?php
                        $content = '';
                        $data = getPlaersByCateg(4);
                        foreach ($data as $row){
                            $age = playerAge($row);
                            $content .= '<div class="col-lg-3 col-md-6">
                                            <div class="team-squad-box">
                                                <div class="num">'.$row['dossard'].'</div>
                                                <div class="ts-cap">
                                                    <h4>'.htmlspecialchars(player_name($row)).'</h4>
                                                    <p>'.htmlspecialchars(player_poste($row)).'</p>
                                                    <ul>
                                                        <li>'.$age.' <span>'.L('Years', 'سنة').'</span></li>
                                                    </ul>
                                                </div>
                                                <img src="'.(!empty($row['img']) ? $row['img'] : 'images/player-default.png').'" alt="'.htmlspecialchars(player_name($row)).'"> 
                                            </div>
                                        </div>';
                        }
                        echo $content;
                        ?>
                    </div>
                </div>
            </div>
            
            <!--Banners Start-->
            <div class="team-grid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="team-main-title"><?= L('Coaching staff', 'الطاقم الفني') ?></h2>
                        </div>
                        <?php
                        $content = '';
                        $data = getPlaersByCateg(5);
                        foreach ($data as $row){
                            $age = playerAge($row);
                            $content .= '<div class="col-lg-3 col-md-6">
                                            <div class="team-squad-box">
                                                '.(!empty($row['dossard']) ? '<div class="num">'.$row['dossard'].'</div>' : '').'
                                                <div class="ts-cap">
                                                    <h4>'.htmlspecialchars(player_name($row)).'</h4>
                                                    <p>'.htmlspecialchars(player_poste($row)).'</p>
                                                    <ul>
                                                        <li>'.($age ? $age.' <span>'.L('Years', 'سنة').'</span>' : '&nbsp;<span>&nbsp;</span>').'</li>
                                                    </ul>
                                                </div>
                                                <img src="'.htmlspecialchars(!empty($row['img']) ? $row['img'] : 'images/player-default.png').'" alt="'.htmlspecialchars(player_name($row)).'">
                                            </div>
                                        </div>';
                        }
                        echo $content;
                        ?>
                    </div>
                </div>
            </div>
          <!--Banners End--> 
          
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