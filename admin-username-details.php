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

	if (!isset($_GET['username']) || strlen($_GET['username']) == 0) {
		$data_err = true;
	} else {
		$username = $_GET['username'];
	}

	if (!$data_err) {

		$username_details = $capsule::table('coupons')
			->where('coupons.username', '=', $username)
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

	}

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'name' => 'Administrator',
		'logo_file' => $images->getScreenLogo(),
		'page_title' => "Patient Usage Details",
		'msg' => $msg,
		'username_details' => $username_details,
	);

	echo $blade->view()->make('admin.username-details', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}