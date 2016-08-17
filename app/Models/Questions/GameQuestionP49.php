<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP49 extends Eloquent {

	public $table = 't0249_game_question_p49';
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
			SELECT p49.*, qc.`question_id`
				FROM `t0249_game_question_p49` p49, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p49.`id` = qc.`target_id`
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
				'question' ,
				'question_width_a' ,
				'question_length_a' ,
				'question_width_b' ,
				'question_length_b' ,
				'question_area_a' ,
				'question_area_b' ,
				'answer' ,
				'difficulty' ,
			]));
		}

		return $questions;
	}

}