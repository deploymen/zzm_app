<?php

namespace App\Models\Results;

use App\Models\GameQuestion;

class GameResultP32 extends AbstractGameResult {

    public $table = 't0332_game_result_p32';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['correct', 'target_id', 'answer_x', 'answer_y'];
    protected $hidden = [];

    public static function SubmitResult($params) {
        $planetId = $params['planetId'];
        $gamePlay = $params['gamePlay'];
        $gameResult = $params['gameResult'];
        $profileId = $params['profileId'];

        foreach ($gameResult['answers'] as $answer) {
            $question = GameQuestion::find($answer['question_id']);

            $result = GameResultP32::create([
                        'correct' => $answer['correct'],
                        'target_id' => $question->target_id,
                        'answer_x' => $answer['answer_x'],
                        'answer_y' => $answer['answer_y'],
            ]);

            GameResult::create([
                'play_id' => $gamePlay->id,
                'question_id' => $answer['question_id'],
                'target_type' => 'p32',
                'target_id' => $result->id,
                'game_type_id' => '32',
                'correct' => $answer['correct'],
            ]);
        }
    }

}
