<?php

@include 'config.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

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
         <h3>why choose us?</h3>
         <p>Welcome to Abou Alaa Cafe, where passion meets perfection in every sip. Our commitment to quality, handcrafted beverages sets us apart. We source the finest coffee beans, freshest ingredients, and craft each drink with love. Whether you're a coffee enthusiast, milkshake lover, or juice aficionado, we have something special for you.</p>

      </div>

   </div>


<br> <br> <br> <br> <br> <br> <br> 

   <div class="row">



<div class="content">
   <h3>Our Story</h3>

   <p>Indulge your senses in a world of delightful flavors. At Abou Alaa Cafe, we offer a diverse menu that caters to every taste. From rich and aromatic coffees to creamy and decadent milkshakes, and refreshing, natural juices – our offerings are a celebration of taste and quality. Visit our shop and experience a symphony of flavors.</p>
 
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