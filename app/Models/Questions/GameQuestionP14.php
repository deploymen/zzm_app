<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP14 extends Eloquent {

	public $table = 't0214_game_question_p14';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];


	public static function GetQuestions($params){
		$planetId = $params['planetId'];
		$difficulty = $params['difficulty'];
		$questionCount = $params['questionCount'];

		if(!$questionCount){
			$questionCount = GamePlanet::find($planetId)->question_count;
		}


		$sql = "
			SELECT p14.*, qc.`question_id`
				FROM `t0214_game_question_p14` p14, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p14.`id` = qc.`target_id`
		                    	ORDER BY RAND() 
		                    		LIMIT :count
		";
		
		$result = DB::SELECT($sql,[
			'planet_id' => $planetId,
			'difficulty' => $difficulty,
			'count' => $questionCount,
		]);	

		$questions = [];
		foreach ($result as $value){
			array_push($questions, array_only((array)$value, [
				'id' ,
				'answer' ,
				'op' ,
				'number1' ,
				'number1_multiplier' ,
				'number2' ,
				'number2_multiplier' ,
				'number3' ,
				'number3_multiplier' ,
				'answer_option_1' ,
				'answer_option_2' ,
				'answer_option_3' ,
				'answer_option_4' ,
				'difficulty' ,
			]));
		}

		return $questions;
	}

}