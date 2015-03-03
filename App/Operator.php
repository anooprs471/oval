<?php namespace App\Operator
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Illuminate\Database\Capsule\Manager as Capsule;

Class Operator{

	public function __conctruct(){

	}
	

	/**
	 * register a new patient for coupon
	 *
	 * @return void
	 **/
	function registerNewPatient(){
	}

	/**
	 * search for patient id in database
	 *
	 * @return void
	 **/
	function searchPatient($patient_id){
	}

	/**
	 * allot a new coupon for the user
	 *
	 * @return void
	 **/
	function allotCoupon($patient_id){
	}

	/**
	 * get the plans from db
	 *
	 * @return void
	 **/
	function getPlans(){
	}

	/**
	 * get previous coupons
	 *
	 * @return void
	 **/
	function getPreviousCoupons($patient_id){
	}
}
