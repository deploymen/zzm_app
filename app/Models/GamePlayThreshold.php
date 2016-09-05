<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GamePlayThreshold extends Eloquent {

	use SoftDeletes;
	
	public $table = 't0401_game_play_threshold';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $fillable = ['profile_id', 'planet_id', 'difficulty', 'type', 'hit'];
	protected $hidden = [];




	public static function UpdateThreshold($profileId, $planetId, $difficulty, $status){ 
		$thredhold = GamePlayThreshold::where('profile_id', $profileId)
									->where('planet_id', $planetId)
									->where('difficulty', $difficulty)
									->first();

		if(!$thredhold){
			$thredhold = GamePlayThreshold::create([
				'profile_id' => $profileId,
				'planet_id' => $planetId,
				'difficulty' => $difficulty,
				'type' => $status,
			]);
		}

		if($thredhold->type == $status){
			$thredhold->hit += 1;
		}else{
			$thredhold->type = $status;
			$thredhold->hit = 1;
		}

		$thredhold->save();

		return $thredhold;
	}
}