<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use DB;

class LogPaypalTransaction extends Eloquent{

	public $table = 't9206_log_paypal_transaction';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];

	public static function GetTransactionDetail(){
		$sql = "
			SELECT t.`first_name` , u.`role` , u.`email` ,u.`country`, u.`city`,  g.`code`, g.`profile_id` , t.`payment_gross`, t.`payment_status`, t.`created_at` 
				FROM `t0101_user` u ,  `t0113_game_code` g , `t9206_log_paypal_transaction` t
					WHERE t.`user_id` = u.`id`
					AND t.`target_id` = g.`profile_id`

					ORDER BY t.`created_at` DESC
		";

		$result = DB::SELECT($sql);

		return $result;
	}
}