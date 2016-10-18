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

	protected $hidden = ['created_at' , 'updated_at' , 'deleted_at'];
	protected $fillable = ['profile_id', 'subject_id', 'planet_id', 'remark', 'approved' , 'play_id' , 'status' ,'difficulty'];


	public static function CheckMission($threshold){
		try{

			$schedule = GamePlanetSubject::where('planet_id', $threshold->planet_id)->first()->schedule;

			//check for promotion mission
			if($threshold->mission_promotion == 'never'){
				if($threshold->type=='pass' && $threshold->difficulty==5){
					
					$schedule = $schedule->next();
					if(!$schedule){
						return false;
					}

					$mission = self::SendMission($threshold->profile_id, $schedule, 1);
					$threshold->mission_promotion = 'sent';

					return $mission;
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
								$mission = self::SendMission($threshold->profile_id, $schedule, 5);
							}else{
								$mission = self::SendMission($threshold->profile_id, $schedule, $threshold->difficulty - 1);
							}
							$threshold->mission_demotion = 'sent';
							return $mission;
							break;						
						
						default: break;
					}
				}
			}
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'GameMission > CheckMission',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function SendMission($profileId, $schedule, $difficulty){
		try{

			$planets = $schedule->subject->planets->toArray();
			if(empty($planets)){
				throw new Exception("No planet for subject: ".$schedule->subject->id);		
			}

			shuffle($planets);

			return self::create([
				'subject_id' => $schedule->subject->id,
				'profile_id' => $profileId,
				'planet_id' => head($planets)['id'],
				'difficulty' => 1,
			]);
			
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'GameMission > SendMission',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GetMission($profileId){
        $mission = self::where('profile_id' , $profileId)->where('approved', 1)->where('status', 'open')->groupBy('planet_id')->limit(3)->orderBy('created_at' , 'desc')->get();
        return $mission;
    }

}
