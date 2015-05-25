<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Carbon\Carbon;
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$user = new UserAccounts;

$images = new Images;

$capsule = $user->getCapsule();

$patient_details = array();

$plans = array();

$msg = '';

$form_err = false;

$data_err = false;

$date_err = false;

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (!isset($_POST['date-from']) || strlen($_POST['date-from']) == 0) {
			$fr_date = Carbon::create(2014, 1, 1, 12);
		} else {
			$from_date = filter_var($_POST['date-from'], FILTER_SANITIZE_STRING);
			try {
				$fr_date = Carbon::createFromFormat('m/d/Y', $from_date);
			} catch (Exception $e) {
				$date_err = true;
			}
		}

		if (!isset($_POST['date-to']) || strlen($_POST['date-to']) == 0) {
			$t_date = Carbon::now();
		} else {
			$to_date = filter_var($_POST['date-to'], FILTER_SANITIZE_STRING);
			try {
				$t_date = Carbon::createFromFormat('m/d/Y', $to_date);
			} catch (Exception $e) {
				$date_err = true;
			}
		}

		$plan_type = $_POST['plan-type'];

		$plan_detail = $capsule::table('couponplans')
			->where('id', '=', $plan_type)
			->first();

		if (!empty($plan_detail)) {
			$plan_name = $plan_detail['planname'];
		} else {
			$plan_name = 'all';
		}

		if (!$date_err) {
			//set start and end time of days

			$fr_date->hour = 0;
			$fr_date->minute = 0;
			$fr_date->second = 0;

			$t_date->hour = 23;
			$t_date->minute = 59;
			$t_date->second = 59;

			if ($plan_type == 'all') {

				$plans = $capsule::table('coupons')
					->whereBetween('coupons.created_at', array($fr_date, $t_date))
					->join('users', 'coupons.op_id', '=', 'users.id')
					->join('couponplans', 'couponplans.planname', '=', 'coupons.coupon_type')
					->select(
						'coupons.created_at as date',
						'coupons.username as username',
						'users.username as operator',
						'users.id as op_id',
						'couponplans.planname as plan',
						'couponplans.price as price',
						'coupons.created_at as date'
					)
					->orderby('coupons.created_at')
					->get();

			} else {
				$plans = $capsule::table('coupons')
					->where('coupons.coupon_type', '=', $plan_type)
					->whereBetween('coupons.created_at', array($fr_date, $t_date))
					->join('users', 'coupons.op_id', '=', 'users.id')
					->join('couponplans', 'couponplans.planname', '=', 'coupons.coupon_type')
					->select(
						'coupons.created_at as date',
						'coupons.username as username',
						'users.username as operator',
						'users.id as op_id',
						'couponplans.planname as plan',
						'couponplans.price as price',
						'coupons.created_at as date'
					)
					->orderby('coupons.created_at')
					->get();

			}

			$data_date = 'from <strong>' . $fr_date->format('Y/M/d') . '</strong> to <strong>' . $t_date->format('Y/M/d') . '</strong> of <strong>' . $plan_name . '</strong> plan';

		} else {
			$msg = 'date error ' . $from_date . ' ' . $to_date;
		}

	} else {
		$form_err = true;
	}

	//var_dump($plans);
	$disp_frm_year = $fr_date->year . '/' . $fr_date->month . '/' . $fr_date->day;
	$disp_to_year = $t_date->year . '/' . $t_date->month . '/' . $t_date->day;

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Admin Coupon Usage",
		'logo_file' => $images->getScreenLogo(),
		'name' => 'Administrator',
		'msg' => $msg,
		'searched_for' => 'plan - ' . $plan_type . ' between dates ' . $disp_frm_year . ' - ' . $disp_to_year,
		'plans' => $plans,
		'form_err' => $form_err,
	);

	echo $blade->view()->make('admin.plan-usage', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}