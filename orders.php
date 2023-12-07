<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}
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
   <title>orders</title>
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

<section class="placed-orders">

   <h1 class="title">placed orders</h1>

   <div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
      $select_orders->execute([$user_id]);
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box" dir="<?php echo ($language === 'ar') ? 'rtl' : 'ltr'; ?>">
    <p><?php echo translate('placed_on'); ?> : <span><?= $fetch_orders['placed_on']; ?></span> </p>
    <p><?php echo translate('name'); ?> <span><?= $fetch_orders['name']; ?></span> </p>
    <p><?php echo translate('number'); ?> <span><?= $fetch_orders['number']; ?></span> </p>
    <p><?php echo translate('emailo'); ?> <span><?= $fetch_orders['email']; ?></span> </p>
    <p><?php echo translate('address'); ?> <span><?= $fetch_orders['address']; ?></span> </p>
    <p><?php echo translate('payment_methodo'); ?> <span><?= $fetch_orders['method']; ?></span> </p>
    <p><?php echo translate('your_orders'); ?> <span><?= $fetch_orders['total_products']; ?></span> </p>
    <p><?php echo translate('total_price'); ?> <span>JD<?= $fetch_orders['total_price']; ?></span> </p>
    <p><?php echo translate('payment_status'); ?> <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>">
    <?php echo translate($fetch_orders['payment_status']); ?></span> </p>
</div>

   <?php
      }
   }else{
      echo '<p class="empty" dir="ltr">' . translate('no_orders_placed_yet') . '</p>';
   }
   ?>

   </div>

</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>