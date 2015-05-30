<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Carbon\Carbon;
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$images = new Images;

$mpdf = new \mPDF('utf-8', 'A3');

$user = new UserAccounts;

$capsule = $user->getCapsule();

if ($user->isOperator()) {
	$names = $user->getOperatorName();

	if (!isset($_GET['username']) || strlen($_GET['username']) == 0) {
		header('Location: ' . Config::$site_url);
	} else {

		$coupon = $capsule::table('coupons')
			->where('username', '=', filter_var($_GET['username'], FILTER_SANITIZE_STRING))
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
			);

		} else {
			$msg = 'Coupon id invalid!';
			$data_err = true;
		}
	}

	$data = array(
		'type' => 'operator',
		'site_url' => Config::$site_url,
		'page_title' => $username,
		'logo_file' => $images->getScreenLogo(),
		'first_name' => $names['first-name'],
		'last_name' => $names['last-name'],
		'coupon_details' => $coupon_details,
	);

	$bootstrap_css = file_get_contents('bs3/css/bootstrap.min.css');

	$stylesheet = file_get_contents('css/pdf.css');

	$mpdf->WriteHTML($bootstrap_css, 1);
	$mpdf->WriteHTML($stylesheet, 1);

	$html = $blade->view()->make('coupon', $data);

	$mpdf->WriteHTML($html->__toString());

	$mpdf->Output(Carbon::createFromFormat('Y-m-d H:i:s', $coupon['created_at'])->format('Y-m-d') . '-' . $username . '.pdf', 'I');

} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}