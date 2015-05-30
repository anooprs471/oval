<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

use Carbon\Carbon;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

$complementary = 0;

$user = new UserAccounts;

$flash = new FlashMessages;

$capsule = $user->getCapsule();

$generator = new ComputerPasswordGenerator();

$usernames = array();

if ($user->isOperator()) {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
			array_push($usernames, $usr['username']);
		}

		$username = $generator->generatePassword();

		while (in_array($username, $usernames)) {
			$username = $generator->generatePassword();
		}

		$password = $generator->generatePassword();

		$plan_type = $_POST['plan-type'];
		$customer_id = $_POST['customer-id'];

		$customer_plan = $capsule::table('couponplans')
			->where('planname', '=', $plan_type)
			->first();

		$customer = $capsule::table('customers')
			->where('id', '=', $customer_id)
			->first();

		if ($customer_plan != null && $customer != null) {

			if ($customer_plan['price'] == 0) {
				$complementary = 1;
			}
			$customer_plan_name = $customer_plan['planname'];

			$coupon_id = $capsule::table('coupons')
				->insertGetId(array(
					'customer_id' => $customer_id,
					'op_id' => $user->getCurrentId(),
					'patient_id' => $customer['patient_id'],
					'username' => $username,
					'password' => $password,
					'coupon_type' => $plan_type,
					'complementary' => $complementary,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				));

			$capsule::table('radcheck')
				->insert(array(
					'username' => $username,
					'attribute' => 'Cleartext-Password',
					'op' => ':=',
					'value' => $password,
				));

			$capsule::table('radusergroup')
				->insert(array(
					'username' => $username,
					'groupname' => $customer_plan_name,
					'priority' => 0,
				));

			$capsule::table('userinfo')
				->insert(array(
					'username' => $username,
					'firstname' => $customer['customer_name'],
					'mobilephone' => $customer['mobile_number'],
					'mobilephone' => $customer['mobile_number'],
					'creationdate' => Carbon::now(),
					'updatedate' => Carbon::now(),
					'creationby' => $customer['id'],
				));
			$flash->add('Successfully generated coupon');
			header('Location: ' . Config::$site_url . 'op-print-coupon.php?coupon-id=' . $coupon_id);
		} else {
			$flash->add('Wrong customer id or plan id. please retry');
			header('Location: ' . Config::$site_url . 'op-generate-coupon.php?coupon-id=' . $customer_id);

		}

	}

} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}