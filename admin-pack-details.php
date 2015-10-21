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

	$per_page = 25;
	$page = 0;
	$skip = 0;
	$coupon_ids = array();
	$expired = false;

	$coupon_available = $capsule::table('batch_coupon')
		->where('status', '=', 0)
		->where('batch_id', '=', $_GET['batch-id'])
		->count();
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if ($segment->get('coupon_ids') != null) {

			$coupon_ids = $segment->get('coupon_ids');
			$segment->set('coupon_ids', array());
		}
		foreach ($_POST['coupon_id'] as $id) {
			if (is_numeric($id)) {
				array_push($coupon_ids, $id);
			}
		}
		$segment->set('coupon_ids', $coupon_ids);
		header('Location: ' . Config::$site_url . 'admin-pack-details.php?batch-id=' . $_GET['batch-id']);
	}

	if (isset($_GET['batch-id']) && is_numeric($_GET['batch-id']) && !empty($_GET['batch-id'])) {

		if ($segment->get('batch_id') == null) {
			$segment->set('batch_id', $_GET['batch-id']);
			$segment->set('coupon_ids', array());

		} else {
			if ($segment->get('batch_id') != $_GET['batch-id']) {
				$segment->set('coupon_ids', array());
				$segment->set('batch_id', $_GET['batch-id']);
			}
		}

		if ($segment->get('coupon_ids') != null) {
			foreach ($segment->get('coupon_ids') as $id) {
				array_push($coupon_ids, $id);
			}
			$selected = count($coupon_ids);

		}

		//var_dump($segment->get('coupon_ids'));die;

		$batch_id = $_GET['batch-id'];

		$all_batch = $capsule::table('batch_coupon')
			->where('batch_id', '=', $batch_id)
			->whereNotIn('id', $coupon_ids)
			->get();
		$total_records = count($all_batch);
		$total_pages = ceil($total_records / $per_page);

		//var_dump($total_records);die;

		if (isset($_GET['page']) && is_numeric($_GET['page']) && !empty($_GET['page'])) {
			$page = $_GET['page'];
			if ($page > 0 && $page <= $total_pages) {
				$skip = ($page - 1) * $per_page;
			} else {
				$skip = 0;
			}
			$current_page = $page;
		} else {
			$skip = 0;
			$current_page = 1;
		}

		$batch_coupons = $capsule::table('batch_coupon')
			->where('batch_id', '=', $batch_id)
			->whereNotIn('id', $coupon_ids)
			->orderBy('batch_serial_number', 'ASC')
			->take($per_page)
			->skip($skip)
			->get();

		$batch = $capsule::table('batch')
			->where('batch.id', '=', $batch_id)
			->join('couponplans', 'couponplans.id', '=', 'batch.plan')
			->get();
		$expired = \Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('M d Y', $batch[0]['expiry_on']));

	} else {
		header('Location: ' . Config::$site_url . 'admin-pack-list.php');
	}

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Coupon Pack Details",
		'logo_file' => $images->getScreenLogo(),
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'errors' => $err,
		'coupons' => $batch_coupons,
		'batch' => $batch,
		'batch_id' => $batch_id,
		'current_page' => $current_page,
		'total_pages' => $total_pages,
		'selected' => $selected,
		'selected_coupons' => $segment->get('coupon_ids'),
		'expired' => $expired,
		'coupon_available' => $coupon_available,
	);
	echo $blade->view()->make('admin.pack-details', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
