<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

$user = new UserAccounts;

$capsule = $user->getCapsule();
$data_err = false;
$mobilephone = 'not found';

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (!isset($_POST['username-pin']) || strlen($_POST['username-pin']) == 0) {
			$data_err = true;
		} else {
			$search_str = trim($_POST['username-pin']);
		}

		if (!$data_err) {
			$userinfo = $capsule::table('userinfo')
				->where('username', '=', $search_str)
				->select(
					'mobilephone'
				)
				->first();
			// $customer = $capsule::table('customers')
			// 	->where('username', '=', $search_str)
			// 	->get();

			$customer = $capsule::table('coupons')
				->where('coupons.username', '=', $search_str)
				->join('customers', 'customers.id', '=', 'coupons.customer_id')
				->select(
					'customers.mobile_number'
				)
				->first();

			if ($userinfo != null) {
				$mobilephone = $userinfo['mobilephone'];
			} elseif ($customer != null) {
				$mobilephone = $customer['mobile_number'];
			}
		}

		$response = array(
			'mobile_number' => $mobilephone,
		);
		echo json_encode($response);

	}
	die;

}