<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogPaypalTransaction extends Eloquent{

	public $table = 't9206_log_paypal_transaction';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];
}