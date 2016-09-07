<?php namespace App\Models\Results;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GameQuestion;
class GameResultP02 extends AbstractGameResult {

	public $table = 't0302_game_result_p02';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $fillable = ['correct', 'target_id', 'answer_1', 'answer_2' ,'answer_3' ,'answer_4' ,'answer_5' ,'answer_6' ];
	protected $hidden = [];

	public static function SubmitResult($params){
		$planetId = $params['planetId'];
		$gamePlay = $params['gamePlay'];
		$gameResult = $params['gameResult'];
		$profileId = $params['profileId'];

		foreach ($gameResult['answers'] as $answer){
			$question = GameQuestion::find($answer['question_id']);

			$answers = array_merge(explode("," , $answer['answer']), [0,0,0,0,0,0]);	

			$result = GameResultP02::create([
				'correct' => $answer['correct'],
				'target_id' => $question->target_id,
				'answer_1' => $answers[0],
				'answer_2' => $answers[1],
				'answer_3' => $answers[2],
				'answer_4' => $answers[3],
				'answer_5' => $answers[4],
				'answer_6' => $answers[5],
			]);

			GameResult::create([
				'play_id' => $gamePlay->id,
				'question_id' => $answer['question_id'],
				'target_type' => 'p02',
				'target_id' => $result->id,
				'game_type_id' => '2',
				'correct' => $answer['correct'],
			]);
		}

	}
}