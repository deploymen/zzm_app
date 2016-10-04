<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use DB;
class LogAppleTransaction extends Eloquent{

	public $table = 't9207_log_apple_transaction';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];
	protected $fillable = ['user_id', 'profile_id', 'transaction_id' , 'product_id', 'quantity', 'original_transaction_id', 'purchase_date', 'purchase_date_ms', 'purchase_date_pst', 'original_purchase_date', 'original_purchase_date_ms', 'original_purchase_date_pst' , 'expires_date' , 'expires_date_ms' , 'web_order_line_item_id' , 'is_trial_period' ];

	public function studentId() {

		return $this->hasOne('App\Models\GameProfile', 'id' , 'profile_id');
	}

	public static function getProfile($transactionId){

		$sql = "
			SELECT p.`id` 
				FROM `t9207_log_apple_transaction` t, `t0111_game_profile` p
					WHERE t.`transaction_id` IN(".join(',', $transactionId).")
						AND p.`id` = t.`profile_id`
					GROUP BY p.`id`
		";

		$result = DB::select($sql);

		$ids = json_decode(json_encode($result), true);
        $pId = [];
        foreach($ids as $id){

        	array_push($pId , $id['id']);
        }
     
		return $pId;
	}

}