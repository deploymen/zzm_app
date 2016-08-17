<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use DB;

class GameQuestionP07 extends Eloquent {

	public $table = 't0207_game_question_p07';
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
			SELECT p07.*, qc.`question_id`, obj.`question_object_1`,obj.`question_object_2`, obj.`question_type`
				FROM (`t0207_game_question_p07` p07, `t0126_game_planet_question_cache` qc)
					LEFT JOIN `t0207_game_question_p07_object` obj ON (obj.`question_id` = p07.`id` )
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p07.`id` = qc.`target_id`
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
				'id'
				'difficulty' => 
				'questions' => [
					'left_question_1'
					'left_question_2'
					'left_question_3'
					'right_question_1'
					'right_question_2'
					'right_question_3'
				],
				'answers' => [
					'answer' => $r->answer,
				],
			]));
		}

		return $questions;
	}

}