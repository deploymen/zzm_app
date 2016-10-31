<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP32 extends AbstractGameQuestion {

    public $table = 't0232_game_question_p32';
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
			SELECT  qc.`question_id` ,p32.*
				FROM `t0232_game_question_p32` p32, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p32.`id` = qc.`target_id`
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
                'answer_x' => $value->answer_x,
                'answer_y' => $value->answer_y,
                'origin_x' => $value->origin_x,
                'origin_y' => $value->origin_y,
                'diff_x' => $value->diff_x,
                'diff_y' => $value->diff_y,
                'initial_x' => $value->initial_x,
                'initial_y' => $value->initial_y,
                'planet_1' => $value->planet_1,
                'planet_1_x' => $value->planet_1_x,
                'planet_1_y' => $value->planet_1_y,
                'planet_2' => $value->planet_2,
                'planet_2_x' => $value->planet_2_x,
                'planet_2_y' => $value->planet_2_y,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
