<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use DB;
class LogBraintreeTransaction extends Eloquent{

	public $table = 't9208_log_braintree_transaction';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];
	protected $fillable = ['transaction_id' , 'status' ,'type' ,'currency_iso_code' ,'amount', 'merchant_account_id' , 'sub_merchant_account_id' ,'master_merchant_account_id',
				'order_id' ];
}

