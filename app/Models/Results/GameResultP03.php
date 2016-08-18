<?php namespace App\Models\Results;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;


class GameResultP03 extends Eloquent {

	public $table = 't0303_game_result_p03';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $fillable = ['correct', 'target_type', 'target_id', 'answer', 'answer_text'];
	protected $hidden = [];

	public static function SubmitResult($params){
		$planetId = $params['planetId'];
		$gamePlay = $params['gamePlay'];
		$gameResult = $params['gameResult'];
		$profileId = $params['profileId'];

		foreach ($gameResult['answers'] as $answer){
			$question = GameQuestion::find($answer['question_id']);

			$result = GameResultP03::create([
				'correct' => $answer['correct'],
				'target_id' => $question->target_id,
				'answer_text' => $answer['answer'],
				'answer' => (strtolower($answer['answer'])=='t')?1:2,
			]);

			GameResult::create([
				'play_id' => $gamePlay->id,
				'question_id' => $answer['question_id'],
				'target_type' => 'p03',
				'target_id' => $result->id,
				'game_type_id' => '3',
				'correct' => $answer['correct'],
			]);
		}

	}
}

