<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models;
use App\Models\AvatarSet;
use App\Models\GameCode;
use App\Models\SetNickname1;
use App\Models\SetNickname2;

class LeaderBoardPlanet extends Eloquent {

	public $table = 't0603_leaderboard_planet'; 
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

}