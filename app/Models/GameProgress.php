<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameProgress extends Eloquent {

	use SoftDeletes;
	
	public $table = 't0401_game_progress';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $fillable = ['profile_id', 'student_id', 'planet_id', 'difficulty', 'fail_count'];
	protected $hidden = [];

	public static function FailOrPass($status , $params){ // need change name

		switch ($status) {
			case 'pass':return self::pass($params); break;
			case 'fail':return self::fail($params); break;
		}

		return true;
	}

	public static function pass($params){
		$profileId = $params['profile_id'];
		$planetId = $params['planet_id'];
		$difficulty = $params['difficulty'];

		$gameProgress = GameProgress::where('profile_id' , $profileId)
							->where('planet_id' , $planetId)
							->where('difficulty', $difficulty)
							->delete();
	}

	public static function fail($params){
		$profileId = $params['profile_id'];
		$planetId = $params['planet_id'];
		$difficulty = $params['difficulty'];

		$gameProgress = GameProgress::where('profile_id' , $profileId)
									->where('planet_id' , $planetId)
									->where('difficulty', $difficulty)
									->first();
							
		if($gameProgress){
			$gameProgress->fail_count += 1;
			$gameProgress->save();
		}else{
			$gameProgress = GameProgress::create([
				'profile_id' => $profileId,
				'planet_id' => $planetId,
				'difficulty' => $difficulty,
				'fail_count' => 1
				]);
		}
	}
}