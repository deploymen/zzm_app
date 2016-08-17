<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP13 extends Eloquent {

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
			SELECT p13.*, qc.`question_id`
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
			array_push($questions, array_only((array)$value, [
				'id' ,
				'answer' ,
				'c1' ,
				'c1u' ,
				'c1d' ,
				'c1au'  ,
				'c1ad'  ,
				'c2' ,
				'c2u' ,
				'c2d' ,
				'c2au'  ,
				'c2ad'  ,
				'c3' ,
				'c3u' ,
				'c3d' ,
				'c3au'  ,
				'c3ad'  ,
				'c4' ,
				'c4u' ,
				'c4d' ,
				'c4au'  ,
				'c4ad'  ,
				'difficulty' ,
			]));
		}

		return $questions;
	}

}