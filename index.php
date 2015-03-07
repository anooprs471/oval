<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';


$blade = new Blade($views, $cache);

$user = new UserAccounts;

//$user->login('admin@administrator.com','test');
//$user->login('op@op.com','test');

// if($user->isOperator()){
// 	echo 'operator';
// }
// if($user->isAdmin()){
// 	echo 'admin';
// }
// 
//$user->logout();

if(!$user->isLoggedIn()){
	header('Location: '.Config::$site_url.'login.php');
}elseif ($user->isOperator()) {
	header('Location: '.Config::$site_url.'op-home.php');
}elseif ($user->isAdmin()) {
	header('Location: '.Config::$site_url.'admin-home.php');
}


