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

	public function prev(){

		$schedule = GameSubjectSchedule::where('subject_category', $this->subject_category)
									->where('sequence', $this->sequence + 1)
									->first();
		if(!$schedule){
			return false;
		}

		return $schedule;
	}

	public function next(){

		$schedule = GameSubjectSchedule::where('subject_category', $this->subject_category)
									->where('sequence', $this->sequence - 1)
									->first();
		if(!$schedule){
			return false;
		}

		return $schedule;
	}

	public function planets(){
		return $this->belongsToMany('App\Models\GamePlanet', 'App\Models\GamePlanetSubject', 'subject_id', 'planet_id', 'subject_id');
	}

}
