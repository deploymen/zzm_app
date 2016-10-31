<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP49 extends AbstractGameQuestion {

    public $table = 't0249_game_question_p49';
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
			SELECT qc.`question_id`,  p49.*
				FROM `t0249_game_question_p49` p49, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p49.`id` = qc.`target_id`
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
                'question' => $value->question,
                'question_width_a' => $value->question_width_a,
                'question_length_a' => $value->question_length_a,
                'question_width_b' => $value->question_width_b,
                'question_length_b' => $value->question_length_b,
                'question_area_a' => $value->question_area_a,
                'question_area_b' => $value->question_area_b,
                'answer' => $value->answer,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
