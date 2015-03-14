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
$previous_coupons = array();
$form = array(
	'patient_id' => '',
	'customer_name' => '',
	'mobile_number' => '',
	'id_proof_type' => ''
);
$customer_err = false;
$no_coupons = true;

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

	$first = $capsule::table('radgroupreply')
	->distinct()
	->select('groupname');

	$current_plans = $capsule::table('radgroupcheck')
	->union($first)
	->select('groupname')
	->distinct()
	->get();

	$coupon_plans = array();

	foreach ($current_plans as $key => $plan) {
		$price = $capsule::table('couponplans')
		->where('planname','=', $plan['groupname'])
		->first();

		if($price != null){
			array_push($coupon_plans,array('plan' => $plan['groupname'],'price' => $price['price']));
		}
	}

	//var_dump($coupon_plans);


	
	if($customer != null){

		$form['patient_id'] = $customer->patient_id;
		$form['customer_id'] = $customer_id;
		$form['customer_name'] = $customer->customer_name;
		$form['mobile_number'] = $customer->mobile_number;
		$form['id_proof_number'] = $customer->id_proof_number;
		$form['id_proof_type'] = $customer->id_proof_type;
		$form['image-file'] = $customer->id_proof_filename;

		if($customer->patient_id != 'NON-PATIENT'){

			$previous_coupons = $capsule::table('coupons')
			->where('patient_id','=',$customer->patient_id)
			->orderby('created_at')
			->get();


			 if(!empty($previous_coupons)){
			 		$no_coupons = false;

			 		foreach ($previous_coupons as $key => $coupon) {
			 			$previous_coupons[$key]['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $coupon['created_at'])
						->toFormattedDateString();
			 		}

			 }

		}


		
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
		'coupon_plans' => $coupon_plans,
		'op_id' => $user->getCurrentId(),
		'customer_id' => $customer_id,
		'flash' => $flash_msg,
		'customer_err' => $customer_err,
		'no_coupons' => $no_coupons,
		'previous_coupons' => $previous_coupons
	);
	echo $blade->view()->make('op.customer-page',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}