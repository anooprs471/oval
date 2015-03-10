<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;
use Carbon\Carbon;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';


$blade = new Blade($views, $cache);

$user = new UserAccounts;

$flash = new Flash_Messages();

$capsule = $user->getCapsule();

$msg = '';
$flash_msg = '';
$user_err = false;

$user_coupon = array();


$user_id = $_GET['id'];

if($user->isAdmin()){

	// $coupons = $capsule::table('coupons')
	// ->where('op_id','=',$user_id)
	// ->whereBetween('created_at', $dates)
	// ->get();

	$op = $capsule::table('users')
	->where('id','=',$user_id)
	->first();

	if(!empty($user)){
		$coupons = $capsule::table('coupons')
		->where('op_id','=',$user_id)
		->get();

		if(!empty($coupons)){
			foreach ($coupons as $key => $coupon) {
				$plan = $capsule::table('couponplans')
				->where('id','=',$coupon['coupon_type'])
				->first();
				$user_coupon[$key]['date'] = $coupon['created_at'];
				$user_coupon[$key]['plan'] = $plan['planname'];
			}
		}
	}else{
		$user_err = true;
	}

	
	$data = array(
		'type' => 'admin',
		'site_url'=> Config::$site_url,
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'user_err' => $user_err,
		'op' => $op,
		'coupons' => $user_coupon
		
	);
	
	//var_dump($plan);
	echo $blade->view()->make('admin.user-page',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}