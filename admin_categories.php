<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
 
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_categories = $conn->prepare("SELECT * FROM `categories` WHERE name = ?");
   $select_categories->execute([$name]);

   if($select_categories->rowCount() > 0){
      $message[] = 'category name already exist!';
   }else{

      $insert_categories = $conn->prepare("INSERT INTO `categories`(name, image) VALUES(?,?)");
      $insert_categories->execute([$name, $image]);

      if($insert_categories){
         if($image_size > 20000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'new category added!';
         }

      }

   }

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = $conn->prepare("SELECT image FROM `categories` WHERE id = ?");
   $select_delete_image->execute([$delete_id]);
   $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   $delete_categories = $conn->prepare("DELETE FROM `categories` WHERE id = ?");
   $delete_categories->execute([$delete_id]);

   header('location:admin_categories.php');


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="add-categories">

   <h1 class="title">add new category</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
         <input type="text" name="name" class="box" required placeholder="enter category name">
      
         </div>
         <div class="inputBox">
         <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
         </div>
      </div>
            <input type="submit" class="btn" value="add category" name="add_product">
   </form>

</section>

<section class="show-categories">

   <h1 class="title">categories added</h1>

   <div class="box-container">

   <?php
      $show_categories = $conn->prepare("SELECT * FROM `categories`");
      $show_categories->execute();
      if($show_categories->rowCount() > 0){
         while($fetch_categories = $show_categories->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="uploaded_img/<?= $fetch_categories['image']; ?>" alt="">
      <div class="name"><?= $fetch_categories['name']; ?></div>
      <div class="flex-btn">
         <a href="admin_update_category.php?update=<?= $fetch_categories['id']; ?>" class="option-btn">update</a>
         <a href="admin_categories.php?delete=<?= $fetch_categories['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">now categories added yet!</p>';
   }
   ?>

   </div>

</section>











<script src="js/script.js"></script>

</body>
</html>