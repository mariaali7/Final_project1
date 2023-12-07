<?php

@include 'config.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';

   }

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
   <title>contact</title>

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


<section class="contact">

<h1 class="title"><?php echo translate('get_in_touch'); ?></h1>

   <div class="contact-container">
      <form action="" method="POST" class="contact-form">
      <input type="text" name="name" class="box" required placeholder="<?php echo translate('enter_your_name'); ?>">
<input type="email" name="email" class="box" required placeholder="<?php echo translate('enter_your_email'); ?>">
<input type="number" name="number" min="0" class="box" required placeholder="<?php echo translate('enter_your_number'); ?>">
<textarea name="msg" class="box" required placeholder="<?php echo translate('enter_your_message'); ?>" cols="30" rows="10"></textarea>
<input type="submit" value="<?php echo translate('send_message'); ?>" class="btn" name="send">

      </form>

      <div class="location">
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3471.507347822646!2d35.004876611233506!3d29.530715942624525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15007191a4a72203%3A0x359a92b388d4a26d!2z2YLZh9mI2Kkg2KPYqNmIINi52YTYp9ih!5e0!3m2!1sen!2sjo!4v1700330208861!5m2!1sen!2sjo" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
   </div>

</section>







<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>