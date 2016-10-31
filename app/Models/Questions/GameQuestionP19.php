<?php

namespace App\Models\Questions;

use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP19 extends AbstractGameQuestion {

    public $table = 't0219_game_question_p19';
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
			SELECT  qc.`question_id` , p19.*
				FROM `t0219_game_question_p19` p19, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p19.`id` = qc.`target_id`
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
                'essential_item_1' => $value->essential_item_1,
                'item_number_1' => $value->item_number_1,
                'essential_item_2' => $value->essential_item_2,
                'item_number_2' => $value->item_number_2,
                'essential_item_3' => $value->essential_item_3,
                'item_number_3' => $value->item_number_3,
                'essential_item_4' => $value->essential_item_4,
                'item_number_4' => $value->item_number_4,
                'budget' => $value->budget,
                'difficulty' => $value->question_id,
            ]);
        }

        return $questions;
    }

}
