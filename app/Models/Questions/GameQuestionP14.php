<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP14 extends AbstractGameQuestion {

    public $table = 't0214_game_question_p14';
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
			SELECT  qc.`question_id` , p14.*
				FROM `t0214_game_question_p14` p14, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p14.`id` = qc.`target_id`
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
                'answer' => $value->answer,
                'op' => $value->operator,
                'number1' => $value->number1,
                'number1_multiplier' => $value->number1_multiplier,
                'number2' => $value->number2,
                'number2_multiplier' => $value->number2_multiplier,
                'number3' => $value->number3,
                'number3_multiplier' => $value->number3_multiplier,
                'answer_option_1' => $value->answer_option_1,
                'answer_option_2' => $value->answer_option_2,
                'answer_option_3' => $value->answer_option_3,
                'answer_option_4' => $value->answer_option_4,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
