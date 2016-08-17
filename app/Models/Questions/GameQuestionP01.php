<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use DB;

class GameQuestionP01 extends Eloquent {

	public $table = 't0201_game_question_p01';
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
			SELECT p01.*, qc.`question_id`, obj.`question_object_1`,obj.`question_object_2`, obj.`question_type`
				FROM (`t0201_game_question_p01` p01, `t0126_game_planet_question_cache` qc)
					LEFT JOIN `t0201_game_question_p01_object` obj ON (obj.`question_id` = p01.`id` )
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p01.`id` = qc.`target_id`
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
				'id',
				'question' ,
				'difficulty' ,
				'questions' => [
					'angle3',
					'angle4',
					'angle5',
					'angle6',
				],
				'answers' => [
					'angle3',
					'angle4',
					'angle5',
					'angle6',
				]
			]));
		}

		return $questions;
	}

}