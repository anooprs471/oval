<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';


$blade = new Blade($views, $cache);
$msg = '';

$user = new UserAccounts;


if($user->isOperator()){
	$names = $user->getOperatorName();

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		
	}


	//$customer = Customers::find(1);
	$data = array(
		'type' => 'operator',
		'site_url'=> Config::$site_url,
		'name' => 'Operator',
		'first_name' => $names['first-name'],
		'last_name' => $names['last-name'],
		'msg' => $msg
	);
	echo $blade->view()->make('op.home',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}