<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP51 extends AbstractGameQuestion {

    public $table = 't0251_game_question_p51';
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
			SELECT qc.`question_id`, p51.*
				FROM `t0251_game_question_p51` p51, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p51.`id` = qc.`target_id`
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
                'question_1' => $value->question_1,
                'question_2' => $value->question_2,
                'answer' => $value->answer,
                'answer_option_1' => $value->answer_option_1,
                'answer_option_2' => $value->answer_option_2,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
