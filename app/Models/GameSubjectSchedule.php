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

	public static function next($params){
		$subjectCategory = $params['subject_category'];
		$sequence = $params['sequence'];

		// $current = $this->first();
		$schedule = GameSubjectSchedule::where('subject_category', $subjectCategory)
									->where('sequence', $sequence + 1)
									->first();
		if(!$schedule){
			return false;
		}

		return $schedule;
	}

	public static function prev($params){

		$subjectCategory = $params['subject_category'];
		$sequence = $params['sequence'];

		// $current = $this->first();
		$schedule = GameSubjectSchedule::where('subject_category', $subjectCategory)
									->where('sequence', $sequence - 1)
									->first();
		if(!$schedule){
			return false;
		}
		return $schedule;
	}

}
