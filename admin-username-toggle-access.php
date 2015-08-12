<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$user = new UserAccounts;

$images = new Images;

$flash = new Flash_Messages();
$generator = new ComputerPasswordGenerator();

$capsule = $user->getCapsule();

if ($user->isAdmin()) {

	if (isset($_GET['username']) && strlen($_GET['username']) > 0) {
		$username = filter_var(trim($_GET['username']), FILTER_SANITIZE_STRING);
		//check if there is a user
		$usr = $capsule::table('radcheck')
			->where('username', '=', $username)
			->get();

		if (!empty($usr)) {
			//check if user set to reject
			$usr_state = $capsule::table('radcheck')
				->where('username', '=', $username)
				->where('attribute', '=', 'Auth-Type')
				->where('value', '=', 'Reject')
				->get();

			if (!empty($usr_state)) {
				$capsule::table('radcheck')
					->where('username', '=', $username)
					->where('attribute', '=', 'Auth-Type')
					->where('value', '=', 'Reject')
					->delete();
			} else {
				$capsule::table('radcheck')
					->insert(array(
						'username' => $username,
						'attribute' => 'Auth-Type',
						'op' => ':=',
						'value' => 'Reject',
					));
			}

		}

	}
	header('Location: ' . Config::$site_url . 'admin-patient-usage.php?patient-id=' . $_GET['patient-id']);

} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
