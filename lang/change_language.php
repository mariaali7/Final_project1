<?php
session_start();

if (!function_exists('translate')) {
   function translate($phrase) {
      global $translate;

      if (isset($translate[$phrase])) {
         return $translate[$phrase];
      }

      return $phrase;
   }
}

if (isset($_POST['language'])) {
   $language = $_POST['language'];
   $_SESSION['language'] = $language;
} elseif (isset($_SESSION['language'])) {
   $language = $_SESSION['language'];
} else {
   $language = "en";
}

$translate = array();

if ($language === 'en') {
    $translate = require 'lang/english.php';
} elseif ($language === 'ar') {
    $translate = require 'lang/arabic.php';
}
?>
