<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameSubjectSchedule extends Eloquent {
	use SoftDeletes;

	public $table = 't0133_game_subject_schedule';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

	public static function GetNextPlanets($order , $planetId){

		$planetSubject = GamePlanetSubject::where('planet_id', $planetId)->first();

		switch ($order){
			case 'next' : 
				$nextPlanet = GameSubjectSchedule::where('subject_from', $planetSubject->subject_code)->select('subject_to')->first();
				$planet = GamePlanetSubject::where('subject_code' , $nextPlanet->subject_to)->get();
				break;

			case 'prev' : 
				$nextPlanet = GameSubjectSchedule::where('subject_to' , $planetSubject->subject_code)->select('subject_from')->first();
				$planet = GamePlanetSubject::where('subject_code' , $nextPlanet->subject_from)->get();
				break;
		}

		return $planet;
	}
}
