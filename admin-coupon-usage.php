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

$capsule = $user->getCapsule();

$patient_details = array();

$msg = '';

$date_err = false;

$data_err = false;

if($user->isAdmin()){


	if($_SERVER['REQUEST_METHOD'] === 'POST'){

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

		$plan_detail = $capsule::table('couponplans')
		->where('id','=',$plan_type)
		->first();

		if(!empty($plan_detail)){
			$plan_name = $plan_detail['planname'];
		}else{
			$plan_name = 'all';
		}

		if(!$date_err){

			if($plan_type == 'all'){
				$plans = $capsule::table('coupons')
				->whereBetween('created_at', array($fr_date,$t_date))
				->get();
			}else{
				$plans = $capsule::table('coupons')
				->where('coupon_type','=',$plan_type)
				->whereBetween('created_at', array($fr_date,$t_date))
				->get();
			}

			$data_date = 'from <strong>'.$fr_date->format('Y/M/d').'</strong> to <strong>'.$t_date->format('Y/M/d').'</strong> of <strong>'.$plan_name.'</strong> plan';

		}else{
			$msg = 'date error '.$from_date.' '.$to_date;
		}

	}

	$data = array(
		'type' => 'admin',
		'site_url'=> Config::$site_url,
		'page_title' => "Admin Coupon Usage",
		'name' => 'Administrator',
		'msg' => $msg,
		'plans' => $plans
	);


	echo $blade->view()->make('admin.plan-usage',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}