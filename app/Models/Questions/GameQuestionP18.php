<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP18 extends AbstractGameQuestion {

	public $table = 't0218_game_question_p18';
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
			SELECT  qc.`question_id` , p18.*
				FROM `t0218_game_question_p18` p18, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p18.`id` = qc.`target_id`
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
				'question' => $value->question,
				'option_from' => $value->option_from,
				'option_until_total' => $value->option_until_total,
				'answer' => $value->answer,
				'ruler_type' => $value->ruler_type,
				'difficulty' => $value->difficulty,
			]);
		}

		return $questions;
	}

}