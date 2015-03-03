<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';


$blade = new Blade($views, $cache);

$user = new UserAccounts;

$data = array(
	'type' => 'admin',
	'site_url'=> Config::$site_url,
	'name' => 'Administrator'
);

if($user->isAdmin()){
	echo $blade->view()->make('admin.home',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}