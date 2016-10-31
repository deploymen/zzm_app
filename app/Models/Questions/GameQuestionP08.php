<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP08 extends AbstractGameQuestion {

    public $table = 't0208_game_question_p08';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

    public static function GetQuestions($params) {
        $planetId = $params['planetId'];
        $difficulty = $params['difficulty'];
        $questionCount = $params['questionCount'];

        if (!$questionCount) {
            $questionCount = GamePlanet::find($planetId)->question_count;
        }


        $sql = "
			SELECT qc.`question_id` , p08.*
				FROM `t0208_game_question_p08` p08, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p08.`id` = qc.`target_id`
		                    	ORDER BY RAND() 
		                    		LIMIT :count
		";

        $result = DB::SELECT($sql, [
                    'planet_id' => $planetId,
                    'difficulty' => $difficulty,
                    'count' => $questionCount,
        ]);


        $questions = [];
        foreach ($result as $value) {
            array_push($questions, [
                'id' => $value->question_id,
                'param_1' => $value->param_1,
                'param_2' => $value->param_2,
                'param_3' => $value->param_3,
                'param_4' => $value->param_4,
                'param_5' => $value->param_5,
                'param_6' => $value->param_6,
                'param_7' => $value->param_7,
                'hexagon_path' => $value->hexagon_path,
                'difficulty' => $value->difficulty,
            ]);
        }



        return $questions;
    }

}
