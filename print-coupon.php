<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;
use Carbon\Carbon;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';


$blade = new Blade($views, $cache);

$msg = '';
$flash_msg = '';

$user = new UserAccounts;

$capsule = $user->getCapsule();

$flash = new Flash_Messages();

if($flash->hasFlashMessage()){
	$flash_msg = $flash->show();
}


if($user->isOperator()){
	$names = $user->getOperatorName();
	if(isset($_GET['coupon-id']) || !empty($_GET['coupon-id'])){
		$coupon = $capsule::table('coupons')
		->where('id','=',$_GET['coupon-id'])
		->get();
	}

	var_dump($coupon);

	$data = array(
		'type' => 'operator',
		'site_url'=> Config::$site_url,
		'name' => 'Operator',
		'first_name' => $names['first-name'],
		'last_name' => $names['last-name'],
		'msg' => $msg,
		'flash' => $flash_msg
	);
	//echo $blade->view()->make('op.coupon-print',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}