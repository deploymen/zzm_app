<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP32 extends Eloquent {

	public $table = 't0232_game_question_p32';
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
			SELECT p32.*, qc.`question_id`
				FROM `t0232_game_question_p32` p32, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p32.`id` = qc.`target_id`
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
				'answer_x' ,
				'answer_y' ,
				'origin_x' ,
				'origin_y' ,
				'diff_x' ,
				'diff_y' ,
				'initial_x' ,
				'initial_y' ,
				'planet_1' ,
				'planet_1_x' ,
				'planet_1_y' ,
				'planet_2' ,
				'planet_2_x' ,
				'planet_2_y' ,
				'difficulty' ,
			]));
		}

		return $questions;
	}

}