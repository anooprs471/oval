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
	if (isset($_GET['image']) && strlen($_GET['image']) > 0) {
		if (filter_var(trim($_GET['image']), FILTER_VALIDATE_INT)) {
			$image_id = $_GET['image'];

			$images->removeImage($image_id);

		}

	}
	header('Location: ' . Config::$site_url . 'admin-ads-upload.php');
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}