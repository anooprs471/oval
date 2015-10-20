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
$serials = array();
$coupon_ids = array();
$err = array();
$msg = '';

//default row colum
$ROWS = 5;
$COLS = 5;

$form_data = array(
	'batch-name' => '',
	'no-of-coupons' => '',
	'batch-plan' => '',
);

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!isset($_POST['batch-id']) || empty($_POST['batch-id']) || !is_numeric($_POST['batch-id'])) {
			header('Location: ' . Config::$site_url . 'admin-pack-list.php');
		} else {
			$batch_id = $_POST['batch-id'];
		}

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
				->whereIn('batch_coupon.batch_serial_number', $serials)
				->where('batch_coupon.status', '=', 0)
				->where('batch_coupon.batch_id', '=', $batch_id)
				->join('batch', 'batch_coupon.batch_id', '=', 'batch.id')
				->join('couponplans', 'couponplans.id', '=', 'batch.plan')
				->get();
		} else {

			if (!isset($_POST['coupon_id']) || empty($_POST['coupon_id'])) {
				header('Location: ' . Config::$site_url . 'admin-pack-details.php?batch-id=' . $_POST['batch-id']);
			}
			foreach ($_POST['coupon_id'] as $id) {
				if (is_numeric($id)) {
					array_push($coupon_ids, $id);
				}
			}

			// if (isset($_POST['rows']) && is_numeric($_POST['rows']) && strlen($_POST['rows']) > 0) {
			// 	$ROWS = $_POST['rows'];
			// }
			if (isset($_POST['cols']) && is_numeric($_POST['cols']) && strlen($_POST['cols']) > 0) {
				$COLS = ($_POST['cols'] > 5) ? 5 : $_POST['cols'];
			}

			$coupons = $capsule::table('batch_coupon')
				->whereIn('batch_coupon.id', $coupon_ids)
				->join('batch', 'batch_coupon.batch_id', '=', 'batch.id')
				->join('couponplans', 'couponplans.id', '=', 'batch.plan')
				->get();

			// if (ceil(count($coupons) / $COLS) > 5) {
			// 	$COLS = 2;
			// }

		}

	}

	//var_dump($info);die;
	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Coupon Batch",
		'logo_file' => $images->getScreenLogo(),
		'print_logo' => $images->getPrintLogo(),
		'name' => 'Operator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'errors' => $err,
		'coupons' => $coupons,
		'rows' => ceil(count($coupons) / $COLS),
		'cols' => $COLS,
		'coupon_ids' => $coupon_ids,
		'batch_id' => $batch_id,
	);
	echo $blade->view()->make('admin.pack-print-template', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
