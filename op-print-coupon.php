<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Carbon\Carbon;
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$msg = '';
$flash_msg = '';
$data_err = false;

$user = new UserAccounts;

$images = new Images;

$capsule = $user->getCapsule();

$flash = new FlashMessages;

if ($flash->hasFlashMessage()) {
	$flash_msg = $flash->show();
}

$coupon_details = array(
	'customer_name' => '',
	'username' => '',
	'password' => '',
	'plan_name' => '',
	'price' => '',
	'coupon_date' => '',
);

if ($user->isOperator()) {
	$names = $user->getOperatorName();

	if (!isset($_GET['coupon-id']) || strlen($_GET['coupon-id']) == 0) {
		$msg = 'Coupon id invalid!';
		$data_err = true;
	} else {

		$coupon = $capsule::table('coupons')
			->where('id', '=', filter_var($_GET['coupon-id'], FILTER_SANITIZE_STRING))
			->first();

		if ($coupon != null) {

			$plan_type = $coupon['coupon_type'];
			$customer_id = $coupon['customer_id'];
			$complementary = $coupon['complementary'];

			$username = $coupon['username'];
			$password = $coupon['password'];

			$date = Carbon::createFromFormat('Y-m-d H:i:s', $coupon['created_at'])
				->toFormattedDateString();

			$customer = $capsule::table('customers')
				->where('id', '=', $customer_id)
				->first();

			$expr = $capsule::table('radcheck')
				->where('username', '=', $username)
				->where('attribute', '=', 'Expiration')
				->first();

			$coupon_detail = $capsule::table('couponplans')
				->where('planname', '=', $plan_type)
				->first();

			$customer_name = $customer['customer_name'];

			$plan_name = $coupon_detail['planname'];

			$plan_price = $coupon_detail['price'];

			$coupon_details = array(
				'customer_name' => $username,
				'username' => $username,
				'password' => $password,
				'plan_name' => $plan_name,
				'price' => $plan_price,
				'coupon_date' => $date,
				'expiration' => $expr['value'],
			);

		} else {
			$msg = 'Coupon id invalid!';
			$data_err = true;
		}
	}

	$data = array(
		'type' => 'operator',
		'site_url' => Config::$site_url,
		'name' => 'Operator',
		'page_title' => "Print Coupon",
		'logo_file' => $images->getScreenLogo(),
		'first_name' => $names['first-name'],
		'last_name' => $names['last-name'],
		'msg' => $msg,
		'flash' => $flash_msg,
		'coupon_details' => $coupon_details,
		'data_err' => $data_err,
	);

	echo $blade->view()->make('op.coupon-print', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}