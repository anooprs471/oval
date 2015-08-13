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

		$plan_type = $_POST['plan-type'];
		$customer_id = $_POST['customer-id'];

		if (!isset($_POST['coupon-valid-till']) || strlen($_POST['coupon-valid-till']) < 10) {
			$flash->add('Invalid date');
			header('Location: ' . Config::$site_url . 'op-customer.php?customer-id=' . $customer_id);
			die;
		} else {
			try {
				$coupon_valid_till = \Carbon\Carbon::createFromFormat('m-d-Y', $_POST['coupon-valid-till']);

			} catch (exception $e) {
				$flash->add('Invalid date');
				header('Location: ' . Config::$site_url . 'op-customer.php?customer-id=' . $customer_id);
				die;
			}
		}

		$generator
			->setUppercase(false)
			->setLowercase(true)
			->setNumbers(false)
			->setSymbols(false)
			->setLength(6);

		$coupon_usernames = $capsule::table('coupons')
			->select('username')
			->get();
		$batch_usernames = $capsule::table('batch_coupon')
			->select('coupon')
			->get();

		foreach ($coupon_usernames as $usr) {
			array_push($usernames, $usr['username']);
		}
		foreach ($batch_usernames as $usr) {
			array_push($usernames, $usr['coupon']);
		}

		$username = $generator->generatePassword();

		while (in_array($username, $usernames)) {
			$username = $generator->generatePassword();
		}

		$password = $generator->generatePassword();

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
					'username' => strtoupper($username),
					'password' => strtoupper($password),
					'coupon_type' => $plan_type,
					'complementary' => $complementary,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				));

			$radcheck_data = array(
				array(
					'username' => strtoupper($username),
					'attribute' => 'Cleartext-Password',
					'op' => ':=',
					'value' => strtoupper($password),
				),
				array(
					'username' => strtoupper($username),
					'attribute' => 'Expiration',
					'op' => ':=',
					'value' => $coupon_valid_till->format('d M Y'),
				),
			);

			$capsule::table('radcheck')
				->insert($radcheck_data);

			$capsule::table('radusergroup')
				->insert(array(
					'username' => strtoupper($username),
					'groupname' => $customer_plan_name,
					'priority' => 0,
				));

			$capsule::table('userinfo')
				->insert(array(
					'username' => strtoupper($username),
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