<?php

namespace App\Models\Results;

use App\Models\GameQuestion;

class GameResultP60 extends AbstractGameResult {

    public $table = 't0360_game_result_p60';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['correct', 'target_id', 'answer'];
    protected $hidden = [];

    public static function SubmitResult($params) {
        $planetId = $params['planetId'];
        $gamePlay = $params['gamePlay'];
        $gameResult = $params['gameResult'];
        $profileId = $params['profileId'];

        foreach ($gameResult['answers'] as $answer) {
            $question = GameQuestion::find($answer['question_id']);

            $result = GameResultP60::create([
                'correct' => $answer['correct'],
                'target_id' => $question->target_id,
                'answer' => $answer['answer']
            ]);

            GameResult::create([
                'play_id' => $gamePlay->id,
                'question_id' => $answer['question_id'],
                'target_type' => 'p60',
                'target_id' => $result->id,
                'game_type_id' => '60',
                'correct' => $answer['correct'],
            ]);
        }
    }

}
