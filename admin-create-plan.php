<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Carbon\Carbon;
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$user = new UserAccounts;

$images = new Images;

$flash = new FlashMessages;

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
	'plan-name' => '',
	'price' => '',
	'download-speed' => '',
	'upload-speed' => '',
	'max-data-usage' => '',
	'max-all-session' => '',
	'max-daily-session' => '',
	'simult-use' => '',
	'idle-timeout' => '',
);

$msg = '';

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$plan_name = filter_var(trim($_POST['plan-name']));
		$price = filter_var(trim($_POST['price']));

		$download_speed = filter_var(trim($_POST['download-speed']));
		$upload_speed = filter_var(trim($_POST['upload-speed']));
		$max_data_usage = filter_var(trim($_POST['max-data-usage']));
		$max_all_session = filter_var(trim($_POST['max-all-session']));
		$max_daily_session = filter_var(trim($_POST['max-daily-session']));
		$simult_use = filter_var(trim($_POST['simult-use']));
		$idle_timeout = filter_var(trim($_POST['idle-timeout']));

		$form_data = array(
			'plan-name' => $plan_name,
			'price' => $price,
			'download-speed' => $download_speed,
			'upload-speed' => $upload_speed,
			'max-data-usage' => $max_data_usage,
			'max-all-session' => $max_all_session,
			'max-daily-session' => $max_daily_session,
			'simult-use' => $simult_use,
			'idle-timeout' => $idle_timeout,
		);

		if ($plan_name == '') {
			array_push($err, 'Give a Plan Name');
		} else {

			$plan_radgroupcheck = $capsule::table('radgroupcheck')
				->where('groupname', '=', $plan_name)
				->first();

			$plan_radgroupreply = $capsule::table('radgroupreply')
				->where('groupname', '=', $plan_name)
				->first();

			if ($plan_radgroupcheck != null || $plan_radgroupreply != null) {
				array_push($err, 'Plan Name Already Taken');
			}

		}

		if (empty($err)) {

			//insert into radgroupreply
			//
			if ($download_speed != '') {

				if (is_numeric($download_speed)) {

					if ($_POST['download-speed-option'] == 'Mbps') {
						$download_speed *= 1000;
					}

					array_push($radgroupreply, array(
						'groupname' => $plan_name,
						'attribute' => 'Chillispot-Bandwidth-Max-Down',
						'op' => ':=',
						'value' => $download_speed,
					));
				} else {
					array_push($err, 'Download speed value needs to be numeric');
				}

			}
			if ($upload_speed != '') {
				if (is_numeric($upload_speed)) {

					if ($_POST['upload-speed-option'] == 'Mbps') {
						$upload_speed *= 1000;
					}

					array_push($radgroupreply, array(
						'groupname' => $plan_name,
						'attribute' => 'Chillispot-Bandwidth-Max-Up',
						'op' => ':=',
						'value' => $upload_speed,
					));

				} else {
					array_push($err, 'Upload speed value needs to be numeric');
				}
			}
			if ($idle_timeout != '') {
				if (is_numeric($idle_timeout)) {

					array_push($radgroupreply, array(
						'groupname' => $plan_name,
						'attribute' => 'Idle-Timeout',
						'op' => ':=',
						'value' => $idle_timeout,
					));
				} else {
					array_push($err, 'Idle timeout value needs to be numeric');
				}
			}

			//insert into radgroupcheck
			//
			if ($max_all_session != '') {
				if (is_numeric($max_all_session)) {

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

					array_push($radgroupcheck, array(
						'groupname' => $plan_name,
						'attribute' => 'Max-All-Session',
						'op' => ':=',
						'value' => $max_all_session,
					));
				} else {
					array_push($err, 'Max All Session value needs to be numeric');
				}
			}
			if ($max_daily_session != '') {
				if (is_numeric($max_daily_session)) {

					if ($_POST['max-daily-session-option'] == 'minute') {
						$max_daily_session *= 60;
					} elseif ($_POST['max-all-session-option'] == 'hour') {
						$max_daily_session *= 3600;
					}

					array_push($radgroupcheck, array(
						'groupname' => $plan_name,
						'attribute' => 'Max-Daily-Session',
						'op' => ':=',
						'value' => $max_daily_session,
					));
				} else {
					array_push($err, 'Max Daily Session value needs to be numeric');
				}
			}
			if ($simult_use != '') {
				if (is_numeric($simult_use)) {
					array_push($radgroupcheck, array(
						'groupname' => $plan_name,
						'attribute' => 'Simultaneous-Use',
						'op' => ':=',
						'value' => $simult_use,
					));
				} else {
					array_push($err, 'Simultaneous use value needs to be numeric');
				}
			}
			if ($max_data_usage != '') {
				if (is_numeric($max_data_usage)) {

					$max_data_usage *= 1000;

					if ($_POST['max-data-usage-option'] == 'GB') {
						$max_data_usage *= 1000000;
					}

					array_push($radgroupcheck, array(
						'groupname' => $plan_name,
						'attribute' => 'CS-Total-Octets-Daily',
						'op' => ':=',
						'value' => $max_data_usage,
					));
				} else {
					array_push($err, 'Max Data Usage value needs to be numeric');
				}
			}

			if (empty($err)) {
				//insert to table
				if (!empty($radgroupcheck)) {
					$capsule::table('radgroupcheck')
						->insert($radgroupcheck);
				}
				if (!empty($radgroupreply)) {
					$capsule::table('radgroupreply')
						->insert($radgroupreply);
				}

				$capsule::table('couponplans')
					->insert(array(
						'planname' => $plan_name,
						'price' => $price,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now(),
					));

				$flash->add('Successfully added plan');
				header('Location: ' . Config::$site_url . 'admin-customer-plans.php');
			}

		}

	}

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Create Plan",
		'logo_file' => $images->getScreenLogo(),
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'form_data' => $form_data,
		'errors' => $err,
	);
	echo $blade->view()->make('admin.create-plan', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}