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

if ($user->isOperator()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (isset($_POST['from-serial']) && !empty($_POST['from-serial']) && is_numeric($_POST['from-serial']) && isset($_POST['to-serial']) && !empty($_POST['to-serial']) && is_numeric($_POST['to-serial'])) {

			$from = $_POST['from-serial'];
			$to = $_POST['to-serial'];

			if ($to <= $from) {
				$to = $from;
			}

			for ($i = $from; $i <= $to; $i++) {
				array_push($serials, $i);
			}

			$coupons = $capsule::table('batch_coupon')
				->whereIn('batch_serial_number', $serials)
				->where('status', '=', 1)
				->where('batch_id', '=', $batch_id)
				->get();

		}

		$coupon_id = $_POST['coupon-id'];

		$batch_id = $_POST['batch-id'];

		$batch = $capsule::table('batch')
			->where('id', '=', $batch_id)
			->first();

		$coupon = $capsule::table('batch_coupon')
			->where('id', '=', $coupon_id)
			->first();

		$plan = $capsule::table('couponplans')
			->where('id', '=', $batch['plan'])
			->first();

		$radcheck_data = array(
			array(
				'username' => $coupon['coupon'],
				'attribute' => 'Cleartext-Password',
				'op' => ':=',
				'value' => $coupon['password'],
			),
			array(
				'username' => $coupon['coupon'],
				'attribute' => 'Expiration',
				'op' => ':=',
				'value' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $batch['expiry_on'])->format('d M Y'),
			),
		);

		$capsule::table('radcheck')
			->insert($radcheck_data);

		$capsule::table('radusergroup')
			->insert(array(
				'username' => $coupon['coupon'],
				'groupname' => $plan['planname'],
				'priority' => 0,
			));

		$capsule::table('batch_coupon')
			->where('id', '=', $coupon_id)
			->update(array('status' => 2));

		$flash->add('Successfully activated coupon');
		header('Location: ' . Config::$site_url . 'op-pack-details.php?batch-id=' . $batch_id);
	}

} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
