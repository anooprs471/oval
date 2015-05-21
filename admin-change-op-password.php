<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;
use Carbon\Carbon;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';


$blade = new Blade($views, $cache);

$user = new UserAccounts;

$flash = new Flash_Messages();

$capsule = $user->getCapsule();

$msg = '';
$flash_msg = '';
$form_err = false;


if($user->isAdmin()){

	if($_SERVER['REQUEST_METHOD'] === 'POST'){


		$new_password = $_POST['password'];

		if(!isset($_POST['op-id']) || strlen($_POST['op-id']) == 0 ){
			$form_err = true;
		}else{
			$user_id = $_POST['op-id'];
		}

		if(!isset($_POST['password']) || strlen($_POST['password']) < 6 ){
			$form_err = true;
		}else{
			$new_password = $_POST['password'];
		}

		if(!$form_err){
			$op = $capsule::table('users')
			->where('id','=',$user_id)
			->first();
			if(!empty($op)){
				$old_password = $op['password'];
				$user->changeOperatorsPassword($user_id,$new_password);
			}
		}else{
			$flash->add('No changes done');
		}


	}


	header('Location: '.Config::$site_url.'admin-user-detail.php?id='.$_POST['op-id']);

}else{
	header('Location: '.Config::$site_url.'logout.php');
}