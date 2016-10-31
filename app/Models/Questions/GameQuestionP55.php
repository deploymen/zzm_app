<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP55 extends AbstractGameQuestion {

    public $table = 't0255_game_question_p55';
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
			SELECT qc.`question_id`, p55.*
				FROM `t0255_game_question_p55` p55, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p55.`id` = qc.`target_id`
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
                'question_3' => $value->question_3,
                'answer_1' => $value->answer_1,
                'answer_2' => $value->answer_2,
                'answer_3' => $value->answer_3,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
