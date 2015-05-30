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

$capsule = $user->getCapsule();

$users = $user->listOperators();

$msg = '';

$flash_msg = '';

if ($flash->hasFlashMessage()) {
	$flash_msg = $flash->show();
}

$required_password_length = 4;

$form_err = false;

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (!isset($_POST['old-password']) || strlen($_POST['old-password']) < $required_password_length) {
			$form_err = true;

		}

		if (!isset($_POST['new-password']) || strlen($_POST['new-password']) < $required_password_length) {
			$form_err = true;
		}

		if (!$form_err) {

			$old_password = filter_var($_POST['old-password'], FILTER_SANITIZE_STRING);
			$new_password = filter_var($_POST['new-password'], FILTER_SANITIZE_STRING);

			$msg = $user->operatorChangePassword($old_password, $new_password);

			if ($msg == 'Password reset passed') {
				$flash->add('Password changed');
				header('Location: ' . Config::$site_url . 'admin-change-password.php');
			}

		} else {
			$msg = 'Error changing password! please retry';
		}

	}

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Admin Dashboard",
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
	);

	echo $blade->view()->make('admin.change-password', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}