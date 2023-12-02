<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

<header class="header">

   <div class="flex">


      <nav class="navbar">
         <a href="admin_page.php">home</a>
         <a href="admin_categories.php">categories</a>
         <a href="admin_products.php">products</a>
         <a href="admin_orders.php">orders</a>
         <a href="admin_users.php">users</a>
         <a href="admin_contacts.php">messages</a>
         <a href="admin_update_profile.php">update profile</a>
         <a href="logout.php">logout</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>


   </div>
   <div class="sidebar">
      <img src="./images/logocupsومعاك اصفر.png" alt="Logo">
      <a href="admin_page.php">home</a>
      <a href="admin_categories.php">categories</a>
      <a href="admin_products.php">products</a>
      <a href="admin_orders.php">orders</a>
      <a href="admin_users.php">users</a>
      <a href="admin_contacts.php">messages</a>
      <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>

      <a href="admin_update_profile.php">update profile</a>
      <a href="logout.php">logout</a>   
   </div>



</header>