<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\SoftDeletes;

class GameResultP00 extends AbstractGameResult {

    public $table = 't0300_game_result_p00';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['correct', 'target_type', 'target_id', 'answer', 'answer_option', 'answer_at', 'answer_use', 'difficulty'];
    protected $hidden = [];

    // public static function SubmitResult($params){
    // 	$planetId = $params['planetId'];
    // 	$gamePlay = $params['gamePlay'];
    // 	$gameResult = $params['gameResult'];
    // 	$profileId = $params['profileId'];
    // 	foreach ($gameResult['answers'] as $answer){
    // 		$question = GameQuestion::find($answer['question_id']);
    // 		$result = GameResultP01::create([
    // 			'correct' => $answer['correct'],
    // 			'target_id' => $question->target_id,
    // 			'answer' => $answer['answer'],
    // 			'answer_option' => $answer['answer_option'],
    // 			'difficulty' => 1,
    // 			'answer_at' => $answer['complete_time'],
    // 			'answer_use' => $answer['answer_option'],
    // 		]);
    // 		GameResult::create([
    // 			'play_id' => $gamePlay->id,
    // 			'question_id' => $answer['question_id'],
    // 			'target_type' => 'p00',
    // 			'target_id' => $result->id,
    // 			'game_type_id' => '0',
    // 			'correct' => $answer['correct'],
    // 		]);
    // 			$resultP00-> = $inAnswer[''];
    // 			$resultP00-> = $inAnswer['complete_time'] - $preUse;
    // 	}
}
