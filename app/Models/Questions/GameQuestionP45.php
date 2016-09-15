<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP45 extends AbstractGameQuestion {

	public $table = 't0245_game_question_p45';
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
			SELECT qc.`question_id`,  p45.*
				FROM `t0245_game_question_p45` p45, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p45.`id` = qc.`target_id`
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
				'question'=> $value->question,
				'question_unit'=> $value->question_unit,
				'answer_1'=> $value->answer_1,
				'answer_1_unit'=> $value->answer_1_unit,
				'answer_2'=> $value->answer_2,
				'answer_2_unit'=> $value->answer_2_unit,
				'difficulty'=> $value->difficulty,
			]);
		}

		return $questions;
	}

}