<?php
class Customers extends Illuminate\Database\Eloquent\Model{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'customers';
	protected $fillable = [
		'patient_id', 
		'customer_name', 
		'mobile_number', 
		'id_proof_type', 
		'id_proof_filename', 
		'operator_id'
	];
}

