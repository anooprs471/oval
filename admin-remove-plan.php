<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';



$user = new UserAccounts;

$flash = new Flash_Messages();

$capsule = $user->getCapsule();

$flash_msg = '';

if($user->isAdmin()){

	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		if( isset($_POST['plan-name']) && strlen(trim($_POST['plan-name'])) > 0 ){

			$plan_name = filter_var(trim($_POST['plan-name']));


			$capsule::table('radgroupcheck')
			->where('groupname', '=', $plan_name)
			->delete();

			$capsule::table('radgroupreply')
			->where('groupname', '=', $plan_name)
			->delete();
			
			$capsule::table('couponplans')
			->where('planname', '=', $plan_name)
			->delete();

			$flash->add('Plan removed updated');
			header('Location: '.Config::$site_url.'admin-customer-plans.php');

		}



	}
	header('Location: '.Config::$site_url.'admin-customer-plans.php');

}else{
	header('Location: '.Config::$site_url.'logout.php');
}