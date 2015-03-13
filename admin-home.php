<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';


$blade = new Blade($views, $cache);

$user = new UserAccounts;

$capsule = $user->getCapsule();

$users = $user->listOperators();

$msg = '';


foreach ($users as $op) {
	$operator[$op->id] = array(
		'username' => $op->username,
		'active' => !$user->isSuspended($op->id)
	);
}



if($user->isAdmin()){
	
	$first = $capsule::table('radgroupreply')
	->distinct()
	->select('groupname');

	$plans = $capsule::table('radgroupcheck')
	->union($first)
	->select('groupname')
	->distinct()
	->get();


	$data = array(
		'type' => 'admin',
		'site_url'=> Config::$site_url,
		'name' => 'Administrator',
		'msg' => $msg,
		'users' => $operator,
		'plans' => $plans
	);


	echo $blade->view()->make('admin.home',$data);
}else{
	header('Location: '.Config::$site_url.'logout.php');
}