<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if (isset($_POST['update_category'])) {

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image;
   $old_image = $_POST['old_image'];

   $update_category = $conn->prepare("UPDATE `categories` SET name = ? WHERE id = ?");
   $update_category->execute([$name, $pid]);

   $message = [];
   $message[] = 'Category updated successfully!';

   if (!empty($image)) {
       if ($image_size > 20000000) {
           $message[] = 'Image size is too large!';
       } else {
           $update_image = $conn->prepare("UPDATE `categories` SET image = ? WHERE id = ?");
           $update_image->execute([$image, $pid]);

           if ($update_image) {
               move_uploaded_file($image_tmp_name, $image_folder);
               unlink('uploaded_img/' . $old_image);
               $message[] = 'Image updated successfully!';
           }
       }
   }

   // يمكنك استخدام $message لعرض الرسائل للمستخدم
   foreach ($message as $msg) {
       echo $msg . "<br>";
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>
<?php
$update_id = $_GET['update'];
$select_categories = $conn->prepare("SELECT * FROM `categories` WHERE id = ?");
$select_categories->execute([$update_id]);

if ($select_categories->rowCount() > 0) {
    $fetch_categories = $select_categories->fetch(PDO::FETCH_ASSOC);
    
    if (isset($_POST['update_category'])) {
        $name = $_POST['name'];
        $old_image = $_POST['old_image'];
        
        // تحديث الاسم إذا تم تغييره
        if (!empty($name)) {
            $update_name = $conn->prepare("UPDATE `categories` SET `name` = ? WHERE `id` = ?");
            $update_name->execute([$name, $fetch_categories['id']]);
        }
        
        // تحديث الصورة إذا تم تغييرها
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $image_path = "uploaded_img/" . $image;
            
            // حذف الصورة القديمة إذا كانت موجودة
            if (!empty($old_image)) {
                unlink("uploaded_img/" . $old_image);
            }
            
            // رفع الصورة الجديدة
            move_uploaded_file($tmp_name, $image_path);
            
            // تحديث اسم الصورة في قاعدة البيانات
            $update_image = $conn->prepare("UPDATE `categories` SET `image` = ? WHERE `id` = ?");
            $update_image->execute([$image, $fetch_categories['id']]);
        }
        
        // إعادة توجيه المستخدم بعد التحديث
        header("Location: admin_categories.php");
        exit();
    }
?>

<section class="update-category">
    <h1 class="title">Update Category</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="old_image" value="<?= $fetch_categories['image']; ?>">
        <input type="hidden" name="pid" value="<?= $fetch_categories['id']; ?>">
        <img src="uploaded_img/<?= $fetch_categories['image']; ?>" alt="">
        <input type="text" name="name" placeholder="Enter category name" required class="box" value="<?= $fetch_categories['name']; ?>">
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        <div class="flex-btn">
            <input type="submit" class="btn" value="Update Category" name="update_category">
            <a href="admin_categories.php" class="option-btn">Go Back</a>
        </div>
    </form>
</section>

<?php
} else {
    echo '<p class="empty">No categories found!</p>';
}
?>













<script src="js/script.js"></script>

</body>
</html>