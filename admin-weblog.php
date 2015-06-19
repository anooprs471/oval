<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$user = new UserAccounts;

$images = new Images;

$capsule = $user->getCapsule();

$patient_details = array();

$msg = '';

$flash_msg = '';

$data_err = false;

if ($user->isAdmin()) {

	$logs = $capsule::select($capsule::raw('SELECT DISTINCT b.username, b.callingstationid, a.request_url, DATE(FROM_UNIXTIME(a.time_since_epoch)) FROM access_log a, radacct b where b.framedipaddress = a.client_src_ip_addr and FROM_UNIXTIME(a.time_since_epoch) BETWEEN b.acctstarttime AND b.acctstoptime'));

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'name' => 'Administrator',
		'page_title' => "Operator Details",
		'logo_file' => $images->getScreenLogo(),
		'msg' => $msg,
		'flash' => $flash_msg,
		'weblog' => $logs,
	);

	echo $blade->view()->make('admin.weblog', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}