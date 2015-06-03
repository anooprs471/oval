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

$form_data = array(
	'phone-number' => '',
);
$err = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$form_data['phone-number'] = $_POST['phone-number'];

	if (isset($_POST['phone-number']) && strlen(trim($_POST['phone-number'])) > 9) {

		if (is_numeric($_POST['phone-number'])) {

			//generate an access key and store in session with number
			//send access code to the phone number by sms
			//redirect to validate access key page

			$generator->setLowercase(true)
			          ->setUppercase(false)
			          ->setNumbers(false)
			          ->setSymbols(false)
			          ->setLength(4);

			$access_key = $generator->generatePasswords(1)[0];

			//connect to sms api

			//set access code to session
			$segment->set('access_code', $access_key);
			$segment->set('phone_number', trim($_POST['phone-number']));

			header('Location: ' . Config::$site_url . 'sign-up/verify-access-code.php');

		} else {
			array_push($err, 'Phone number is not valid');
		}

	} else {
		array_push($err, 'please enter 10 digit phone number');
	}

}

$data = array(
	'site_url' => Config::$site_url,
	'page_title' => "Free Sign-up for 30mins",
	'name' => 'Sign-Up',
	'flash' => $segment->getFlash('message'),
	'form_data' => $form_data,
	'errors' => $err,
);

echo $blade->view()->make('users.free-signup', $data);