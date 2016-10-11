<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models;
use App\Models\AvatarSet;
use App\Models\GameCode;
use App\Models\SetNickname1;
use App\Models\SetNickname2;
use DB;

class GameProfile extends Eloquent {
	use SoftDeletes;
	
	public $table = 't0111_game_profile';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at']; 

	protected $hidden = ['created_at' , 'updated_at' , 'deleted_at'];
	protected $fillable = ['profile_type', 'user_id', 'class_id' , 'student_id' , 'first_name' , 'age' , 'school' , 'grade' , 'country' , 'latitude' , 'longitude' , 'city' , 'nickname1' , 'nickname2' , 'avatar_id' , 'coin' , 'expired_at' , 'seed'];


	public function avatar() {
		return $this->hasOne('App\Models\AvatarSet', 'id', 'avatar_id');
	}

	public function gameCode() {
		return $this->hasOne('App\Models\GameCode', 'profile_id', 'id');
	}

	public function nickName1() {
		return $this->hasOne('App\Models\SetNickname1', 'id', 'nickname1');
	}

	public function nickName2() {
		return $this->hasOne('App\Models\SetNickname2', 'id', 'nickname2');
	}

	public static function checkStudentId($studentId){
		$sql = "
			SELECT * 
				FROM `t0111_game_profile` 
					WHERE `student_id` = :student_id
		";

		return DB::select($sql , ['student_id' => $studentId]);
	}
}
