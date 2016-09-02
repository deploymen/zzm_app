<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanetSubject;
use DB;

class GameSubjectSchedule extends Eloquent {
	use SoftDeletes;

	public $table = 't0133_game_subject_schedule';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

	public function next(){
		$current = $this->first();
		return GameSubjectSchedule::where('subject_id', $current->subject_id)
									->where('subject_category', $current->subject_category)
									->where('sequence', $current->sequence - 1)
									->first();
	}

	public function prev(){
		$current = $this->first();
		return GameSubjectSchedule::where('subject_id', $current->subject_id)
									->where('subject_category', $current->subject_category)
									->where('sequence', $current->sequence + 1)
									->first();
	}

/*	public static function GetPlanets($planetId, $direction = 'next'){

		$subject = GamePlanetSubject::where('planet_id', $planetId)->first();
		$subjectTarget = GameSubjectSchedule::where('subject')->first();



		switch($order){
			case 'next' : 
				// $nextPlanet = self::where('subject_from', $planetSubject->subject_code)->first();
				// $subject = GamePlanetSubject::where('subject_code' , $nextPlanet->subject_to)->get()->toArray();

				$sql = "
					SELECT ps.`subject_code` , `planet_id`
						FROM `t0133_game_subject_schedule` ss , `t0132_game_planet_subject` ps
							WHERE ss.`subject_from` = :subject_code
								AND ps.`subject_code` = ss.`subject_to`
						ORDER BY RAND()
				";

				$result = DB::select($sql , [ 'subject_code' => $planetSubject->subject_code]);
				break;

			case 'prev':
				$nextPlanet = self::where('subject_to' , $planetSubject->subject_code)->first();
				$subject = GamePlanetSubject::where('subject_code' , $nextPlanet->subject_from)->get()->toArray();
				break;

			default: break;
		}
		
		return $result;
	}
*/





}
