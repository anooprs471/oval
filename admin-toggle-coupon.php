<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Aura\Session\SessionFactory;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

//manage session
$session_factory = new SessionFactory;
$session = $session_factory->newInstance($_COOKIE);
$session->setCookieParams(array('lifetime' => '1800')); //30 seconds
$segment = $session->getSegment('admin/batch');

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
$selected = 0;
$serials = array();
$status = 0;

if ($user->isAdmin()) {

	$username = $_GET['username'];
	$auth_type = $_GET['auth-type'];
	$batch_id = $_GET['batch-id'];

	$radcheck = $capsule::table('radcheck')
		->where('username', '=', $username)
		->count();

	if ($radcheck == 0) {
		$capsule::table('radcheck')
			->insert(
				array(
					'username' => $username,
					'attribute' => 'Auth-Type',
					'op' => ':=',
					'value' => $auth_type,
				)
			);
	} else {
		$capsule::table('radcheck')
			->where('username', '=', $username)
			->where('attribute', '=', 'Auth-Type')
			->update(
				array(
					'value' => $auth_type,
				)
			);
	}

	if ($auth_type == 'Accept') {
		$status = 2;
	} elseif ($auth_type == 'Reject') {
		$status = 3;
	}

	$capsule::table('batch_coupon')
		->where('coupon', '=', $username)
		->where('batch_id', '=', $batch_id)
		->update(array(
			'status' => $status,
		));
	header('Location: ' . Config::$site_url . 'admin-pack-details.php?batch-id=' . $batch_id);

} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
