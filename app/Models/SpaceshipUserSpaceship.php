<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class SpaceshipUserSpaceship extends Eloquent {
	use SoftDeletes;
	
	protected $table = 't0140_spaceship_user_spaceship';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

	public static function totalFloor($profileId, $spaceshipId){
		$sql = " 
			SELECT count(f.`id`) AS `total_floor`
				FROM `t0140_spaceship_user` u, `t0143_spaceship_floor` f
					WHERE u.`profile_id` = :profile_id
					AND u.`item_id` = f.`id`
					AND f.`floor_id` = :spaceship_id
		";

		$result = DB::select($sql , ['profile_id' => $profileId , 'spaceship_id' => $spaceshipId]);
		return $result[0]->total_floor;
	}
} 
