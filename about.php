<?php

@include 'config.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

@include 'lang/change_language.php';
@include 'lang/arabic.php';
@include 'lang/english.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>
    
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Concert+One&family=Fira+Sans:wght@200&family=Fredoka:wght@500;600&family=Lexend+Peta:wght@200&family=Lobster&family=Patua+One&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Concert+One&family=Fira+Sans:wght@200&family=Fredoka:wght@500;600&family=Lexend+Peta:wght@200&family=Lobster&family=Patua+One&family=Spectral:ital@1&display=swap" rel="stylesheet">


   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/WhatsApp Image 2023-11-17 at 16.23.24.jpeg" alt="">
      </div>

      <div class="content">
      <h3><?php echo translate('why_choose_us'); ?></h3>
    <p><?php echo translate('welcome_to_cafe'); ?></p>
      </div>

   </div>


<br> <br> <br> <br> <br> <br> <br> 

   <div class="row">



<div class="content">
<h3><?php echo translate('our_story'); ?></h3>
<p><?php echo translate('indulge_your_senses'); ?></p>
</div>
<div class="image2">
   <img src="images/WhatsApp Image 2023-11-17 at 16.23.23 (1).jpeg" alt="">
</div>
</div>



</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>