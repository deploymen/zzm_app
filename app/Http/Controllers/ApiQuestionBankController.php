<?php namespace App\Http\Controllers;

use Libraries;
use Models;

Class ApiQuestionBankController extends Controller {

	public function get() {
		$userId = \Request::input('user_id');

		$gameTypeId = \Request::input('game_type_id');
		$topicMainId = \Request::input('topic_main_id');
		$topicSubId = \Request::input('topic_sub_id');

		try {
			$list = Models\GameQuestion::select('game_type_id', 'topic_main_id', 'topic_sub_id', 'question', 'answer')
				->where('game_type_id', $gameTypeId)
				->where('topic_main_id', $topicMainId)
				->where('topic_sub_id', $topicSubId)
				->where('enable', 1)->get();

			return Libraries\ResponseHelper::OutputJSON('success', '', ['list' => $list->toArray()]);

		} catch (\Exception $ex) {
			Libraries\LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => \Request::all(),
			])]);
			return Libraries\ResponseHelper::OutputJSON('exception');
		}}

	public function create() {
		$userId = \Request::input('user_id');

		$questionKeys = [
			'game_type_id', 'topic_main_id', 'topic_sub_id', 'question', 'answer', 'enable',
			'answer_option_1', 'answer_option_2', 'answer_option_3', 'answer_option_4', 'answer_option_5', 'answer_option_6',
		];

		foreach ($questionKeys as $key) {
			if (!preg_match('/answer_option_/', $key) && !\Request::input($key)) {
				return Libraries\ResponseHelper::OutputJSON('fail', "missing parameters");
			}
		}

		$gameTypeId = \Request::input('game_type_id');
		$topicMainId = \Request::input('topic_main_id');
		$topicSubId = \Request::input('topic_sub_id');
		$questionText = \Request::input('question');
		$answer = \Request::input('answer');

		try {

			if (!Models\GameType::find($gameTypeId)->first()) {
				return Libraries\ResponseHelper::OutputJSON('fail', "invalid game_type_id");
			}
			if (!Models\TopicMain::find($topicMainId)->first()) {
				return Libraries\ResponseHelper::OutputJSON('fail', "invalid topic_main_id");
			}
			if (!Models\TopicSub::find($topicSubId)->first()) {
				return Libraries\ResponseHelper::OutputJSON('fail', "invalid topic_sub_id");
			}
			if (!Libraries\QuestionHelper::ValidateQuestion($gameTypeId, $questionText, $answer)) {
				return Libraries\ResponseHelper::OutputJSON('fail', "invalid question/answer");
			}

			$question = new Models\GameQuestion;
			foreach ($questionKeys as $key) {
				$value = \Request::input($key);
				if ($value != NULL) {
					$question->$key = $value;
				}
			}
			$question->save();

			Libraries\DatabaseUtilHelper::LogInsert($userId, $question->table, $question->id);

		} catch (\Exception $ex) {
			Libraries\LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => \Request::all(),
			])]);
			return Libraries\ResponseHelper::OutputJSON('exception');
		}

		return Libraries\ResponseHelper::OutputJSON('success');
	}

	public function update($id) {
		$userId = \Request::input('user_id');

		$questionKeys = [
			'game_type_id', 'topic_main_id', 'topic_sub_id', 'question', 'answer', 'enable',
			'answer_option_1', 'answer_option_2', 'answer_option_3', 'answer_option_4', 'answer_option_5', 'answer_option_6',
		];

		try {
			$question = Models\GameQuestion::find($id);
			if (!$question) {
				return Libraries\ResponseHelper::OutputJSON('fail', "question not found");
			}

			$wipeds = [];
			foreach ($questionKeys as $key) {
				$value = \Request::input($key);
				if ($value != NULL) {
					$wipeds[$key] = $question->$key;
					$question->$key = $value;
				}
			}
			$question->save();

			Libraries\DatabaseUtilHelper::LogUpdate($userId, $question->table, $question->id, json_encode($wipeds));
			return Libraries\ResponseHelper::OutputJSON('success', '', $wipeds->toArray());

		} catch (\Exception $ex) {
			Libraries\LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => \Request::all(),
			])]);
			return Libraries\ResponseHelper::OutputJSON('exception');
		}
	}

	public function delete($id) {
		$userId = \Request::input('user_id');
		
		try {
			$question = Models\GameQuestion::find($id);
			if (!$question) {
				return Libraries\ResponseHelper::OutputJSON('fail', "question not found");
			}

			$question->delete();
			return Libraries\ResponseHelper::OutputJSON('success');

		} catch (\Exception $ex) {
			Libraries\LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => \Request::all(),
			])]);
			return Libraries\ResponseHelper::OutputJSON('exception');
		}
	}

	public function createGameWorksheet() {
		$userId = \Request::input('user_id');
		
		$questionIds = \Request::input('question_ids');
		
		$worksheetProperties = [
			'name' => \Request::input('name'),
			'game_type_id' => \Request::input('game_type_id'),
			'type' => 'game',
			'question_count' => \Request::input('question_count'),
			'question_random' => \Request::input('question_random'),
		];

		if (!$questionIds) {
			return Libraries\ResponseHelper::OutputJSON('fail', "missing parameters");
		}

		foreach ($worksheetProperties as $value) {
			if ($value == NULL) {
				return Libraries\ResponseHelper::OutputJSON('fail', "missing parameters");
			}
		}

		$questionIds = explode(',', $questionIds);
		foreach ($questionIds as $id) {
			$question = Models\GameQuestion::find($id);
			if (!$question) {
				return Libraries\ResponseHelper::OutputJSON('fail', "question not found: {$id}");
			}
		}

		\DB::transaction(function () use ($worksheetProperties, $questionIds) {
			$worksheet = new Models\GameWorksheet;
			foreach ($worksheetProperties as $key => $value) {
				$worksheet->$key = $value;
			}
			$worksheet->save();

			$sequence = 1;
			foreach ($questionIds as $id) {
				$question = Models\GameQuestion::find($id);
				if ($question) {
					$worksheetQuestion = new Models\GameWorksheetQuestion;
					$worksheetQuestion->worksheet_id = $worksheet->id;
					$worksheetQuestion->sequence = ($worksheetProperties['question_random'] == '0') ? 0 : $sequence++;
					$worksheetQuestion->question_id = $id;
					$worksheetQuestion->topic_main_id = $question->topic_main_id;
					$worksheetQuestion->topic_sub_id = $question->topic_sub_id;
					$worksheetQuestion->save();
				}
			}

		});

		return Libraries\ResponseHelper::OutputJSON('success');
	}
}