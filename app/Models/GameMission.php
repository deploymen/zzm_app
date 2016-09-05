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
	protected $fillable = ['profile_id', 'subject_id', 'planet_id', 'remark', 'approved' , 'play_id' , 'status' ,'difficulty'];


	public static function CheckMission($params){

		$profileId = $params['profile_id'];
		$planetId = $params['planet_id'];
		$difficulty = $params['difficulty'];
		$gameStatus = $params['game_status'];//pass,fail

		$schedule = GamePlanetSubject::where('planet_id', $planetId)->first()->schedule;

		//check for promotion mission
		if($gameStatus=='pass' && $difficulty==5){
			
			$schedule = GameSubjectSchedule::next([
				'subject_category' => $schedule->subject_category,
				'sequence' => $schedule->sequence,
				]);

			if(!$schedule){
				return false;
			}

			self::RegisterPromotionMission($profileId, $schedule->subject_id);
		}

		//check for demotion mission
		if($gameStatus=='fail'){

			$failThreshold = PlayThresholdFail::where('profile_id' , $profileId)
								->where('planet_id' , $planetId)
								->where('difficulty', $difficulty)
								->first();

			if($failThreshold->fail_count == 2){
				die('2 time');
				$profile = GameProfile::find($profileId)->User;
				$edmHtml = (string) view('emails.news-bad', [
					
					]);

				//need update
				// self::SendEmail([
				// 	'about' => 'Welcome',
				// 	'subject' => 'BAD RESULT',
				// 	'body' => $edmHtml,
				// 	'bodyHtml' => $edmHtml,
				// 	'toAddresses' => [$profile->email],
				// ]);

			}

			if($failThreshold->fail_count != 4){
				return false;
			}
			
			if($difficulty == 1){

				$schedule = GameSubjectSchedule::prev([
					'subject_category' => $schedule->subject_category,
					'sequence' => $schedule->sequence,
				]);

				if(!$schedule){
					return false;
				}

				self::RegisterDemotionMission($profileId, $schedule->subject_id, 5);

				return true;
			}else{
				self::RegisterDemotionMission($profileId, $schedule->subject_id, ($difficulty-1));
			}
		}

	}

	public static function RegisterPromotionMission($profileId, $subjectId){
		$planet = GamePlanetSubject::where('subject_id' , $subjectId)->get()->toArray();
		shuffle($planet);

		self::create([
			'subject_id' => $subjectId,
			'profile_id' => $profileId,
			'planet_id' => $planet[0]['planet_id'],
			'difficulty' => 1,
			'remark' => 'need update',
			]);

		return true;
	}

	public static function RegisterDemotionMission($profileId, $subjectId , $difficulty){
		$planet = GamePlanetSubject::where('subject_id' , $subjectId)->get()->toArray();
		shuffle($planet);

		self::create([
			'subject_id' => $subjectId,
			'profile_id' => $profileId,
			'planet_id' => $planet[0]['planet_id'],
			'difficulty' => $difficulty,
			'remark' => 'need update',
			]);

		return true;
	}





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



}
