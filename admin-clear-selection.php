<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Aura\Session\SessionFactory;

//manage session
$session_factory = new SessionFactory;
$session = $session_factory->newInstance($_COOKIE);
$session->setCookieParams(array('lifetime' => '1800')); //30 seconds
$segment = $session->getSegment('admin/batch');

$user = new UserAccounts;

$flash = new Flash_Messages();

if ($user->isAdmin()) {

	$segment->set('coupon_ids', array());
	$flash->add('Cleared all selection');
	header('Location: ' . Config::$site_url . 'admin-batch-details.php?batch-id=' . $_GET['batch-id']);

} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}
