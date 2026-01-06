<?php 
$data = getContact();
$year = date("Y");
?>
<footer class="wf100 main-footer">
  <div class="container">
    <div class="row"> 
      <!--Footer Widget Start-->
      <div class="col-lg-4 col-md-6">
        <div class="footer-widget about-widget"> <img src="images/logocsc.png" alt="">
          <p> CLUB SPORTIF CONSTANTINOIS </p>
          <address>
          <ul>
            <li><i class="fas fa-map-marker-alt"></i><?php echo $data['adresse']; ?></li>
            <li><i class="fas fa-phone"></i><?php echo $data['tel']; ?></li>
            <li><i class="fas fa-envelope"></i><?php echo $data['email']; ?></li>
          </ul>
          </address>
        </div>
      </div>
        <div class="col-lg-4 col-md-6">
            <div class="footer-widget">
              <!--<h4>Sitemap</h4>-->
            </div>
        </div>
 
      <div class="col-lg-4 col-md-6"></div>
  </div>
  <div class="container brtop">
    <div class="row">
      <div class="col-lg-6 col-md-6">
        <p class="copyr"> All Rights Reserved © <?php echo $year; ?>, Developed By <a href="#">MEDIASMART</a> </p>
      </div>
      <div class="col-lg-6 col-md-6">

      </div>
    </div>
  </div>
</footer>