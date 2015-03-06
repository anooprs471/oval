<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;
use Carbon\Carbon;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;


$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';


$blade = new Blade($views, $cache);
$msg = '';
$flash_msg = '';
$err = array();
$form = array(
	'patient_id' => '',
	'customer_name' => '',
	'mobile_number' => '',
	'id_proof_type' => ''
);
$file_err = false;

$user = new UserAccounts;

$flash = new Flash_Messages();

$capsule = $user->getCapsule();

$generator = new ComputerPasswordGenerator();

$usernames = array();
$generator
  ->setUppercase(false)
  ->setLowercase(true)
  ->setNumbers(false)
  ->setSymbols(false)
  ->setLength(6);

$coupon_usernames = $capsule::table('coupons')
->select('username')
->get();

foreach ($coupon_usernames as $usr) {
	array_push($usernames,$usr['username']);
}

$username = $generator->generatePassword();

while(in_array($username,$usernames)){
	$username = $generator->generatePassword();
}

$generator->setLength(4);

$password = $generator->generatePassword();


echo $username.'<br/>'.$password;

// if($user->isOperator()){
// 	if($_SERVER['REQUEST_METHOD'] === 'POST'){
// 		$patient_id = $_POST['patient-id'];
// 		$op_id= $_POST['op-id'];

// 		$username = 
// 	}
// 	echo $blade->view()->make('op.customer-page',$data);
// }else{
// 	header('Location: '.Config::$site_url.'logout.php');
// }