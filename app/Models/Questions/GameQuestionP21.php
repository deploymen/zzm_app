<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP21 extends AbstractGameQuestion {

    public $table = 't0221_game_question_p21';
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
			SELECT qc.`question_id` ,p21.*
				FROM `t0221_game_question_p21` p21, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p21.`id` = qc.`target_id`
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
                'param_time' => $value->param_time,
                'param_minimum' => $value->param_minimum,
                'param_lazy' => $value->param_lazy,
                'param_low' => $value->param_low,
                'param_very_low' => $value->param_very_low,
                'param_peak' => $value->param_peak,
                'param_over' => $value->param_over,
                'param_increase_rate' => $value->param_increase_rate,
                'param_decrease_rate' => $value->param_decrease_rate,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
