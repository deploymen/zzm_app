<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanetSubject;
use DB;

class GameMission extends Eloquent {
	use SoftDeletes;

	public $table = 't0118_game_mission';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

	public static function CheckMission($params){

		$profileId = $params['profile_id'];
		$planetId = $params['planet_id'];
		$difficulty = $params['difficulty'];
		$gameStatus = $param['game_status'];//pass,fail

		$schedule = GamePlanetSubject::where('planet_id', $planetId)->first()->schedule;

		//check for promotion mission
		if($gameStatus=='pass' && $difficulty==5){
			$schedule = $schedule->next;
			if(!$schedule){
				return false;
			}
			self::RegisterPromotionMission($profileId, $planetId);

		}

		//check for demotion mission
		if($gameStatus=='fail'){
			$failThreshold = PlayThresholdFail::where('profile_id' , $profileId)
								->where('planet_id' , $planetId)
								->where('difficulty', $difficulty)
								->first();

			$failThreshold->fail_count += 1;
			$failThreshold->save();

			if($failThreshold->fail_count != 4){
				return false;
			}
				
			$schedule = $schedule->prev;
			if(!$schedule){
				return false;
			}
			self::RegisterDemotionMission($profileId, $planetId);

		}


/*		switch($gameStatus){
			case 'pass': 
				$userMap = UserMap::where('profile_id' , $profileId)->where('planet_id' , $planetId)->first();

				if($userMap->sent == 1 || $userMap->star != 5){
					return True;
				}
			break;

			case 'fail': 
				$gameProgress = PlayThresholdFail::where('profile_id' , $profileId)
									->where('planet_id' , $planetId)
									->where('difficulty', $difficulty)
									->first();

				if($gameProgress->fail_count == 2){
					//send bad news
				}

				if($gameProgress->fail_count == 4){
					//send mission
				}

			break;
		}*/

	}

	public static function RegisterPromotionMission($profileId, $planetId){}

	public static function RegisterDemotionMission($profileId, $planetId){}





	public static function SendGoodNews($profileId , $planetId){

		$nextPlanet = GameSubjectSchedule::GetNextPlanets('next' , $planetId);
		$planet = GamePlanet::where('id', $nextPlanet->planet_id);
		$user = GameProfile::find($profileId)->User;

		$edmHtml = (string) view('emails.news-good', [

			]);
		
		self::SendEmail([
			'about' => 'Welcome',
			'subject' => 'Your Zap Zap Account is now ready!',
			'body' => $edmHtml,
			'bodyHtml' => $edmHtml,
			'toAddresses' => [$user->email],
		]);

		$userMap->sent = 1;
		$userMap->save();

	}

	public static function SendBadNews($profileId){
		
		$profile = GameProfile::find($profileId)->User;

		$edmHtml = (string) view('emails.news-bad', [
			
			]);
		
		self::SendEmail([
			'about' => 'Welcome',
			'subject' => 'Your Zap Zap Account is now ready!',
			'body' => $edmHtml,
			'bodyHtml' => $edmHtml,
			'toAddresses' => [$profile->email],
		]);
	}


}
