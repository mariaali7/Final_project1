<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if (isset($_POST['order'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. ' . $_POST['flat'] . ' ' . $_POST['street'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $placed_on = date('d-M-Y');
   $cart_total = 0;
   $cart_products = [];

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if ($cart_query->rowCount() > 0) {
       while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
           // Update the cart item price based on the size
           if ($cart_item['size'] == 'small') {
               $cart_item['price'] -= 0.50;
           }
           
           $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ' (' . $cart_item['size'] . ')';
           $sub_total = ($cart_item['price'] * $cart_item['quantity']);
           $cart_total += $sub_total;
           
           // Update the cart item price in the database
           $update_price_query = $conn->prepare("UPDATE `cart` SET price = ? WHERE id = ?");
           $update_price_query->execute([$cart_item['price'], $cart_item['id']]);
       }
   }

   $total_products = implode(', ', $cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }elseif($order_query->rowCount() > 0){
      $message[] = 'order placed already!';
   }else{
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      $message[] = 'order placed successfully!';
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
   <title>checkout</title>



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
<section class="display-orders">

   <?php

$cart_grand_total = 0;
$cart_total = 0; // Initialize outside the loop

$select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$select_cart_items->execute([$user_id]);

if ($select_cart_items->rowCount() > 0) {
    while ($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)) {
        $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);

        // Check if the product size is 'small' and apply the discount to each unit
        if ($fetch_cart_items['size'] == 'small') {
            $cart_total_price -= (0.50 * $fetch_cart_items['quantity']);
        }

        $cart_grand_total += $cart_total_price;

        // Output individual cart item
        echo '<p>';
        echo $fetch_cart_items['name'];

        if ($fetch_cart_items['size'] == 'small') {
            echo '<span>( Price: JD' . ($fetch_cart_items['price'] - 0.50) . ' x ' . $fetch_cart_items['quantity'] . ')</span>';
        } else {
            echo '<span>(' . $fetch_cart_items['size'] . ', Price: JD' . $fetch_cart_items['price'] . ' x ' . $fetch_cart_items['quantity'] . ')</span>';
        }

        echo '</p>';
    }

    // Update $cart_total after the loop
    $cart_total = $cart_grand_total;
} else {
    echo '<p class="empty">your cart is empty!</p>';
}
?>

<div class="grand-total" ><?php echo translate('grand_total'); ?><span >JD<?= $cart_grand_total; ?></span></div>

</section>
<section class="checkout-orders">

   <form action="" method="POST">

   <h3><?php echo translate('place_your_order'); ?></h3>

      <div class="flex">
         <div class="inputBox">
         <span dir="rtl"><?php echo translate('your_name'); ?></span>
            <input type="text" name="name" placeholder="enter your name" class="box" required>
         </div>
         <div class="inputBox">
         <span dir="rtl"><?php echo translate('your_number'); ?></span>
            <input type="number" name="number" placeholder="enter your number" class="box" required>
         </div>
         <div class="inputBox">
         <span dir="rtl"><?php echo translate('your_email'); ?></span>
            <input type="email" name="email" placeholder="enter your email" class="box" required>
         </div>
         <div class="inputBox">
         <span dir="rtl"><?php echo translate('payment_method'); ?></span>
            <select name="method" class="box" required>
            <option value="cash on delivery"><?php echo translate('cash_on_delivery'); ?></option>
      
            </select>
         </div>
         <div class="inputBox">
         <span dir="rtl"><?php echo translate('address_line_01'); ?></span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" required>
         </div>
         <div class="inputBox">
         <span dir="rtl"><?php echo translate('address_line_02'); ?></span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" required>
         </div>
         <!-- <div class="inputBox">
         <span dir="rtl"><?php echo translate('city'); ?></span>
            <input type="text" name="city" placeholder="e.g. mumbai" class="box" required>
         </div> -->
         <!-- <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" placeholder="e.g. maharashtra" class="box" required>
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" placeholder="e.g. India" class="box" required>
         </div> -->
         <!-- <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" class="box" required>
         </div> -->
      </div>

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1) ? '' : 'disabled'; ?>" value="<?php echo translate('place_order'); ?>">

   </form>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>