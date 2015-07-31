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
$info = array();
$err = array();
$msg = '';

$form_data = array(
	'batch-name' => '',
	'no-of-coupons' => '',
	'batch-plan' => '',
);

if ($user->isAdmin()) {

	$batches = $capsule::table('batch')
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

		array_push($info, array(
			'id' => $batch['id'],
			'batch_name' => $batch['batch_name'],
			'no_of_coupons' => $batch['no_of_coupons'],
			'issued' => count($issued_coupons),
			'printed' => count($printed_coupons),
			'created_at' => $batch['created_at'],
		));
	}

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Coupon Batch",
		'logo_file' => $images->getScreenLogo(),
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'errors' => $err,
		'batches' => $info,
	);
	echo $blade->view()->make('admin.batch-list', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
