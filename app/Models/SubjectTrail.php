<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Subject;
use Planet;

class SubjectTrail extends Eloquent{

	public $table = 'subject_trail';

	protected $hidden = [];

	public static function GetNextPlanets($planetId)
	{
		// Get array of subject codes that $planetId belongs to
		$subject_codes = Planet::where('id', $planetId)->first()->subjects()->subject_code; 

		// return $planetIds that belong to the next subject codes

		$next_subject_codes =  $this->whereIn('subject_code', $subject_codes)->get()->next_subject_code;

		return Subject::whereIn('subject_code', $next_subject_codes)->get()->planets()->id;

/*
		$subject_code = Subject::where('id', 
							Planet::where('id', $planetId)->first()->subject_id)
								->first()->subject_code;

		return Planet::where('subject_id', 
				Subject::where('subject_code', 
					$this->where('subject_code', $subject_code)->first()
				->next_subject_code)->first()
				->id)
				->get();*/

	}


	public static function GetPrevPlanets($planetId)
	{
		// Get array of subject codes that $planetId belongs to
		$subject_codes = Planet::where('id', $planetId)->first()->subjects()->subject_code; 

		// return $planetIds that belong to the next subject codes

		$prev_subject_codes =  $this->whereIn('subject_code', $subject_codes)->get()->prev_subject_code;

		return Subject::whereIn('subject_code', $prev_subject_codes)->get()->planets()->id;


	/*	$subject_code = Subject::where('id', 
							Planet::where('id', $planetId)->first()->subject_id)
								->first()->subject_code;

		return Planet::where('subject_id', 
				Subject::where('subject_code', 
					$this->where('subject_code', $subject_code)->first()
				->prev_subject_code)->first()
				->id)
				->get();*/
	}

}