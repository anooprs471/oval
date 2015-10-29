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
$selected_coupons = array();

$form_data = array(
	'batch-name' => '',
	'no-of-coupons' => '',
	'batch-plan' => '',
);

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$batch_id = $_POST['batch-id'];

		$capsule::table('batch_coupon')
			->where('status', '<', 2)
			->where('batch_id', '=', $batch_id)
			->delete();

		$batch_count = $capsule::table('batch_coupon')
			->where('batch_id', '=', $batch_id)
			->count();

		if ($batch_count < 1) {
			$capsule::table('batch')
				->where('id', '=', $batch_id)
				->delete();

		} else {
			$capsule::table('batch')
				->where('id', '=', $batch_id)
				->update(
					array(
						'no_of_coupons' => $batch_count,
					)
				);
		}

		$flash->add('Successfully Updated');

		header('Location: ' . Config::$site_url . 'admin-pack-list.php');

	}
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
