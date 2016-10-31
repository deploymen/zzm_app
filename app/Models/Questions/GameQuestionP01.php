<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanet;
use App\Models\Questions\AbstractGameQuestion;
use DB;

class GameQuestionP01 extends AbstractGameQuestion {

    public $table = 't0201_game_question_p01';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

    public static function GetQuestions($params) {
        $planetId = $params['planetId'];
        $difficulty = $params['difficulty'];
        $questionCount = $params['questionCount'];
        $language = $params['language'];

        if (!$questionCount) {
            $questionCount = GamePlanet::find($planetId)->question_count;
        }

        switch ($language) {
            case 'en': $languageTable = '`t0201_game_question_p01_en`';
                break;
            case 'my': $languageTable = '`t0201_game_question_p01_my`';
                break;
        }


        $sql = "
			SELECT l.`question`,p01.`difficulty`, p01.`question_angle3`,p01.`question_angle4`,p01.`question_angle5`,p01.`question_angle6`,p01.`answer_angle3`, p01.`answer_angle4`,p01.`answer_angle5`,p01.`answer_angle6`,qc.`question_id`
					FROM `t0201_game_question_p01` p01, {$languageTable}  l , `t0126_game_planet_question_cache` qc 
                        WHERE qc.`planet_id` = :planet_id
                        	AND qc.`difficulty` = :difficulty
                        	AND p01.`id` = qc.`target_id`
                        	AND l.`question_id` = qc.`target_id`

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
                'difficulty' => $value->difficulty,
                'questions' => [
                    'angle3' => $value->question_angle3,
                    'angle4' => $value->question_angle4,
                    'angle5' => $value->question_angle5,
                    'angle6' => $value->question_angle6,
                ],
                'answers' => [
                    'angle3' => $value->answer_angle3,
                    'angle4' => $value->answer_angle4,
                    'angle5' => $value->answer_angle5,
                    'angle6' => $value->answer_angle6,
                ],
            ]);
        }

        return $questions;
    }

}
