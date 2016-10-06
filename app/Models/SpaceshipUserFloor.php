<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class SpaceshipUserFloor extends Eloquent {
	use SoftDeletes;
	
	protected $table = 't0140_spaceship_user_floor';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];
	protected $fillable = ['user_id', 'profile_id' , 'floor_id' , 'locked'];

	public static function totalFloor($profileId, $spaceshipId){
		$sql = " 
			SELECT count(f.`id`) AS `total_item`
				FROM `t0140_spaceship_user_floor` u, `t0142_spaceship_floor` f
					WHERE u.`profile_id` = :profile_id
					AND u.`floor_id` = f.`id`
					AND f.`spaceship_id` = :spaceship_id
		";

		$result = DB::select($sql , ['profile_id' => $profileId , 'spaceship_id' => $spaceshipId]);
		return $result[0]->total_item;
	}
} 
