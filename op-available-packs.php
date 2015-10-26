<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
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
$form_stage = 1;
$file_err = false;

$form_data = array(
);
$info = array();

if ($user->isOperator()) {

	$batches = $capsule::table('batch')
		->where('expiry_on', '>', \Carbon\Carbon::now())
		->orderBy('created_at', 'DESC')
		->get();

	foreach ($batches as $batch) {
		$issued_coupons = $capsule::table('batch_coupon')
			->where('status', '=', 2)
			->where('batch_id', '=', $batch['id'])
			->get();
		$printed_coupons = $capsule::table('batch_coupon')
			->where('status', '>', 0)
			->where('batch_id', '=', $batch['id'])
			->get();
		$planname = $capsule::table('couponplans')
			->where('id', '=', $batch['plan'])
			->first();

		array_push($info, array(
			'id' => $batch['id'],
			'batch_name' => $batch['batch_name'],
			'no_of_coupons' => $batch['no_of_coupons'],
			'issued' => count($issued_coupons),
			'plan' => $planname['planname'],
			'printed' => count($printed_coupons),
			'created_at' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $batch['created_at'])->format('Y M, d'),
			'expires' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $batch['expiry_on'])->format('Y M, d'),
		));
	}

	//die(var_dump($info));

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
		'batches' => $info,
	);
	echo $blade->view()->make('op.pack-list', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
