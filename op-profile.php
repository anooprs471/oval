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

$data = array(
	'type' => 'operator',
	'page_title' => "Operator Profile",
	'logo_file' => $images->getScreenLogo(),
	'site_url' => Config::$site_url,
	'name' => 'Operator',
);

if ($user->isOperator()) {
	echo $blade->view()->make('op.profile', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}