<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP31 extends AbstractGameQuestion {

	public $table = 't0231_game_question_p31';
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
			SELECT qc.`question_id` , p31.*
				FROM `t0231_game_question_p31` p31, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p31.`id` = qc.`target_id`
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
			array_push($questions, [
				'id'=> $value->question_id,
				'question_param_1' => $value->question_param_1,
				'question_param_2' => $value->question_param_2,
				'question_param_3' => $value->question_param_3,
				'question_option' => $value->question_option,
				'answer_1' => $value->answer_1,
				'answer_2' => $value->answer_2,
				'answer_3' => $value->answer_3,
				'difficulty' => $value->difficulty,
			]);
		}

		return $questions;
	}

}