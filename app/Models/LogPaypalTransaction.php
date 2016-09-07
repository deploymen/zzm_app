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
			SELECT * 
				FROM (
					SELECT t.`first_name` , u.`role` , u.`email` ,u.`country`, u.`city`,  p.`student_id`, p.`id` AS `profile_id`, t.`payment_gross`, t.`payment_status`, t.`created_at` 
		                FROM `t0101_user` u ,  `t0111_game_profile` p , `t9206_log_paypal_transaction` t
		                    WHERE t.`user_id` = u.`id`
		                    AND t.`target_id` = p.`id`
		                    AND t.`payment_status` IS NOT NULL
		                    ORDER BY t.`created_at` DESC
		                  
				)a
				GROUP BY a.`profile_id`
		";

		return DB::select($sql);
		
	}
}