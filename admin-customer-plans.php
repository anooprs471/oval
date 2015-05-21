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

$remove_plans = array();
$to_insert_plans = array();
$priced_plans = array();

if($flash->hasFlashMessage()){
	$flash_msg = $flash->show();
}
if($user->isAdmin()){

	$first = $capsule::table('radgroupreply')
	->distinct()
	->select('groupname');

	$oval_plans = $capsule::table('radgroupcheck')
	->union($first)
	->select('groupname')
	->distinct()
	->get();

	if(!empty($oval_plans)){
		$priced_plans = $capsule::table('couponplans')
		->get();

		$priced_plan_names = array_map(function($item){
			return $item['planname'];
		},$priced_plans);

		$oval_plan_names = array_map(function($item){
			return $item['groupname'];
		},$oval_plans);

		foreach ($oval_plan_names as $plan) {
			if(!in_array($plan, $priced_plan_names)){
				array_push($to_insert_plans,array(
					'planname' => $plan,
					'price' => 0,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				));
			}
		}

		$count = 0;
		foreach ($priced_plan_names as $plan) {

			if(!in_array($plan,$oval_plan_names)){

				array_push($remove_plans, array('id'=> $priced_plans[$count]['id']));
			}
			$count++;
		}



		$capsule::table('couponplans')->whereIn('id', $remove_plans)->delete(); 
		if(!empty($to_insert_plans)){
			$capsule::table('couponplans')->insert($to_insert_plans);
		}	

		$priced_plans = $capsule::table('couponplans')
		->get();
	}

	 if($_SERVER['REQUEST_METHOD'] === 'POST'){

	 	$plan_name = $_POST['plan-name'];
	 	$price = $_POST['price'];

		$capsule::table('couponplans')
		->where('planname', '=', $plan_name)
		->update( array('price' => $price,'updated_at' => Carbon::now() ));

		$flash->add('Successfully updated price');

		header('Location: '.Config::$site_url.'admin-customer-plans.php');

	}


	$data = array(
		'type' => 'admin',
		'site_url'=> Config::$site_url,
		'page_title' => "Coupon Plans",
		'name' => 'Administrator',
		'msg' => $msg,
		'priced_plans' => $priced_plans,
		'flash' => $flash_msg
	);
	echo $blade->view()->make('admin.customer-plans',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}