<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP17 extends AbstractGameQuestion {

    public $table = 't0217_game_question_p17';
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
			SELECT qc.`question_id` , p17.*
				FROM `t0217_game_question_p17` p17, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p17.`id` = qc.`target_id`
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
                'color_1' => $value->color_1,
                'number_1' => $value->number_1,
                'color_2' => $value->color_2,
                'number_2' => $value->number_2,
                'color_3' => $value->color_3,
                'number_3' => $value->number_3,
                'color_4' => $value->color_4,
                'number_4' => $value->number_4,
                'color_5' => $value->color_5,
                'number_5' => $value->number_5,
                'color_6' => $value->color_6,
                'number_6' => $value->number_6,
                'fake_color_1' => $value->fake_color_1,
                'fake_number_1' => $value->fake_number_1,
                'fake_color_2' => $value->fake_color_2,
                'fake_number_2' => $value->fake_number_2,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
