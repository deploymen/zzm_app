<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Spaceship extends Eloquent {
	use SoftDeletes;
	
	protected $table = 't0141_spaceship';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

	public static function getSpaceship($profileId){
		$sql = "
			SELECT s.`id` AS `spaceship_id` , s.`name` AS `spaceship_name`, f.`id` AS `floor_id` , f.`name` AS `floor_name`, i.`id` AS `item_id` , i.`name` AS `item_name`, IF(u.`selected`,u.`selected`, 0) AS `selected` , IF(u.`locked` ,u.`locked`,0) AS `locked`, IF(uf.`id` , 1, 0) AS `unlock`
				FROM (`t0141_spaceship` s, `t0142_spaceship_floor` f, `t0143_spaceship_item` i)
					LEFT JOIN `t0140_spaceship_user` u ON u.`item_id` = i.`id` AND u.`profile_id` = :profile_id
					LEFT JOIN `t0140_spaceship_user_floor` uf ON uf.`floor_id` = f.`id` AND uf.`profile_id` =:profile_id2
					WHERE s.`enable` = 1
					AND f.`enable` = 1
					AND i.`enable` = 1
					AND f.`spaceship_id` = s.`id`
					AND i.`floor_id` = f.`id`
					
					ORDER BY s.`sequence` ASC , f.`sequence` ASC , i.`sequence` ASC
		";

		$result = DB::select($sql , ['profile_id' => $profileId, 'profile_id2' => $profileId]);
		return $result;
	}

} 
