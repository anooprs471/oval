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
$err = array();
$form = array(
	'patient_id' => '',
	'customer_name' => '',
	'mobile_number' => '',
	'id_proof_type' => ''
);
$customer_err = false;

$user = new UserAccounts;

$flash = new Flash_Messages();

$capsule = $user->getCapsule();

if($flash->hasFlashMessage()){
	$flash_msg = $flash->show();
}


if($user->isOperator()){
	$names = $user->getOperatorName();

	$customer_id = $_GET['customer-id'];

	$customer = Customers::where('id', '=', $customer_id)->first();

	$current_plans = $capsule::table('couponplans')->get();

	
	if($customer != null){

		$form['customer_id'] = $customer_id;
		$form['customer_name'] = $customer->customer_name;
		$form['mobile_number'] = $customer->mobile_number;
		$form['id_proof_number'] = $customer->id_proof_number;
		$form['id_proof_type'] = $customer->id_proof_type;
		$form['image-file'] = $customer->id_proof_filename;
		
	}elseif($customer == null){
		$msg = 'patient not found';
		$customer_err = true;
	}


	
	$data = array(
		'type' => 'operator',
		'site_url'=> Config::$site_url,
		'name' => 'Operator',
		'first_name' => $names['first-name'],
		'last_name' => $names['last-name'],
		'msg' => $msg,
		'form' => $form,
		'err' => $err,
		'coupon_plans' => $current_plans,
		'op_id' => $user->getCurrentId(),
		'customer_id' => $customer_id,
		'flash' => $flash_msg,
		'customer_err' => $customer_err
	);
	echo $blade->view()->make('op.customer-page',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}