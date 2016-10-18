<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP58 extends AbstractGameQuestion {

	public $table = 't0258_game_question_p58';
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
			SELECT qc.`question_id`, p58.*
				FROM `t0258_game_question_p58` p58, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p58.`id` = qc.`target_id`
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
				'id' => $value->question_id,
				'number_1'  => $value->number_1,
				'number_2'  => $value->number_2,
				'number_3'  => $value->number_3,
				'answer'  => $value->answer,
				'difficulty'  => $value->difficulty,
			]);
		}

		return $questions;
	}

}