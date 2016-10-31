<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP28 extends AbstractGameQuestion {

    public $table = 't0228_game_question_p28';
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
			SELECT qc.`question_id` , p28.*
				FROM `t0228_game_question_p28` p28, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p28.`id` = qc.`target_id`
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
                'question_param_1' => $value->question_param_1,
                'question_param_2' => $value->question_param_2,
                'question_param_3' => $value->question_param_3,
                'question' => $value->question,
                'answer' => $value->answer,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
