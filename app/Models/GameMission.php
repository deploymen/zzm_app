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


	public static function CheckMission($threshold){

		$schedule = GamePlanetSubject::where('planet_id', $threshold->planet_id)->first()->schedule;

		//check for promotion mission
		if($threshold->mission_promotion == 'never'){
			if($threshold->type=='pass' && $threshold->difficulty==5){
				
				$schedule = $schedule->next();

				if(!$schedule){ return false; }

				$threshold->mission_promotion = 'sent';
				return self::SendMission($threshold->profile_id, $schedule, 1);
				
			}			
		}

		//check for demotion mission
		if($threshold->mission_demotion == 'never'){
			if($threshold->type=='fail'){
				switch ($threshold->hit) {
					case 2:
						//send email to parent
						break;

					case 4:						
						if($threshold->difficulty==1){
							$schedule = $schedule->prev();
							if(!$schedule){ return false; }

							$threshold->mission_demotion = 'sent';
							return self::SendMission($threshold->profile_id, $schedule, 5);
						}else{
							$threshold->mission_demotion = 'sent';
							return self::SendMission($threshold->profile_id, $schedule, $threshold->difficulty - 1);
						}
						
						break;						
					
					default: return false; break;
				}
			}
		}
	}

	public static function SendMission($profileId, $schedule, $difficulty){
		$planets = $schedule->subject->planets->toArray();
		$planet = head(shuffle($planets));

		return self::create([
			'subject_id' => $subjectId,
			'profile_id' => $profileId,
			'planet_id' => $planet['id'],
			'difficulty' => 1,
			'remark' => '',
		]);

	}

/*	public static function SendGoodNews($profileId , $planetId){

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

	}*/



}
