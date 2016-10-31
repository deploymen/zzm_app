<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP12 extends AbstractGameQuestion {

    public $table = 't0212_game_question_p12';
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
			SELECT  qc.`question_id` , p12.*
				FROM `t0212_game_question_p12` p12, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p12.`id` = qc.`target_id`
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
                'option1' => $value->option1,
                'option1_num' => $value->option1_num,
                'option2' => $value->option2,
                'option2_num' => $value->option2_num,
                'option3' => $value->option3,
                'option3_num' => $value->option3_num,
                'option4' => $value->option4,
                'option4_num' => $value->option4_num,
                'prefix1' => $value->prefix1,
                'prefix2' => $value->prefix2,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
