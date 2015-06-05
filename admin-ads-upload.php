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

		if ($_POST['upload-type'] == 'login-screen-right') {

			if (file_exists($_FILES['upload']['tmp_name'])) {
				$images->addLoginScreenRightAd('upload');
				$flash->add('Login screen Ad updated');
				header('Location: ' . Config::$site_url . 'admin-ads-upload.php');
			} else {
				array_push($err, 'Upload a image file');
			}

		} elseif ($_POST['upload-type'] == 'login-screen-bottom') {

			if (file_exists($_FILES['upload']['tmp_name'])) {
				$images->addLoginScreenBottomAd('upload');
				$flash->add('Login screen Ad updated');
				header('Location: ' . Config::$site_url . 'admin-ads-upload.php');
			} else {
				array_push($err, 'Upload a image file');
			}

		} elseif ($_POST['upload-type'] == 'scroll-ads') {
			$images->addScrollAds('upload');
			$flash->add('Scroll Ads updated');
			header('Location: ' . Config::$site_url . 'admin-ads-upload.php');
		}

	}

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Upload Logo",
		'logo_file' => $images->getScreenLogo(),
		'ad_login_right' => $images->getLoginRightAd(),
		'ad_login_bottom' => $images->getLoginBottomAd(),
		'scroll_ads' => $images->getScrollAds(),
		'name' => 'Administrator',
		'msg' => $err,
		'flash' => $flash_msg,
	);
	echo $blade->view()->make('admin.upload-ads', $data);

} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}