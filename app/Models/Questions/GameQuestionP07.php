<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP07 extends AbstractGameQuestion {

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
			SELECT p07.*, qc.`question_id`
				FROM `t0207_game_question_p07` p07, `t0126_game_planet_question_cache` qc
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
			array_push($questions, [
				'id' => $value->question_id,
				'difficulty' => $value->difficulty,
				'questions' => [
					'left_question_1'=>$value->left_question_1,
					'left_question_2'=>$value->left_question_2,
					'left_question_3'=>$value->left_question_3,
					'right_question_1'=>$value->right_question_1,
					'right_question_2'=>$value->right_question_2,
					'right_question_3'=>$value->right_question_3,
				],
				'answers' => [
					'answer' => $value->answer,
				],
				
			]);
		}

		return $questions;
	}

}