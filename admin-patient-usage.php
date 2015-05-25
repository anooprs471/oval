<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$user = new UserAccounts;

$images = new Images;

$capsule = $user->getCapsule();

$patient_details = array();

$msg = '';

$data_err = false;

if ($user->isAdmin()) {

	if (!isset($_GET['patient-id']) || strlen($_GET['patient-id']) == 0) {
		$data_err = true;
	} else {
		$patient_id = $_GET['patient-id'];
	}

	if (!$data_err) {

		$patient_details = $capsule::table('coupons')
			->where('coupons.patient_id', '=', $patient_id)
			->join('customers', 'customers.id', '=', 'coupons.customer_id')
			->join('couponplans', 'couponplans.planname', '=', 'coupons.coupon_type')
			->join('users', 'users.id', '=', 'coupons.op_id')
			->select(
				'coupons.username as username',
				'customers.customer_name as name',
				'customers.id_proof_number as id_proof_number',
				'customers.id_proof_filename as filename',
				'couponplans.planname as plan_name',
				'users.username as operator',
				'users.id as op_id',
				'coupons.created_at as date'
			)
			->get();

		//var_dump($patient_details);
	}

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'name' => 'Administrator',
		'page_title' => "Patient Usage Details",
		'logo_file' => $images->getScreenLogo(),
		'msg' => $msg,
		'patient_id' => $patient_id,
		'patient_details' => $patient_details,
	);

	echo $blade->view()->make('admin.patient-usage', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}