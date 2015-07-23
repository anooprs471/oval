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
$batch_coupons = array();
$batch = array();
$err = array();
$msg = '';

$form_data = array(
	'batch-name' => '',
	'no-of-coupons' => '',
	'batch-plan' => '',
);

if ($user->isAdmin()) {

	if (isset($_GET['batch-id']) && is_numeric($_GET['batch-id'])) {

		$batch_id = $_GET['batch-id'];

		$batch = $capsule::table('batch')
			->where('batch.id', '=', $batch_id)
			->join('couponplans', 'couponplans.id', '=', 'batch.plan')
			->get();

		$batch_coupons = $capsule::table('batch_coupon')
			->where('batch_id', '=', $batch_id)
			->orderBy('used', 'ASC')
			->get();
		//var_dump($batch);die;

	} else {
		$msg = 'invalid batch id';
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
		'coupons' => $batch_coupons,
		'batch' => $batch,
	);
	echo $blade->view()->make('admin.batch-details', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
