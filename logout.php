
<?php
// Include the composer autoload file
include_once "vendor/autoload.php";
$user = new UserAccounts;
$user->logout();
header('Location: '.Config::$site_url.'login.php');