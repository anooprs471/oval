<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$user = new UserAccounts;

$flash = new FlashMessages;

$images = new Images;

$capsule = $user->getCapsule();

$flash_msg = '';
$msg = '';
$err = array();
$file_err = false;

if ($flash->hasFlashMessage()) {
	$flash_msg = $flash->show();
}

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (file_exists($_FILES['logo-file']['tmp_name'])) {
			$images->addLogo('logo-file');
			$flash->add('Logo Updated');
			header('Location: ' . Config::$site_url . 'admin-logo-upload.php');
		} else {
			array_push($err, 'Upload a image file');
		}

	}

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Upload Logo",
		'logo_file' => $images->getScreenLogo(),
		'logo_big' => $images->getPrintLogo(),
		'name' => 'Administrator',
		'msg' => $err,
		'flash' => $flash_msg,
	);
	echo $blade->view()->make('admin.upload-logo', $data);

} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}