<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];




if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$delete_id]);
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}
$updated_price = 0;

// باقي الكود...
if (isset($_POST['update_qty'])) {
   $cart_id = $_POST['cart_id'];
   $p_qty = $_POST['p_qty_' . $cart_id];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $selectedSize = isset($_POST['size_' . $cart_id]) ? $_POST['size_' . $cart_id] : '';

   if ($p_qty > 0) {
       $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ?, size = ? WHERE id = ?");
       $update_qty->execute([$p_qty, $selectedSize, $cart_id]);
       $message[] = 'Cart updated';
   } else {
       $message[] = 'Quantity should be greater than zero';
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
   <title>shopping cart</title>
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

<section class="shopping-cart">

<h1 class="title"><?php echo translate('products_added'); ?></h1>

<div class="box-container">
    <?php
    $grand_total = 0;
    $small_price = -0.50;
    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $select_cart->execute([$user_id]);

    if ($select_cart->rowCount() > 0) {
        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $form_id = 'product_form_' . $fetch_cart['id'];
            $p_price = $fetch_cart['price'];

            $productId = $fetch_cart['id'];
            $sizeKey = "size_" . $productId;
            $selectedSize = isset($_POST[$sizeKey]) ? $_POST[$sizeKey] : $fetch_cart['size'];

            ?>
            <form action="" method="POST" class="box" id="<?= $form_id ?>">
                <a href="cart.php?delete=<?= $fetch_cart['id']; ?>" class="fas fa-times"></a>
                <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
                <div class="name"><?= $fetch_cart['name']; ?></div>
                <div class="price">
                <?php
if ($fetch_cart['category'] == 'Milkshake' || $fetch_cart['category'] == 'Juice') {
    if ($selectedSize == 'small') {
        $p_price += $small_price;
    }
}

// تمرير السعر المحدث إلى صفحة الخروج عن طريق إضافة السعر كمعلمة في رابط الانتقال
       
                    echo 'JD' . $p_price;
                    
                    ?>
                </div>
                <div class="flex-btn">
                    <input type="number" min="1" value="<?= $fetch_cart['quantity']; ?>"
                           class="qty" name="p_qty_<?= $fetch_cart['id']; ?>">
                    <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                    <input type="submit" value="<?php echo translate('update'); ?>" name="update_qty"
                           class="option-btn">
                </div>
                <?php
                if ($fetch_cart['category'] == 'Milkshake' || $fetch_cart['category'] == 'Juice') {
                    ?>
                    <select class="size" name="size_<?php echo $fetch_cart['id']; ?>">
                        <option value="large" <?php if ($selectedSize == 'large') echo 'selected'; ?>>
                            <?php echo translate('Large'); ?>
                        </option>
                        <option value="small" <?php if ($selectedSize == 'small') echo 'selected'; ?>>
                            <?php echo translate('Small'); ?>
                        </option>
                    </select>
                    <div class="sub-total"><?php echo translate('sub_total'); ?> : <span>JD<?= $sub_total = ($p_price * $fetch_cart['quantity']); ?></span></div>
                    <?php
                } else {
                    ?>
                    <div class="sub-total"><?php echo translate('sub_total'); ?> : <span>JD<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span></div>
                    <?php
                }
                $grand_total += $sub_total;
                ?>
            </form>
            <?php
        }
    } else {
        echo '<p class="empty">' . translate('cart_empty_message') . '</p>';
    }
    ?>
</div>


 <div class="cart-total">
     <p><?php echo translate('grand_total'); ?> <span>JD<?= $grand_total; ?></span></p>
     <a href="shop.php" class="option-btn"><?php echo translate('continue_shopping'); ?></a>
     <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total >= 1) ? '' : 'disabled'; ?>"><?php echo translate('delete_all'); ?></a>
     <a href="checkout.php?add_to_cart" class="btn <?= ($grand_total >= 1) ? '' : 'disabled'; ?>"><?php echo translate('proceed_to_checkout'); ?></a>
 </div>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>