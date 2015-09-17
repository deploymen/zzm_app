<?php namespace App\Http\Controllers;

use App;
use Exception;
use Config;
use Request;
use DB;
use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\AuthHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\EmailHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\DatabaseUtilHelper;

use App\Models;
use App\Models\GameProfile;
use App\Models\GamePlay;
use App\Models\GameSystem;
use App\Models\GamePlanet;
use App\Models\GameSystemPlanet;
use App\Models\GameType;
use App\Models\UserMap;
use App\Models\GameResultP01;
use App\Models\GameResultP02;
use App\Models\GameResultP03;
use App\Models\GameResultP06;
use App\Models\GameQuestion;
use App\Models\GameQuestionP04ChallengeSet;
use App\Models\GameSystemPlanet;
use App\Models\UserExternalId;


Class ApiGameMapController extends Controller {

	public function getSystem() {
		$userId = Request::input('user_id');
		

		try {
			$gameSystem = GameSystem::select('topic_main_id', 'name', 'sequence')
				->where('enable', 1)
				->orderby('sequence')
				->get();

			return ResponseHelper::OutputJSON('success', '', ['main' => $gameSystem->toArray()]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function createSystem() {
		$userId = Request::input('user_id');
		

		$name = Request::input('name');
		$sequence = Request::input('sequence', 999999);
		$topicMainId = Request::input('topic_main_id');

		if (!$name || !$topicMainId) {
			return ResponseHelper::OutputJSON('fail', "missing parameters");
		}

		try {

			$gameSystem = new GameSystem;
			$gameSystem->name = $name;
			$gameSystem->topic_main_id = $topicMainId;
			$gameSystem->sequence = $sequence;
			$gameSystem->save();

			DatabaseUtilHelper::LogInsert($userId, $gameSystem->table, $gameSystem->id);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON($ex);
		}

		return ResponseHelper::OutputJSON('success');
	}

	public function updateSystem($id) {
		$userId = Request::input('user_id');
		$wiped = [];

		try {

			$name = Request::input('name');
			$sequence = Request::input('sequence', 999999);
			$topicMainId = Request::input('topic_main_id');
			$enable = Request::input('enable');
			$gameSystem = GameSystem::find($id);

			if ($name) {
				$wiped['name'] = $gameSystem->name;
				$gameSystem->name = $name;
			}

			if ($sequence != NULL) {
				$wiped['sequence'] = $gameSystem->sequence;
				$gameSystem->sequence = $sequence;
			}
			if ($topicMainId != NULL) {
				$wiped['topic_main_id'] = $gameSystem->topicMainId;
				$gameSystem->topic_main_id = $topicMainId;
			}
			if ($enable != NULL) {
				$wiped['enable'] = $gameSystem->enable;
				$gameSystem->enable = $enable;
			}
			$gameSystem->save();

			DatabaseUtilHelper::LogUpdate($gameSystem->id, $gameSystem->table, $gameSystem->id, json_encode($wiped));
			return ResponseHelper::OutputJSON('success', '', $gameSystem->toArray());

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON("exception:you don't change anything");
		}
	}

	public function deleteSystem( $id) {
		$userId = Request::input('user_id');
		

		try {
			$gameSystem = GameSystem::find($id);
			if ($gameSystem) {
				$gameSystem->delete();
			}

			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function getPlanet($id) {
		$userId = Request::input('user_id');

		$systemPlanet = GameSystemPlanet::where('system_id' , $id)->get();
		$count = GameSystemPlanet::where('system_id' , $id)->count();
		$planet = [];
		try {

			for($i=0; $i<$count; $i++){

				array_push(
					$planet, GamePlanet::find($systemPlanet[$i]['planet_id'])
				);
			}

				return ResponseHelper::OutputJSON('success', '', ['list' => $planet]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function createPlanet() {
		$userId = Request::input('user_id');
		
		$gameTypeId = Request::input('game_type_id');
		$type = Request::input('type');
		$name = Request::input('name');
		$questionCount = Request::input('question_count');
		$questionRandom = Request::input('question_random' ,1);
		$enable = Request::input('enable', 1);

		try{

			if(!$gameTypeId || !$type || !$name || !$questionCount){
				return ResponseHelper::OutputJSON('fail', "missing parameters");
			}
			
			$gameType = GameType::find($gameTypeId);
			if(!$gameType){
				return ResponseHelper::OutputJSON('fail', "invalid game type");
			}

			switch ($type) {
				case '1': case '2': break;
				default: 
					return ResponseHelper::OutputJSON('fail', "invalid  type");
			}

			$gamePlanet = new GamePlanet;
			$gamePlanet->game_type_id = $gameTypeId;
			$gamePlanet->type = $type;
			$gamePlanet->name = $name;
			$gamePlanet->question_count = $questionCount;
			$gamePlanet->question_random = $questionRandom;
			$gamePlanet->enable = $enable;
			$gamePlanet->save();

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}

		return ResponseHelper::OutputJSON('success');
	}

	public function updatePlanet($id) {
			$userId = Request::input('user_id');
			$wiped = [];

			$gameTypeId = Request::input('game_type_id');
			$type = Request::input('type');
			$name = Request::input('name');
			$questionCount = Request::input('question_count');
			$questionRandom = Request::input('question_random' ,1);
			$enable = Request::input('enable', 1);

			try{

				$gameType = GameType::find($gameTypeId);
				if(!$gameType){
					return ResponseHelper::OutputJSON('fail', "invalid game type");
				}

				switch ($type) {
					case '1': case '2': break;
					default: 
						return ResponseHelper::OutputJSON('fail', "invalid  type");
				}


				$gamePlanet =  GamePlanet::find($id);

				if(!$gamePlanet){
					return ResponseHelper::OutputJSON('fail', "invalid planet");

				}

				if ($gameTypeId) {
					$wiped['game_type_id'] = $gamePlanet->game_type_id;
					$gamePlanet->game_type_id = $gameTypeId;
				}

				if ($type) {
					$wiped['type'] = $gamePlanet->type;
					$gamePlanet->type = $type;
				}
				if ($name) {
					$wiped['name'] = $gamePlanet->name;
					$gamePlanet->name = $name;
				}
				if ($questionCount) {
					$wiped['question_count'] = $gamePlanet->question_count;
					$gamePlanet->question_count = $questionCount;
				}	
				if ($questionRandom) {
					$wiped['question_random'] = $gamePlanet->question_random;
					$gamePlanet->question_random = $questionRandom;
				}
				if ($enable) {
					$wiped['enable'] = $gamePlanet->enable;
					$gamePlanet->enable = $enable;
				}
				
				$gamePlanet->save();
			

			} catch (Exception $ex) {
				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
			}
			return ResponseHelper::OutputJSON('success');
	}

	public function deletePlanet( $id) {
		$userId = Request::input('user_id');

		try {
		

			$GamePlanet = GamePlanet::find($id);

			if(!$GamePlanet){
				return ResponseHelper::OutputJSON('fail', "invalid planet");
			}
			if ($GamePlanet) {
				$GamePlanet->delete();
			}

			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function addToSystem(){
		$systemId = Request::input('system_id');
		$planetId = Request::input('planet_id');
		$enable = Request::input('enable', 1);

		try {

			if (!$systemId || !$planetId){
				return ResponseHelper::OutputJSON('fail', "missing parameters");
			}

			$gameSystemPlanet =  new GameSystemPlanet;
			$gameSystemPlanet->system_id = $systemId;
			$gameSystemPlanet->planet_id = $planetId;
			$gameSystemPlanet->enable = $enable;
			$gameSystemPlanet->save();

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
			return ResponseHelper::OutputJSON('success');

	}

	public function deleteSystemPlanet( $id) {
		$userId = Request::input('user_id');

		try {
		

			$GameSystemPlanet = GameSystemPlanet::find($id);

			if(!$GameSystemPlanet){
				return ResponseHelper::OutputJSON('fail', "invalid planet");
			}
			if ($GameSystemPlanet) {
				$GameSystemPlanet->delete();
			}

			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

}
