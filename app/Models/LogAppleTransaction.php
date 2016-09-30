<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use DB;
class LogAppleTransaction extends Eloquent{

	public $table = 't9207_log_apple_transaction';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];
	protected $fillable = ['user_id', 'profile_id', 'transaction_id' , 'product_id', 'quantity', 'original_transaction_id', 'purchase_date', 'purchase_date_ms', 'purchase_date_pst', 'original_purchase_date', 'original_purchase_date_ms', 'original_purchase_date_pst' , 'expires_date' , 'expires_date_ms' , 'web_order_line_item_id' , 'is_trial_period' ];


}