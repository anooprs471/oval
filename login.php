<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;
$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$user = new UserAccounts;
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$username = $_POST['username'];
	$password = $_POST['password'];
	$remember = false;
	if (isset($_POST['remember']) && $_POST['remember'] == 'remember') {
		$remember = true;
	}

	$filtered_username = filter_var($username, FILTER_SANITIZE_STRING);
	$filtered_password = filter_var($password, FILTER_SANITIZE_STRING);

	$msg = $user->login($filtered_username, $filtered_password, $remember);

	if ($user->isLoggedIn()) {
		if ($user->isOperator()) {
			header('Location: ' . Config::$site_url . 'op-home.php');
		} elseif ($user->isAdmin()) {
			header('Location: ' . Config::$site_url . 'admin-home.php');
		}
	}

}

$data = array(
	'msg' => $msg,
);

echo $blade->view()->make('login', $data);
