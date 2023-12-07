<?php

@include 'lang/change_language.php';
@include 'lang/arabic.php';
@include 'lang/english.php';



// if (isset($_POST['language'])) {
//    $language = $_POST['language'];
//    $_SESSION['language'] = $language;
// } elseif (isset($_SESSION['language'])) {
//    $language = $_SESSION['language'];
// } else {
//    $language = "en";
// }

// $translate = array();

// if ($language === 'en') {
//    $translate = include 'lang/english.php';
// } elseif ($language === 'ar') {
//    $translate = include 'lang/arabic.php';
// }

?>

<footer class="footer">


   <section class="box-container">

     
   <div class="box">
         <h3><?php echo translate('quick_links'); ?></h3>
         <a href="home.php"> <i class="fas fa-angle-right"></i><?php echo translate('home'); ?></a>
         <a href="shop.php"> <i class="fas fa-angle-right"></i><?php echo translate('menu'); ?></a>
         <a href="about.php"> <i class="fas fa-angle-right"></i><?php echo translate('about'); ?></a>
         <a href="contact.php"> <i class="fas fa-angle-right"></i><?php echo translate('contact'); ?></a>
      </div>

      <div class="box">
         <h3><?php echo translate('contact_info'); ?></h3>
         <p> <i class="fas fa-phone"></i>+962 798149153 </p>
         <p> <i class="fas fa-phone"></i> +111-222-3333 </p>
         <p> <i class="fas fa-envelope"></i> aboalaa@gmail.com </p>
         <p> <i class="fas fa-map-marker-alt"></i> jordan, Aqaba - 136 </p>
      </div>

      <div class="box">
         <h3><?php echo translate('follow_us'); ?></h3>
         <a href="https://www.facebook.com/pg/abualaacaffe/menu/"> <i class="fab fa-facebook-f"></i></a>
         <a href="https://www.snapchat.com/add/aboalaacafe"> <i class="fab fa-snapchat"></i></a>
         <a href="https://www.instagram.com/aboalaa.cafe/?igshid=MmVlMjlkMTBhMg%3D%3D"> <i class="fab fa-instagram"></i></a>
      </div>

   </section>


</footer>
