<?php namespace App\Models\Results;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GameQuestion;
class GameResultP01 extends AbstractGameResult {

	public $table = 't0301_game_result_p01';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $fillable = ['correct', 'target_id', 'angle3' , 'angle4' , 'angle5' , 'angle6'];
	protected $hidden = [];

	public static function SubmitResult($params){
		$planetId = $params['planetId'];
		$gamePlay = $params['gamePlay'];
		$gameResult = $params['gameResult'];
		$profileId = $params['profileId'];

		foreach ($gameResult['answers'] as $answer){
			$question = GameQuestion::find($answer['question_id']);

			$result = GameResultP01::create([
				'correct' => $answer['correct'],
				'target_id' => $question->target_id,
				'angle3' => $answer['answer']['angle3'],
				'angle4' => $answer['answer']['angle4'],
				'angle5' => $answer['answer']['angle5'],
				'angle6' => $answer['answer']['angle6'],
			]);

			GameResult::create([
				'play_id' => $gamePlay->id,
				'question_id' => $answer['question_id'],
				'target_type' => 'p01',
				'target_id' => $result->id,
				'game_type_id' => '1',
				'correct' => $answer['correct'],
			]);
		}
	}
}