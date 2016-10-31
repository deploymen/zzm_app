<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP03 extends AbstractGameQuestion {

    public $table = 't0203_game_question_p03';
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
			SELECT  qc.`question_id`,p03.*, obj.`question_object_1`,obj.`question_object_2`, obj.`question_type`
				FROM (`t0203_game_question_p03` p03, `t0126_game_planet_question_cache` qc)
					LEFT JOIN `t0203_game_question_p03_object` obj ON (obj.`question_id` = p03.`id` )
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p03.`id` = qc.`target_id`
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
                'question_type' => $value->question_type,
                'question_object_1' => $value->question_object_1,
                'question_object_2' => $value->question_object_2,
                'answer' => $value->answer,
                'answer_option_1' => $value->answer_option_1,
                'answer_option_2' => $value->answer_option_2,
                'image_id' => $value->image_id,
                'difficulty' => $value->difficulty,
            ]);
        }

        return $questions;
    }

}
