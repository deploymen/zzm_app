<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class SpaceshipUserItem extends Eloquent {
	use SoftDeletes;
	
	protected $table = 't0140_spaceship_user_item';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];
	protected $fillable = ['user_id', 'profile_id', 'floor_id' , 'item_id' , 'locked' , 'selected'];

	public static function totalItems($profileId, $floorId){
		$sql = " 
			SELECT count(i.`id`) AS `total_item`
				FROM `t0140_spaceship_user_item` u, `t0143_spaceship_item` i
					WHERE u.`profile_id` = :profile_id
					AND u.`item_id` = i.`id`
					AND i.`floor_id` = :floor_id
		";

		$result = DB::select($sql , ['profile_id' => $profileId , 'floor_id' => $floorId]);
		return $result[0]->total_item;
	}

} 
