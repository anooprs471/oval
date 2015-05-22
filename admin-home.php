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

$capsule = $user->getCapsule();

$users = $user->listOperators();

$msg = '';

foreach ($users as $op) {
	$operator[$op->id] = array(
		'username' => $op->username,
		'active' => !$user->isSuspended($op->id),
	);
}

$fr_date = Carbon::now();
$t_date = Carbon::now();

$fr_date->hour = 0;
$fr_date->minute = 0;
$fr_date->second = 0;

$t_date->hour = 23;
$t_date->minute = 59;
$t_date->second = 59;

if ($user->isAdmin()) {

	$first = $capsule::table('radgroupreply')
		->distinct()
		->select('groupname');

	$plans = $capsule::table('radgroupcheck')
		->union($first)
		->select('groupname')
		->distinct()
		->get();

	$op_details = array();

	foreach ($operator as $opt_id => $op) {

		$cpn_op_details = $capsule::table('coupons')
			->where('coupons.op_id', '=', $opt_id)
			->whereBetween('coupons.created_at', array($fr_date, $t_date))
			->join('users', 'users.id', '=', 'coupons.op_id')
			->select(
				'coupons.username as username',
				'coupons.coupon_type as planname',
				'users.username as operator',
				'users.id as op_id',
				'coupons.created_at as date'
			)
			->get();

		//var_dump($op_details);
		if (!empty($cpn_op_details)) {
			array_push($op_details, $cpn_op_details);
		}

	}

	$avail_plans = $capsule::table('couponplans')
		->get();

	foreach ($avail_plans as $plan) {
		$plans_arr[$plan['planname']] = $plan['price'];
	}

	$coupon_count = 0;
	$payment = 0;
	$total = 0;
	$show_op_details = array();
	foreach ($op_details as $op) {
		foreach ($op as $cpns) {
			$payment = $payment + $plans_arr[$cpns['planname']];
			//echo $payment.'<br />';
			$coupon_count++;
			$operator_id = $cpns['op_id'];
			$operator_name = $cpns['operator'];
		}
		array_push($show_op_details, array(
			'op_id' => $operator_id,
			'op_name' => $operator_name,
			'payment' => $payment,
			'count' => $coupon_count,

		));
		$total = $payment + $total;

		$payment = 0;
		$coupon_count = 0;
	}

	//var_dump($show_op_details);

	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Admin Dashboard",
		'name' => 'Administrator',
		'msg' => $msg,
		'users' => $operator,
		'sale_details' => $show_op_details,
		'plans' => $plans,
	);

	echo $blade->view()->make('admin.home', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}