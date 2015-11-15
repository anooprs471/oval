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
$serials = array();
$form_data = array(
	'batch-name' => '',
	'no-of-coupons' => '',
	'batch-plan' => '',
);

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (isset($_POST['from-serial']) && !empty($_POST['from-serial']) && is_numeric($_POST['from-serial']) && isset($_POST['to-serial']) && !empty($_POST['to-serial']) && is_numeric($_POST['to-serial'])) {

			$from = $_POST['from-serial'];
			$to = $_POST['to-serial'];

		}

		if ($to <= $from) {
			$to = $from;
		}

		for ($i = $from; $i <= $to; $i++) {
			array_push($serials, $i);
		}

		$batch_id = $_POST['batch-id'];

		$capsule::table('batch_coupon')
			->whereIn('batch_serial_number', $serials)
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
			$flash->add('Pack List Updated');
			header('Location: ' . Config::$site_url . 'admin-pack-list.php');

		} else {
			$capsule::table('batch')
				->where('id', '=', $batch_id)
				->update(
					array(
						'no_of_coupons' => $batch_count,
					)
				);

			$issued_coupons = $capsule::table('batch_coupon')
				->where('batch_id', '=', $batch_id)
				->where('status', '=', 2)
				->whereIn('batch_serial_number', $serials)
				->get();

			//var_dump($issued_coupons);die;

			foreach ($issued_coupons as $coupon) {
				$capsule::table('radcheck')
					->insert(array(
						'username' => $coupon['coupon'],
						'attribute' => 'Auth-Type',
						'op' => ':=',
						'value' => 'Reject',
					));

				$capsule::table('batch_coupon')
					->where('batch_id', '=', $batch_id)
					->where('coupon', '=', $coupon['coupon'])
					->update(
						array(
							'status' => 3,
						)
					);
			}
		}

		$flash->add('Successfully Updated');

		header('Location: ' . Config::$site_url . 'admin-pack-details.php?batch-id=' . $batch_id);

	}
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
