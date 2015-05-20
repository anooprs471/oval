<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';


$blade = new Blade($views, $cache);

$user = new UserAccounts;

$flash = new Flash_Messages();

$capsule = $user->getCapsule();

$flash_msg = '';

if($flash->hasFlashMessage()){
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
	'idle-timeout' => ''
);

$msg = '';

if($user->isAdmin()){

	if(isset($_GET['plan-name'])){

		$plan_name = filter_var(trim($_GET['plan-name']));

		$plan_radgroupcheck = $capsule::table('radgroupcheck')
		->where('groupname', '=', $plan_name)
		->get();

		$plan_radgroupreply = $capsule::table('radgroupreply')
		->where('groupname', '=', $plan_name)
		->get();

		//get attributes from the database
		if($plan_radgroupcheck != null){

			foreach ($plan_radgroupcheck as $data) {
				if($data['attribute'] == 'Max-All-Session'){
					$form_data['max-all-session'] = $data['value'];
				}
				if($data['attribute'] == 'Max-Daily-Session'){
					$form_data['max-daily-session'] = $data['value'];
				}
				if($data['attribute'] == 'Simultaneous-Use'){
					$form_data['simult-use'] = $data['value'];
				}
				if($data['attribute'] == 'CS-Total-Octets-Daily'){
					$form_data['max-data-usage'] = $data['value'];
				}
			}

		}

		if($plan_radgroupreply != null){

			foreach ($plan_radgroupreply as $data) {

				if($data['attribute'] == 'Idle-Timeout'){
					$form_data['idle-timeout'] = $data['value'];
				}
				if($data['attribute'] == 'Session-Timeout'){
					$form_data['session-timeout'] = $data['value'];
				}
				if($data['attribute'] == 'Chillispot-Bandwidth-Max-Up'){
					$form_data['upload-speed'] = $data['value'];
				}
				if($data['attribute'] == 'Chillispot-Bandwidth-Max-Down'){
					$form_data['download-speed'] = $data['value'];
				}

			}

		}

	}	

	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		if(empty($err)){

			$download_speed = filter_var(trim($_POST['download-speed']));
			$upload_speed = filter_var(trim($_POST['upload-speed']));
			$max_data_usage = filter_var(trim($_POST['max-data-usage']));
			$max_all_session = filter_var(trim($_POST['max-all-session']));
			$max_daily_session = filter_var(trim($_POST['max-daily-session']));
			$simult_use = filter_var(trim($_POST['simult-use']));
			$idle_timeout = filter_var(trim($_POST['idle-timeout']));

			//insert into radgroupreply
			//

			if($download_speed != ''){
				$capsule::table('radgroupreply')
				->where('groupname', '=', $plan_name)
				->where('attribute', '=', 'Chillispot-Bandwidth-Max-Down')
				->update(['value' => $download_speed]);
			}

			if($upload_speed != ''){
				$capsule::table('radgroupreply')
				->where('groupname', '=', $plan_name)
				->where('attribute', '=', 'Chillispot-Bandwidth-Max-Up')
				->update(['value' => $upload_speed]);
			}

			if($idle_timeout != ''){
				$capsule::table('radgroupreply')
				->where('groupname', '=', $plan_name)
				->where('attribute', '=', 'Idle-Timeout')
				->update(['value' => $idle_timeout]);
			}

			if($max_all_session != ''){
				$capsule::table('radgroupcheck')
				->where('groupname', '=', $plan_name)
				->where('attribute', '=', 'Max-All-Session')
				->update(['value' => $max_all_session]);
			}

			if($max_daily_session != ''){
				$capsule::table('radgroupcheck')
				->where('groupname', '=', $plan_name)
				->where('attribute', '=', 'Max-Daily-Session')
				->update(['value' => $max_daily_session]);
			}

			if($simult_use != ''){
				$capsule::table('radgroupcheck')
				->where('groupname', '=', $plan_name)
				->where('attribute', '=', 'Simultaneous-Use')
				->update(['value' => $simult_use]);
			}

			if($max_data_usage != ''){
				$capsule::table('radgroupcheck')
				->where('groupname', '=', $plan_name)
				->where('attribute', '=', 'CS-Total-Octets-Daily')
				->update(['value' => $max_data_usage]);
			}

			$flash->add('Successfully updated');
			header('Location: '.Config::$site_url.'admin-edit-plan.php?plan-name='.urlencode($plan_name));
		}

	}


	$data = array(
		'type' => 'admin',
		'site_url'=> Config::$site_url,
		'page_title' => "Edit Plan",
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'form_data' => $form_data,
		'errors' => $err,
		'plan_name' => $plan_name
	);
	echo $blade->view()->make('admin.edit-plan',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}