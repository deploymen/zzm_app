<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP60 extends AbstractGameQuestion {

    public $table = 't0260_game_question_p60';
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
			SELECT qc.`question_id`, p60.*
				FROM `t0260_game_question_p60` p60, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p60.`id` = qc.`target_id`
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
                'id' => $value->id,
                'question_1' => $value->Question_1,
                'question_2' => $value->Question_2,
                'question_3' => $value->Question_3,
                'answer_option_1' => $value->AnswerOption_1,
                'answer_option_2' => $value->AnswerOption_2,
                'answer_option_3' => $value->AnswerOption_3,
                'wrong_answer_1' => $value->WrongAnswer_1,
                'wrong_answer_2' => $value->WrongAnswer_2,
                'wrong_answer_3' => $value->WrongAnswer_3,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
