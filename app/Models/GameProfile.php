<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models;
use App\Models\AvatarSet;
use App\Models\GameCode;
use App\Models\SetNickname1;
use App\Models\SetNickname2;


class GameProfile extends Eloquent {
	use SoftDeletes;
	
	public $table = 't0111_game_profile';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at']; 

	protected $hidden = [];


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

	public function User(){
		return $this->hasOne('App\Models\User', 'id', 'user_id');
	}
}
