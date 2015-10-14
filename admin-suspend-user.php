<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

$user = new UserAccounts;

if ($user->isAdmin()) {

	$user_id = $_GET['id'];
	$user->suspend($user_id);
	header('Location: ' . Config::$site_url . 'admin-list-users.php');
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}