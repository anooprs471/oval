<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Carbon\Carbon;


$complementary = 0;

$user = new UserAccounts;

$capsule = $user->getCapsule();

$generator = new ComputerPasswordGenerator();

$usernames = array();

if($user->isOperator()){
	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		$generator
		  ->setUppercase(false)
		  ->setLowercase(true)
		  ->setNumbers(false)
		  ->setSymbols(false)
		  ->setLength(6);

		$coupon_usernames = $capsule::table('coupons')
		->select('username')
		->get();

		foreach ($coupon_usernames as $usr) {
			array_push($usernames,$usr['username']);
		}

		$username = $generator->generatePassword();

		while(in_array($username,$usernames)){
			$username = $generator->generatePassword();
		}

		$generator->setLength(4);

		$password = $generator->generatePassword();

		$plan_id = $_POST['plan-id'];
		$patient_id = $_POST['patient-id'];

		$plan_price = $capsule::table('couponplans')
		->select('price')
		->first();

		if($plan_price['price'] > 0){
			$complementary = 1;
		}

		$coupon_id = $capsule::table('coupons')
		->insertGetId(array(
			'patient_id' => $patient_id, 
			'op_id' => $user->getCurrentId(),
			'username' => $username,
			'password' => $password,
			'coupon_type' => $plan_id,
			'complementary' => $complementary,
			'created_at' => Carbon::now(),
			'updated_at' =>	Carbon::now()
			));
		$capsule::table('radreply')
		->insert(array(
			'username' => $username,
			'value' => $password
			));

		header('Location: '.Config::$site_url.'print-coupon.php?coupon-id='.$coupon_id);
	}
	
}else{
	header('Location: '.Config::$site_url.'logout.php');
}