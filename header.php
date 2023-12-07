<?php
include 'lang/arabic.php';
include 'lang/english.php';

if (isset($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

// Check if the language is selected
if (isset($_POST['language'])) {
   $language = $_POST['language'];

   // Validate and set the selected language
   if ($language === 'ar') {
       $_SESSION['language'] = 'ar';
   } else {
       $_SESSION['language'] = 'en';
   }
}

// Include the language file based on the selected language
if (isset($_SESSION['language']) && $_SESSION['language'] === 'ar') {
   include 'lang/arabic.php';
} else {
   include 'lang/english.php';
}
?>


<header class="header">
        <div class="flex">
            <a href="admin_page.php" class="logo"><img src="./images/logocupsومعاك اصفر.png" alt=""></a>
            <nav class="navbar">
                <a href="home.php"><?php echo $translate['home']; ?></a>
                <a href="shop.php"><?php echo $translate['menu']; ?></a>
                <a href="orders.php"><?php echo $translate['orders']; ?></a>
                <a href="about.php"><?php echo $translate['about']; ?></a>
                <a href="contact.php"><?php echo $translate['contact']; ?></a>
            </nav>
            <form class="icon" id="language-form" method="POST" action="">
                <select name="language" onchange="submitLanguageForm()">
                    <option value="en" <?php if (isset($_SESSION['language']) && $_SESSION['language'] === 'en') echo 'selected'; ?>>English</option>
                    <option value="ar" <?php if (isset($_SESSION['language']) && $_SESSION['language'] === 'ar') echo 'selected'; ?>>Arabic</option>
                </select>
            </form>
     


            <?php if(isset($user_id)) { ?>
         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <?php
               $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
               $count_cart_items->execute([$user_id]);
               $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
               $count_wishlist_items->execute([$user_id]);
            ?>
            <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $count_wishlist_items->rowCount(); ?>)</span></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $count_cart_items->rowCount(); ?>)</span></a>
         </div>
         <div class="profile">
    <?php
    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->execute([$user_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    ?>
    <img src="uploaded_img/<?php echo $fetch_profile['image']; ?>" alt="">
    <p><?php echo $fetch_profile['name']; ?></p>
    <a href="user_profile_update.php" class="btn"><?php echo translate('update_profile'); ?></a>
<a href="logout.php" class="delete-btn"><?php echo translate('logout'); ?></a>
</div>

<?php } else { ?>

<div class="icons">
    <div id="menu-btn" class="fas fa-bars"></div>
    <a href="login.php" class=" login"><?php echo translate('login'); ?></a>
    <a href="register.php" class=" register"><?php echo translate('register'); ?></a>
</div>
<?php } ?>
        </div>
    </header>

    <!-- Add the rest of your HTML content here -->

    <script>
        function submitLanguageForm() {
            document.getElementById('language-form').submit();
        }
    </script>
