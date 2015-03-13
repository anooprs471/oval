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
$date_err = false;
$data_date = 'till '.Carbon::now().' of all plan';

$user_coupon = array();




if($user->isAdmin()){


	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		$user_id = filter_var($_POST['user-id'], FILTER_SANITIZE_STRING);

		if(!isset($_POST['date-from']) || strlen($_POST['date-from']) == 0 ){
			$fr_date = Carbon::create(2014, 1, 1, 12);
		}else{
			$from_date = filter_var($_POST['date-from'], FILTER_SANITIZE_STRING);
			try {
		    $fr_date = Carbon::createFromFormat('m/d/Y', $from_date);
			} catch (Exception $e) {
				$date_err = true;
			}
		}

		if(!isset($_POST['date-to']) || strlen($_POST['date-to']) == 0 ){
			$t_date = Carbon::now();
		}else{
			$to_date = filter_var($_POST['date-to'], FILTER_SANITIZE_STRING);
			try {
		    $t_date = Carbon::createFromFormat('m/d/Y', $to_date);
			} catch (Exception $e) {
				$date_err = true;
			}
		}

		$plan_type = $_POST['plan-type'];




		if(!$date_err){
			$op = $capsule::table('users')
			->where('id','=',$user_id)
			->first();

			if(!empty($op)){
				 //echo $user_id;
				if($plan_type == 'all'){
					$coupons = $capsule::table('coupons')
					->where('op_id','=',$user_id)
					->whereBetween('created_at', array($fr_date,$t_date))
					->get();
					$plan_name = 'all';
				}else{
					$coupons = $capsule::table('coupons')
					->where('op_id','=',$user_id)
					->where('coupon_type','=',$plan_type)
					->whereBetween('created_at', array($fr_date,$t_date))
					->get();

					$current_plan = $capsule::table('couponplans')
					->where('id','=',$plan_type)
					->first();

					$plan_name = $current_plan['planname'];
				}
				
				



			}

			$data_date = 'from <strong>'.$fr_date->format('Y/M/d').'</strong> to <strong>'.$t_date->format('Y/M/d').'</strong> of <strong>'.$plan_name.'</strong> plan';


		}else{
			$msg = 'date error '.$from_date.' '.$to_date;
		}

	}else{
		if(!isset($_GET['id']) || empty($_GET['id']) || strlen($_GET['id']) == 0){
			$user_err = true;
			$msg = 'User id error';
			$user_id = '';
		}else{
			$user_id = $_GET['id'];
		}
		$op = $capsule::table('users')
		->where('id','=',$user_id)
		->first();

		if(!empty($op)){
			$coupons = $capsule::table('coupons')
			->where('op_id','=',$user_id)
			->get();
		}


	}

	$first = $capsule::table('radgroupreply')
	->distinct()
	->select('groupname');

	$plans = $capsule::table('radgroupcheck')
	->union($first)
	->select('groupname')
	->distinct()
	->get();


	$data = array(
		'type' => 'admin',
		'site_url'=> Config::$site_url,
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'user_err' => $user_err,
		'op' => $op,
		'coupons' => $coupons,
		'user_id' => $user_id,
		'data_date' => $data_date,
		'plans' => $plans
		
	);
	
	echo $blade->view()->make('admin.user-page',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}