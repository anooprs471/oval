<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;
use Carbon\Carbon;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';


$msg = '';
$flash_msg = '';
$form = array(
	'patient_id' => '',
	'customer_name' => '',
	'mobile_number' => '',
	'id_proof_type' => ''
);

$user = new UserAccounts;

$capsule = $user->getCapsule();

$blade = new Blade($views, $cache);
$flash = new Flash_Messages();

if($flash->hasFlashMessage()){
	$flash_msg = $flash->show();
}
if($user->isAdmin()){

	$radcheck_plans = $capsule::table('radgroupcheck')->get();

	$radgroupreply_plans = $capsule::table('radgroupreply')->get();

	$current_plans = $capsule::table('couponplans')->get();

	$tempplan = array();
	$toaddplan = array();

	foreach ($current_plans as $key => $value) {
		array_push($tempplan,$value['planname']);
	}

	foreach ($radcheck_plans as $plan) {

		if(!in_array($plan['groupname'],$tempplan)){
			array_push($toaddplan,$plan['groupname']);
		}
	}
	foreach ($radgroupreply_plans as $plan) {

		if(!in_array($plan['groupname'],$tempplan)){
			array_push($toaddplan,$plan['groupname']);
		}
	}

	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		if($_POST['form-type'] == 'update'){
			$plan_id = $_POST['plan-id'];
			$price = $_POST['price'];

			$capsule::table('couponplans')
			->where('id', '=', $plan_id)
			->update(array('price' => $price));

			$flash->add('Successfully updated price');
			
			header('Location: '.Config::$site_url.'admin-customer-plans.php');


		}elseif ($_POST['form-type'] == 'add-plan') {
			if(!isset($_POST['price']) || empty($_POST['price'])){
				$price = 0;
			}
			$price = $_POST['price'];
			$plan_name = $_POST['plan-name'];

			$capsule::table('couponplans')
			->insert(array('planname' => $plan_name,
										 'price' => $price));
			$flash->add('Added new plan');
			
			header('Location: '.Config::$site_url.'admin-customer-plans.php');
		}

	}


	$data = array(
		'type' => 'admin',
		'site_url'=> Config::$site_url,
		'name' => 'Administrator',
		'msg' => $msg,
		'to_add_plans' => $toaddplan,
		'current_plans' => $current_plans,
		'flash' => $flash_msg
	);
	echo $blade->view()->make('admin.customer-plans',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}