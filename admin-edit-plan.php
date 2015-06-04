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

$flash = new Flash_Messages();

$capsule = $user->getCapsule();

$flash_msg = '';

if ($flash->hasFlashMessage()) {
	$flash_msg = $flash->show();
}

$err = array();

//grp insert arrays
$radgroupreply = array();
$radgroupcheck = array();

$plan_err = false;

$form_data = array(
	'download-speed' => '',
	'upload-speed' => '',
	'max-data-usage' => '',
	'max-all-session' => '',
	'max-daily-session' => '',
	'simult-use' => '',
	'idle-timeout' => '',
);

$options = array(
	'max-all-session' => 'minute',
	'max-daily-session' => 'minute',
	'max-data-usage' => 'MB',
	'download-speed' => 'Kbps',
	'upload-speed' => 'Kbps',
);

$msg = '';

if ($user->isAdmin()) {

	if (isset($_GET['plan-name'])) {

		$plan_name = filter_var(trim($_GET['plan-name']));

		$plan_radgroupcheck = $capsule::table('radgroupcheck')
			->where('groupname', '=', $plan_name)
			->get();

		$plan_radgroupreply = $capsule::table('radgroupreply')
			->where('groupname', '=', $plan_name)
			->get();

		//get attributes from the database
		if ($plan_radgroupcheck != null) {

			foreach ($plan_radgroupcheck as $data) {
				if ($data['attribute'] == 'Max-All-Session') {

					if ($data['value'] > 1 && $data['value'] <= 3600) {
						$data['value'] = $data['value'] / 60;
					} elseif ($data['value'] > 3600 && $data['value'] <= 86400) {
						$data['value'] = $data['value'] / 3600;
						$options['max-all-session'] = 'hour';
					} elseif ($data['value'] > 86400 && $data['value'] <= 604800) {
						$data['value'] = $data['value'] / 86400;
						$options['max-all-session'] = 'day';
					} elseif ($data['value'] > 604800 && $data['value'] <= 2628000) {
						$data['value'] = $data['value'] / 604800;
						$options['max-all-session'] = 'week';
					} elseif ($data['value'] > 2628000) {
						$data['value'] = $data['value'] / 2628000;
						$options['max-all-session'] = 'month';
					}
					$form_data['max-all-session'] = $data['value'];

				}

				if ($data['attribute'] == 'Max-Daily-Session') {

					if ($data['value'] > 1 && $data['value'] <= 3600) {
						$data['value'] = $data['value'] / 60;
					} elseif ($data['value'] > 3600 && $data['value'] <= 86400) {
						$data['value'] = $data['value'] / 3600;
						$options['max-daily-session'] = 'hour';
					}
					$form_data['max-daily-session'] = $data['value'];
				}

				if ($data['attribute'] == 'Simultaneous-Use') {
					$form_data['simult-use'] = $data['value'];
				}

				if ($data['attribute'] == 'CS-Total-Octets-Daily') {

					if ($data['value'] >= 1000000) {
						$data['value'] = $data['value'] / 1000000;
					} elseif ($data['value'] > 1000000000) {
						$data['value'] = $data['value'] / 1000000000;
						$options['max-data-usage'] = 'GB';
					}
					$form_data['max-data-usage'] = $data['value'];
				}

			}

		}

		if ($plan_radgroupreply != null) {

			foreach ($plan_radgroupreply as $data) {

				if ($data['attribute'] == 'Idle-Timeout') {
					$form_data['idle-timeout'] = $data['value'];
				}

				if ($data['attribute'] == 'Session-Timeout') {

					$form_data['session-timeout'] = $data['value'];
				}

				if ($data['attribute'] == 'Chillispot-Bandwidth-Max-Up') {

					if ($data['value'] > 1024) {
						$data['value'] = $data['value'] / 1024;
						$options['upload-speed'] = 'Mbps';
					}
					$form_data['upload-speed'] = $data['value'];
				}

				if ($data['attribute'] == 'Chillispot-Bandwidth-Max-Down') {

					if ($data['value'] > 1024) {
						$data['value'] = $data['value'] / 1024;
						$options['download-speed'] = 'Mbps';
					}
					$form_data['download-speed'] = $data['value'];
				}

			}

		}

	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (empty($err)) {

			$download_speed = filter_var(trim($_POST['download-speed']));
			$upload_speed = filter_var(trim($_POST['upload-speed']));
			$max_data_usage = filter_var(trim($_POST['max-data-usage']));
			$max_all_session = filter_var(trim($_POST['max-all-session']));
			$max_daily_session = filter_var(trim($_POST['max-daily-session']));
			$simult_use = filter_var(trim($_POST['simult-use']));
			$idle_timeout = filter_var(trim($_POST['idle-timeout']));

			//insert into radgroupreply
			//

			if ($download_speed != '') {
				if ($_POST['download-speed-option'] == 'Kbps') {
					$download_speed *= 1;
				} elseif ($_POST['download-speed-option'] == 'Mbps') {
					$download_speed *= 1024;
				}
				$capsule::table('radgroupreply')
					->where('groupname', '=', $plan_name)
					->where('attribute', '=', 'Chillispot-Bandwidth-Max-Down')
					->update(['value' => $download_speed]);
			}

			if ($upload_speed != '') {
				if ($_POST['upload-speed-option'] == 'Kbps') {
					$upload_speed *= 1;
				} elseif ($_POST['upload-speed-option'] == 'Mbps') {
					$upload_speed *= 1024;
				}
				$capsule::table('radgroupreply')
					->where('groupname', '=', $plan_name)
					->where('attribute', '=', 'Chillispot-Bandwidth-Max-Up')
					->update(['value' => $upload_speed]);
			}

			if ($idle_timeout != '') {
				$capsule::table('radgroupreply')
					->where('groupname', '=', $plan_name)
					->where('attribute', '=', 'Idle-Timeout')
					->update(['value' => $idle_timeout]);
			}

			if ($max_all_session != '') {
				if ($_POST['max-all-session-option'] == 'minute') {
					$max_all_session *= 60;
				} elseif ($_POST['max-all-session-option'] == 'hour') {
					$max_all_session *= 3600;
				} elseif ($_POST['max-all-session-option'] == 'day') {
					$max_all_session *= 86400;
				} elseif ($_POST['max-all-session-option'] == 'week') {
					$max_all_session *= 604800;
				} elseif ($_POST['max-all-session-option'] == 'month') {
					$max_all_session *= 2628000;
				}

				$capsule::table('radgroupcheck')
					->where('groupname', '=', $plan_name)
					->where('attribute', '=', 'Max-All-Session')
					->update(['value' => $max_all_session]);
			}

			if ($max_daily_session != '') {

				if ($_POST['max-daily-session-option'] == 'minute') {
					$max_daily_session *= 60;
				} elseif ($_POST['max-daily-session-option'] == 'hour') {
					$max_daily_session *= 3600;
				}
				$capsule::table('radgroupcheck')
					->where('groupname', '=', $plan_name)
					->where('attribute', '=', 'Max-Daily-Session')
					->update(['value' => $max_daily_session]);
			}

			if ($simult_use != '') {
				$capsule::table('radgroupcheck')
					->where('groupname', '=', $plan_name)
					->where('attribute', '=', 'Simultaneous-Use')
					->update(['value' => $simult_use]);
			}

			if ($max_data_usage != '') {
				if ($_POST['max-data-usage-option'] == 'MB') {
					$max_data_usage *= 1000000;
				} elseif ($_POST['max-data-usage-option'] == 'GB') {
					$max_data_usage *= 1000000000;
				}
				$capsule::table('radgroupcheck')
					->where('groupname', '=', $plan_name)
					->where('attribute', '=', 'CS-Total-Octets-Daily')
					->update(['value' => $max_data_usage]);
			}

			$flash->add('Successfully updated');
			header('Location: ' . Config::$site_url . 'admin-edit-plan.php?plan-name=' . urlencode($plan_name));
		}

	}

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Edit Plan",
		'logo_file' => $images->getScreenLogo(),
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'form_data' => $form_data,
		'errors' => $err,
		'plan_name' => $plan_name,
		'options' => $options,
	);
	echo $blade->view()->make('admin.edit-plan', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
