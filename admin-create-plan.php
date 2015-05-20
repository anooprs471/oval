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
	'plan-name' => '',
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

	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		$plan_name = filter_var(trim($_POST['plan-name']));

		$download_speed = filter_var(trim($_POST['download-speed']));
		$upload_speed = filter_var(trim($_POST['upload-speed']));
		$max_data_usage = filter_var(trim($_POST['max-data-usage']));
		$max_all_session = filter_var(trim($_POST['max-all-session']));
		$max_daily_session = filter_var(trim($_POST['max-daily-session']));
		$simult_use = filter_var(trim($_POST['simult-use']));
		$idle_timeout = filter_var(trim($_POST['idle-timeout']));

		$form_data = array(
			'plan-name' => $plan_name,
			'download-speed' => $download_speed,
			'upload-speed' => $upload_speed,
			'max-data-usage' => $max_data_usage,
			'max-all-session' => $max_all_session,
			'max-daily-session' => $max_daily_session,
			'simult-use' => $simult_use,
			'idle-timeout' => $idle_timeout
		);


		if($plan_name == ''){
			array_push($err,'Give a Plan Name');
		}else{

			$plan_radgroupcheck = $capsule::table('radgroupcheck')
			->where('groupname', '=', $plan_name)
			->first();

			$plan_radgroupreply = $capsule::table('radgroupreply')
			->where('groupname', '=', $plan_name)
			->first();

			if($plan_radgroupcheck != null || $plan_radgroupreply != null){
				array_push($err,'Plan Name Already Taken');
			}

		}


		if(empty($err)){

			//insert into radgroupreply
			//
			if($download_speed != ''){
				array_push($radgroupreply, array(
					'groupname' => $plan_name,
					'attribute' => 'Chillispot-Bandwidth-Max-Down',
					'op' => ':=',
					'value' => $download_speed
				));
			}
			if($upload_speed != ''){
				array_push($radgroupreply, array(
					'groupname' => $plan_name,
					'attribute' => 'Chillispot-Bandwidth-Max-Up',
					'op' => ':=',
					'value' => $upload_speed
				));
			}
			if($idle_timeout != ''){
				array_push($radgroupreply, array(
					'groupname' => $plan_name,
					'attribute' => 'Idle-Timeout',
					'op' => ':=',
					'value' => $idle_timeout
				));
			}

			//insert into radgroupcheck
			//
			if($max_all_session != ''){
				array_push($radgroupcheck, array(
					'groupname' => $plan_name,
					'attribute' => 'Max-All-Session',
					'op' => ':=',
					'value' => $max_all_session
				));
			}
			if($max_daily_session != ''){
				array_push($radgroupcheck, array(
					'groupname' => $plan_name,
					'attribute' => 'Max-Daily-Session',
					'op' => ':=',
					'value' => $max_all_session
				));
			}
			if($simult_use != ''){
				array_push($radgroupcheck, array(
					'groupname' => $plan_name,
					'attribute' => 'Simultaneous-Use',
					'op' => ':=',
					'value' => $simult_use
				));
			}
			if($max_data_usage != ''){
				array_push($radgroupcheck, array(
					'groupname' => $plan_name,
					'attribute' => 'CS-Total-Octets-Daily',
					'op' => ':=',
					'value' => $max_data_usage
				));
			}


			//insert to table
			if(!empty($radgroupcheck)){
				$capsule::table('radgroupcheck')
				->insert($radgroupcheck);
			}
			if(!empty($radgroupreply)){
				$capsule::table('radgroupreply')
				->insert($radgroupreply);
			}

			$flash->add('Successfully added plan');
			header('Location: '.Config::$site_url.'admin-customer-plans.php');
		}

	}

	$data = array(
		'type' => 'admin',
		'site_url'=> Config::$site_url,
		'page_title' => "Create Plan",
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
		'form_data' => $form_data,
		'errors' => $err
	);
	echo $blade->view()->make('admin.create-plan',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}