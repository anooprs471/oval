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
$file_err = false;

$user = new UserAccounts;

$flash = new Flash_Messages();

$capsule = $user->getCapsule();

if($flash->hasFlashMessage()){
	$flash_msg = $flash->show();
}


if($user->isOperator()){
	$names = $user->getOperatorName();

	$patient_id = $_GET['patient-id'];

	$customer = Customers::where('patient_id', '=', $patient_id)->first();

	$current_plans = $capsule::table('couponplans')->get();

	
	if($customer != null){

		$form['patient_id'] = $customer->patient_id;
		$form['customer_name'] = $customer->customer_name;
		$form['mobile_number'] = $customer->mobile_number;
		$form['id_proof_type'] = $customer->id_proof_type;
		$form['image-file'] = $customer->id_proof_filename;
		
	}elseif($customer == null){
		$msg = 'patient not found';
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
		'patient_id' => $patient_id,
		'flash' => $flash_msg
	);
	echo $blade->view()->make('op.customer-page',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}