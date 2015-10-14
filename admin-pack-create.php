<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Carbon\Carbon;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$user = new UserAccounts;

$images = new Images;

$flash = new Flash_Messages();
$generator = new ComputerPasswordGenerator();

$capsule = $user->getCapsule();

$flash_msg = '';

if ($flash->hasFlashMessage()) {
	$flash_msg = $flash->show();
}

$err = array();
$msg = '';
$usernames = array();
$new_usernames = array();
$new_coupon = array();
$radcheck = array();
$radusergroup = array();
$batch_coupon = array();

$form_data = array(
	'batch-name' => '',
	'no-of-coupons' => '',
	'batch-plan' => '',
	'expires-on' => '',
);

$current_coupon_plans = $capsule::table('couponplans')->get();

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (isset($_POST['batch-name']) && strlen(trim($_POST['batch-name'])) > 5) {
			$batch_name = trim($_POST['batch-name']);
			$form_data['batch-name'] = $batch_name;
		} else {
			array_push($err, 'Invalid Batch Name');
		}

		if (isset($_POST['no-of-coupons']) && strlen(trim($_POST['no-of-coupons'])) > 0 && is_numeric($_POST['no-of-coupons'])) {
			$no_of_coupons = trim($_POST['no-of-coupons']);
			$form_data['no-of-coupons'] = $no_of_coupons;
		} else {
			array_push($err, 'Invalid Coupon Number');
		}

		if (isset($_POST['batch-plan']) && strlen(trim($_POST['batch-plan'])) > 0 && is_numeric($_POST['batch-plan'])) {
			$batch_plan = trim($_POST['batch-plan']);
			$form_data['batch-plan'] = $batch_plan;
		} else {
			array_push($err, 'Invalid Plan');
		}

		if (isset($_POST['expires-on']) && strlen(trim($_POST['expires-on'])) > 0 && is_numeric($_POST['expires-on'])) {
			$expires_on = trim($_POST['expires-on']);
			$form_data['expires-on'] = $expires_on;
		} else {
			array_push($err, 'Invalid Batch Expiry Date');
		}

		if (empty($err)) {

			$batch = array(
				'batch_name' => $batch_name,
				'no_of_coupons' => $no_of_coupons,
				'plan' => $batch_plan,
				'expiry_on' => Carbon::now()->addDays($expires_on)->format('M d Y'),
				'created_at' => Carbon::now(),
			);

			//get plan
			$plan = $capsule::table('couponplans')
				->where('id', '=', $batch_plan)
				->first();

			//create a new batch in db
			$batch_id = $capsule::table('batch')
				->insertGetId($batch);

			//fil coupons for the batch

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

			for ($i = 0; $i < $no_of_coupons; $i++) {
				$username = $generator->generatePassword();

				while (in_array($username, $usernames) && in_array($username, $new_usernames)) {
					$username = $generator->generatePassword();
				}
				$password = $generator->generatePassword();

				// array_push($radcheck, array(
				// 	'username' => $username,
				// 	'attribute' => 'Cleartext-Password',
				// 	'op' => ':=',
				// 	'value' => $password,
				// ));

				// array_push($radusergroup, array(
				// 	'username' => $username,
				// 	'groupname' => $plan['planname'],
				// 	'priority' => 0,
				// ));

				array_push($new_usernames, $username);

				array_push($batch_coupon, array(
					'batch_id' => $batch_id,
					'coupon' => strtoupper($username),
					'batch_serial_number' => $i + 1,
					'password' => strtoupper($password),
					'status' => 0,
				));

			}

			// $capsule::table('radcheck')
			// 	->insert($radcheck);

			// $capsule::table('radusergroup')
			// 	->insert($radusergroup);

			$capsule::table('batch_coupon')
				->insert($batch_coupon);

			$flash->add('Successfully Created A Batch');

			header('Location: ' . Config::$site_url . 'admin-batch-list.php');

		}

	}

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Create Plan",
		'logo_file' => $images->getScreenLogo(),
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'form_data' => $form_data,
		'errors' => $err,
		'plans' => $current_coupon_plans,
	);
	echo $blade->view()->make('admin.batch-create', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
