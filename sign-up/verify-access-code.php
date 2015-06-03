<?php

// Include the composer autoload file
include_once "../vendor/autoload.php";

// Import the necessary classes
use Aura\Session\SessionFactory;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Philo\Blade\Blade;

$generator = new ComputerPasswordGenerator();

$views = __DIR__ . '../../views';
$cache = __DIR__ . '../../cache';

$blade = new Blade($views, $cache);

$session_factory = new SessionFactory;
$session = $session_factory->newInstance($_COOKIE);

$segment = $session->getSegment('oval/signup');

$session_access_code = $segment->get('access_code');

$form_data = array();
$err = array();

if ($session_access_code == '' || strlen($session_access_code) > 4 || strlen($session_access_code) < 3) {

	$session->destroy();
	header('Location: ' . Config::$site_url . 'sign-up/');

} else {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (!isset($_POST['access-code']) || strlen($_POST['access-code']) > 4 || strlen($_POST['access-code']) < 3) {
			array_push($err, 'Invalid Access Code.');
		} else {
			if ($_POST['access-code'] == $session_access_code) {
				//Access code is valid

				echo 'success';

			} else {
				array_push($err, 'The Access Code is not valid');
			}
		}

	}

	$data = array(
		'site_url' => Config::$site_url,
		'page_title' => "Verify and Sign Up",
		'name' => 'Sign-Up',
		'flash' => $segment->getFlash('message'),
		'form_data' => $form_data,
		'errors' => $err,
	);
	echo $session_access_code;
	echo $blade->view()->make('users.verify-access-code', $data);
}