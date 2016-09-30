<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class SpaceshipUser extends Eloquent {
	use SoftDeletes;
	
	protected $table = 't0140_spaceship_user';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

	public static function totalItems($profileId, $floorId){
		$sql = " 
			SELECT count(i.`id`) AS `total_item`
				FROM `t0140_spaceship_user` u, `t0143_spaceship_item` i
					WHERE u.`profile_id` = :profile_id
					AND u.`item_id` = i.`id`
					AND i.`floor_id` = :floor_id
		";

		$result = DB::select($sql , ['profile_id' => $profileId , 'floor_id' => $floorId]);
		return $result[0]->total_item;
	}

} 
