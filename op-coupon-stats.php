<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);
$msg = '';
$flash_msg = '';
$username = '';
$err = array();
$stats = array();
$form = array(
	'patient_id' => '',
	'customer_name' => '',
	'mobile_number' => '',
	'id_proof_type' => '',
);
$cuopon_err = false;
$no_coupons = true;

$user = new UserAccounts;

$images = new Images;

$flash = new FlashMessages;

$capsule = $user->getCapsule();

if ($flash->hasFlashMessage()) {
	$flash_msg = $flash->show();
}

if ($user->isOperator()) {
	$names = $user->getOperatorName();

	if (!isset($_GET['coupon-username']) || empty($_GET['coupon-username']) || strlen($_GET['coupon-username']) == 0) {

		$cuopon_err = true;

	} else {

		$username = filter_var($_GET['coupon-username'], FILTER_SANITIZE_STRING);
		$stats = $capsule::table('radacct')
			->where('username', '=', $username)
			->get();

		if (empty($stats)) {

			$cuopon_err = true;

		} else {

			foreach ($stats as $key => $stat) {
				$stats[$key]['total_download'] = toxbyte($stat['acctinputoctets'] + $stat['acctoutputoctets']);
			}

		}

	}

	$data = array(
		'type' => 'operator',
		'site_url' => Config::$site_url,
		'page_title' => "Coupon Usage",
		'logo_file' => $images->getScreenLogo(),
		'name' => 'Operator',
		'first_name' => $names['first-name'],
		'last_name' => $names['last-name'],
		'msg' => $msg,
		'form' => $form,
		'username' => $username,
		'cuopon_err' => $cuopon_err,
		'flash' => $flash_msg,
		'stats' => $stats,
	);
	echo $blade->view()->make('op.coupon-stat', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}

function toxbyte($size) {
	// Gigabytes
	if ($size > 1073741824) {
		$ret = $size / 1073741824;
		$ret = round($ret, 2) . " Gb";
		return $ret;
	}

	// Megabytes
	if ($size > 1048576) {
		$ret = $size / 1048576;
		$ret = round($ret, 2) . " Mb";
		return $ret;
	}

	// Kilobytes
	if ($size > 1024) {
		$ret = $size / 1024;
		$ret = round($ret, 2) . " Kb";
		return $ret;
	}

	// Bytes
	if (($size != "") && ($size <= 1024)) {
		$ret = $size . " B";
		return $ret;
	}

}