<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP17 extends Eloquent {

	public $table = 't0217_game_question_p17';
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
			SELECT p17.*, qc.`question_id`
				FROM `t0217_game_question_p17` p17, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p17.`id` = qc.`target_id`
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
				'color_1' ,
				'number_1' ,
				'color_2' ,
				'number_2' ,
				'color_3' ,
				'number_3' ,
				'color_4' ,
				'number_4' ,
				'color_5' ,
				'number_5' ,
				'color_6' ,
				'number_6' ,
				'fake_color_1' ,
				'fake_number_1' ,
				'fake_color_2' ,
				'fake_number_2' ,
				'difficulty' ,
			]));
		}

		return $questions;
	}

}