<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP50 extends AbstractGameQuestion {

    public $table = 't0250_game_question_p50';
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
			SELECT qc.`question_id`, p50.*
				FROM `t0250_game_question_p50` p50, `t0126_game_planet_question_cache` qc
	                    WHERE qc.`planet_id` = :planet_id
	                    	AND qc.`difficulty` = :difficulty
	                    	AND p50.`id` = qc.`target_id`
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
                'question_number1' => $value->question_number1,
                'question_number2' => $value->question_number2,
                'answer' => $value->answer_gcf,
                'question_option' => $value->question_option,
                'answer_number1' => $value->answer_number1,
                'answer_number2' => $value->answer_number2,
                'difficulty' => $value->difficulty,
            ]);
        }

        foreach ($questions as &$question) {
            $question['question_option'] = explode(',', $question['question_option']);
            $question['answer_number1'] = explode(',', $question['answer_number1']);
            $question['answer_number2'] = explode(',', $question['answer_number2']);
        }

        return $questions;
    }

}
