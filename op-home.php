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
	'type' => 'operator',
	'site_url'=> Config::$site_url,
	'name' => 'Operator'
);

if($user->isOperator()){
	echo $blade->view()->make('op.home',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}