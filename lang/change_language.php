<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $language = $_POST['language'];

   // Store the selected language in the session
   $_SESSION['language'] = $language;
}

// Redirect the user back to the previous page or a specific page
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>