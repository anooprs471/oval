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
$coupon = array();
$err = array();
$msg = '';
$form_stage = 1;
$file_err = false;

$form_data = array(
	'coupon_valid_till' => '',
	'username' => '',
	'password' => '',
	'customer_name' => '',
	'mobile_number' => '',
	'id_proof_type' => '',
	'id_proof_number' => '',
	'planname' => '',
	'customer_id' => '',
);

if ($user->isOperator()) {

	//var_dump($coupon_valid_till);die;

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['username']) && strlen($_POST['username']) > 4) {

			$username = $_POST['username'];
			$form_stage = $_POST['form-stage'];

			if ($form_stage == 1) {
				$coupon = $capsule::table('batch_coupon')
					->where('coupon', '=', $username)
					->where('status', '=', 1)
					->get();
				if (!empty($coupon)) {
					$plan = $capsule::table('batch')
						->where('batch.id', '=', $coupon[0]['batch_id'])
						->join('couponplans', 'batch.plan', '=', 'couponplans.id')
						->get();
				}

				if (empty($coupon)) {
					array_push($err, 'No username found. try again');
				} else {
					$form_stage = 2;

					//var_dump($plan);die;
					$form_data['username'] = $coupon[0]['coupon'];
					$form_data['password'] = $coupon[0]['password'];
					$form_data['planname'] = $plan[0]['planname'];

				}
			} elseif ($form_stage == 2) {

				$form_data['username'] = $_POST['username'];
				$form_data['password'] = $_POST['password'];
				$form_data['planname'] = $_POST['planname'];

				//process customer form
				//

				if (!isset($_POST['customer-id']) || strlen($_POST['customer-id']) < 1) {
					array_push($err, 'Customer ID not provided or too small');
				} else {
					$customer_id = ucwords(filter_var($_POST['customer-id'], FILTER_SANITIZE_STRING));
					$form_data['customer_id'] = $customer_id;
				}

				if (empty($err)) {

					//fill tables - coupons, customers,

					$customer = new Customers;

					$customer->patient_id = $form_data['customer_id'];
					// $customer->customer_name = ucwords($form_data['customer_name']);
					// $customer->mobile_number = $form_data['mobile_number'];
					// $customer->id_proof_type = $form_data['id_proof_type'];
					// $customer->id_proof_number = $form_data['id_proof_number'];
					// $customer->id_proof_filename = $filename;
					// $customer->operator_id = $user->getCurrentId();

					$customer->save();

					$coupon_id = $capsule::table('coupons')
						->insertGetId(array(
							'customer_id' => $customer->id,
							'op_id' => $user->getCurrentId(),
							'patient_id' => $form_data['customer_id'],
							'username' => $form_data['username'],
							'password' => $form_data['password'],
							'coupon_type' => $form_data['planname'],
							'complementary' => 0,
							'created_at' => Carbon::now(),
							'updated_at' => Carbon::now(),
						));

					$radcheck_data = array(
						array(
							'username' => $form_data['username'],
							'attribute' => 'Cleartext-Password',
							'op' => ':=',
							'value' => $form_data['password'],
						),
					);

					$capsule::table('radcheck')
						->insert($radcheck_data);

					$capsule::table('radusergroup')
						->insert(array(
							'username' => $form_data['username'],
							'groupname' => $form_data['planname'],
							'priority' => 0,
						));

					$capsule::table('userinfo')
						->insert(array(
							'username' => $form_data['username'],
							'firstname' => $form_data['customer_name'],
							'mobilephone' => $form_data['mobile_number'],
							'mobilephone' => $form_data['mobile_number'],
							'creationdate' => Carbon::now(),
							'updatedate' => Carbon::now(),
							'creationby' => $user->getCurrentId(),
						));
					$capsule::table('batch_coupon')
						->where('coupon', '=', $form_data['username'])
						->update(array('status' => 2));

					$flash->add('Successfully added customer');
					header('Location: ' . Config::$site_url . 'op-batch-issue.php');

				}

			}

		} else {
			array_push($err, 'Invalid Username');
		}
	}

	//var_dump($info);die;
	$data = array(
		'type' => 'operator',
		'site_url' => Config::$site_url,
		'page_title' => "Coupon Batch",
		'logo_file' => $images->getScreenLogo(),
		'name' => 'Operator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'errors' => $err,
		'form' => $form_data,
		'form_stage' => $form_stage,
	);
	echo $blade->view()->make('op.batch-issue', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
