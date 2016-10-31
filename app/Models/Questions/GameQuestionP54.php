<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP54 extends AbstractGameQuestion {

    public $table = 't0254_game_question_p54';
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
			SELECT qc.`question_id`, p54.*
				FROM `t0254_game_question_p54` p54, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p54.`id` = qc.`target_id`
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
                'question_object' => $value->question_object,
                'answer_option_1' => $value->answer_option_1,
                'answer_option_2' => $value->answer_option_2,
                'answer_option_3' => $value->answer_option_3,
                'answer_option_4' => $value->answer_option_4,
                'answer_option_5' => $value->answer_option_5,
                'plot_point' => $value->plot_point,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
