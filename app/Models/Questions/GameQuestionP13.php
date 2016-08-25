<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP13 extends AbstractGameQuestion {

	public $table = 't0213_game_question_p13';
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
			SELECT qc.`question_id` , p13.*
				FROM `t0213_game_question_p13` p13, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p13.`id` = qc.`target_id`
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
				'answer' => $value->answer,
				'c1' => $value->c1,
				'c1u' => $value->c1u,
				'c1d' => $value->c1d,
				'c1au'  => $value->c1au,
				'c1ad'  => $value->c1ad,
				'c2' => $value->c2,
				'c2u' => $value->c2u,
				'c2d' => $value->c2d,
				'c2au'  => $value->c2au,
				'c2ad'  => $value->c2ad,
				'c3' => $value->c3,
				'c3u' => $value->c3u,
				'c3d' => $value->c3d,
				'c3au'  => $value->c3au,
				'c3ad'  => $value->c3ad,
				'c4' => $value->c4,
				'c4u' => $value->c4u,
				'c4d' => $value->c4d,
				'c4au'  => $value->c4au,
				'c4ad'  => $value->c4ad,
				'difficulty' => $value->difficulty,
			]);
		}

		return $questions;
	}

}