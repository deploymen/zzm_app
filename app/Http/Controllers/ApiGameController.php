<?php namespace App\Http\Controllers;

use App;
use Exception;
use Config;
use Request;
use DB;
use Response;
use Zipper;
use Cache;
use Carbon\Carbon;
use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\AuthHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\EmailHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\DatabaseUtilHelper;
use App\Libraries\ZapZapQuestionHelper;

use App\Models;
use App\Models\GameProfile;
use App\Models\User;
use App\Models\GameClass;
use App\Models\GamePlay;
use App\Models\GameCode;
use App\Models\GameSystem;
use App\Models\GamePlanet;
use App\Models\GameType;
use App\Models\UserMap;
use App\Models\GameResult;
use App\Models\GameResultP01;
use App\Models\GameResultP02;
use App\Models\GameResultP03;
use App\Models\GameResultP06;
use App\Models\GameResultP07;
use App\Models\GameQuestion;
//use App\Models\GameQuestionp03;
use App\Models\GameQuestionP04ChallengeSet;
use App\Models\GameSystemPlanet;
use App\Models\UserExternalId;
use App\Models\LeaderboardWorld;
use App\Models\LeaderboardSystem;
use App\Models\LeaderboardPlanet;
use App\Models\IdCounter;
use App\Models\GameCoinTransaction;

use App\Models\Questions\AbstractGameQuestion;
use App\Models\Results\AbstractGameResult;




Class ApiGameController extends Controller {

	//GET QUESTION
	public function requestV1_0($planetId , $language = 'en') {	

		$ON_CACHE = false;
		
		try{
			$gameCode = Request::input('game_code');
			$difficulty = Request::input('difficulty');			
			$questionCount = Request::input('question_count');
			$profileId =  Request::input('game_code_profile_id');//middle

			LogHelper::LogGetQuestions($planetId, $gameCode);

			$planetCacheKey = join('.', ['ApiGameController@request', 'v1.0', 'planet', $planetId]);		
		
			// get planet info
			if ($ON_CACHE && Cache::has($planetCacheKey)) {
				$planet = Cache::get($planetCacheKey);

			}else{
				$planet = GamePlanet::where('available', 1)
					->where('id', '>=', 100)
					->find($planetId);

				if(!$planet){
					return ResponseHelper::OutputJSON('fail', 'planet not found');
				}

				Cache::put($planetCacheKey, $planet, Carbon::now()->addMinutes(60));
			}
			
			$userMap = ZapZapQuestionHelper::GetUserMapPersonal($profileId, $planetId);

			//fethcing top scores
			$planetTopScore = ZapZapQuestionHelper::GameScreenPlanetTopScore($planetId);
			$topScoreResult = [];
			for($i=0; $i<count($planetTopScore); $i++){
				array_push($topScoreResult,  [
					'nickname1'=>$planetTopScore[$i]->nickname1,
					'nickname2'=>$planetTopScore[$i]->nickname2,
					'avatar'=>$planetTopScore[$i]->avatar,
					'score'=>$planetTopScore[$i]->score,
				]);
			}
			
			if(!in_array($difficulty, range(1, 5))){
				$difficulty = $userMap->star + 1;
				if($difficulty > 5){ $difficulty = 5; }
			}

			$level = $userMap->level;
			$planetDifficultyCacheKey = join('.', ['ApiGameController@request', 'v1.0', 'planet', $planetId, 'difficulty', $difficulty]);
			if ($ON_CACHE && Cache::has($planetDifficultyCacheKey)){
			 	$questions = Cache::get($planetDifficultyCacheKey);

			}else{
				
				$type = GameType::find($planet->game_type_id);

				$questions = AbstractGameQuestion::GetTypeQuestions($type->name, [
					'planetId' => $planetId, 
					'difficulty' => $difficulty, 
					'questionCount' => $questionCount, 
					'language' => $language, 
				]);

				Cache::put($planetDifficultyCacheKey, $questions, Carbon::now()->addMinutes(5));
			}

			$this->updateGameProfileLocationInfo($profileId);
			
			return ResponseHelper::OutputJSON('success', '', [
					'planet' => [
						'id' => $planet->id,
						'name' => $planet->name,
						'description' => $planet->description,
						'question_count' => $planet->question_count,
						'badges' => json_decode($planet->badges_metrics),
					],
					'status' => [
						'star' => $userMap->star,	
						'difficulty' =>$difficulty,
						'top_score' => $userMap->top_score,
					],
					'planet_top_score'=>$topScoreResult,
						
	            	'questions' => $questions,
	            ]);

			} catch (Exception $ex) {

				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
					'source' => 'ApiGameController > request',
					'inputs' => Request::all(),
				])]);
				return ResponseHelper::OutputJSON('exception');
			}
	}

	public function requestV1_3($planetId , $language = 'en') {	

		$ON_CACHE = false;
		$CATCH_EX = false;
		
		try{
			$gameCode = Request::input('game_code');
			$difficulty = Request::input('difficulty');			
			$questionCount = Request::input('question_count');
			$profileId =  Request::input('game_code_profile_id');//middle

			LogHelper::LogGetQuestions($planetId, $gameCode);

			$planetCacheKey = join('.', ['ApiGameController@request', 'v1.3', 'planet', $planetId]);		
		
			// get planet info
			if ($ON_CACHE && Cache::has($planetCacheKey)) {
				$planet = Cache::get($planetCacheKey);

			}else{
				$planet = GamePlanet::where('enable', 1)
					->where('id', '>=', 100)
					->find($planetId);

				if(!$planet){
					return ResponseHelper::OutputJSON('fail', 'planet not found');
				}

				Cache::put($planetCacheKey, $planet, Carbon::now()->addMinutes(60));
			}
			
			$userMap = ZapZapQuestionHelper::GetUserMapPersonal($profileId, $planetId);

			//fethcing top scores
			$planetTopScore = ZapZapQuestionHelper::GameScreenPlanetTopScore($planetId);
			$topScoreResult = [];
			for($i=0; $i<count($planetTopScore); $i++){
				array_push($topScoreResult,  [
					'nickname1'=>$planetTopScore[$i]->nickname1,
					'nickname2'=>$planetTopScore[$i]->nickname2,
					'avatar'=>$planetTopScore[$i]->avatar,
					'score'=>$planetTopScore[$i]->score,
				]);
			}
			
			if(!in_array($difficulty, range(1, 5))){
				$difficulty = $userMap->star + 1;
				if($difficulty > 5){ $difficulty = 5; }
			}

			$level = $userMap->level;
			$planetDifficultyCacheKey = join('.', ['ApiGameController@request', 'v1.3', 'planet', $planetId, 'difficulty', $difficulty]);
			if ($ON_CACHE && Cache::has($planetDifficultyCacheKey)){
			 	$questions = Cache::get($planetDifficultyCacheKey);

			}else{
				
				$type = GameType::find($planet->game_type_id);

				$questions = AbstractGameQuestion::GetTypeQuestions($type->name, [
					'planetId' => $planetId, 
					'difficulty' => $difficulty, 
					'questionCount' => $questionCount, 
					'language' => $language, 
				]);

				Cache::put($planetDifficultyCacheKey, $questions, Carbon::now()->addMinutes(5));
			}

			$this->updateGameProfileLocationInfo($profileId);
			
			return ResponseHelper::OutputJSON('success', '', [
					'planet' => [
						'id' => $planet->id,
						'name' => $planet->name,
						'description' => $planet->description,
						'question_count' => $planet->question_count,
						'badges' => json_decode($planet->badges_metrics),
					],
					'status' => [
						'star' => $userMap->star,	
						'difficulty' =>$difficulty,
						'coin' => $planet->{'coin_star'.$difficulty},
						'top_score' => $userMap->top_score,
					],
					'planet_top_score'=>$topScoreResult,
						
	            	'questions' => $questions,
	            ]);

			} catch (Exception $ex) {
				if(!$CATCH_EX){
					throw $ex;
				}
				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
					'source' => 'ApiGameController > request',
					'inputs' => Request::all(),
				])]);
				return ResponseHelper::OutputJSON('exception');
			}
	}

	//SUBMIT RESULT
	
	public function resultV1_0($planetId) {

		try{
			
			$jsonGameResult = Request::input('game_result');
			$hash = Request::input('hash');
			$random = Request::input('random');

			$profileId = Request::input('game_code_profile_id');
			$userId = Request::input('user_id');
			$deviceId = Request::input('game_code_device_id');
			$gameCode = Request::input('game_code');
			$gameCodeType = Request::input('game_code_type');

			if(!$jsonGameResult || !$hash || !$random){
				return  [
					'status' => "fail",
					'message' => "missing parameter",
				]; 
			}

			$planet = GamePlanet::where('enable', 1)
				->where('id', '>=', 100)
				->find($planetId);

			if(!$planet){
				return ResponseHelper::OutputJSON('fail', 'planet not found');
			}

			$gameResult = json_decode($jsonGameResult, true);
			if(!isset($gameResult['score']) || !isset($gameResult['answers'])|| !isset($gameResult['status'])){ 
				return  [
					'status' => "fail",
					'message' => "invalid game result format",
				]; 
			}

			// check hash
			$hash1 = sha1($jsonGameResult.$random.Config::get('app.p02_key'));
			$hash2 = $hash;
			
			if($hash1 != $hash2){ 
				return  [
					'status' => "fail",
					'message' => "invalid hash",
					'hash1' => $hash1,
					'hash2' => $hash2,
					'key' => Config::get('app.p02_key'),
				]; 
			}

			$checkResult = GamePlay::where('hash', $hash1)->first();	
			if($checkResult){
				return  [
					'status' => "fail",
					'message' => "no double submit",
				]; 
			}

			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];

				$question = GameQuestion::find($inAnswer['question_id']);

				if(!$question){
					return ResponseHelper::OutputJSON('fail', 'invalid question id');
				}
			}

			LogHelper::LogPostResult($planetId , $jsonGameResult, $gameCode);//log post result

			$sql = "
				SELECT t.`name` 
					FROM `t0123_game_planet` p, `t0121_game_type` t
						WHERE p.`id` = :planet_id	
							AND p.`game_type_id` = t.`id`
								LIMIT 1;		
			";

			$result = DB::SELECT($sql, ['planet_id'=>$planetId]);

			$gameStatus = strtolower($gameResult['status']);
			switch($gameStatus){
				case 'false': $gameStatus = 'fail'; break;
				case 'true': $gameStatus = 'pass'; break;
			}

				
			$gamePlay = new GamePlay;
			$gamePlay->user_id = $userId;
			$gamePlay->profile_id = $profileId;
			$gamePlay->planet_id = $planetId;
			$gamePlay->target_type = $result[0]->name;
			$gamePlay->type = $gameCodeType;
			$gamePlay->score = $gameResult['score'];
			$gamePlay->device_id = $deviceId;
			$gamePlay->code = $gameCode;
			$gamePlay->hash = $hash1;
			$gamePlay->status = $gameStatus;

			if(isset($gameResult['badges'])){
				
				$gameResult['badges']['speed'] = ($gameResult['badges']['speed'] == 'True')?1:0;
				$gameResult['badges']['accuracy'] = ($gameResult['badges']['accuracy'] == 'True')?1:0;

				$gamePlay->badges_metrics = json_encode($gameResult['badges']);		
			}

			if(isset($gameResult['level'])){
				$gamePlay->level =  $gameResult['level'];
			}

			$gamePlay->save();

			GameCode::where('code', $gameCode)->update([
				'played' => '1'
			]);;

			switch($result[0]->name){
				case 'p00': $status = ZapZapQuestionHelper::SubmitResultP00($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p01': $status = ZapZapQuestionHelper::SubmitResultP01($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p02': $status = ZapZapQuestionHelper::SubmitResultP02($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p03': $status = ZapZapQuestionHelper::SubmitResultP03($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p06': $status = ZapZapQuestionHelper::SubmitResultP06($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p07': $status = ZapZapQuestionHelper::SubmitResultP07($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p08': $status = ZapZapQuestionHelper::SubmitResultP08($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p09': $status = ZapZapQuestionHelper::SubmitResultP09($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p10': $status = ZapZapQuestionHelper::SubmitResultP10($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p11': $status = ZapZapQuestionHelper::SubmitResultP11($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p12': $status = ZapZapQuestionHelper::SubmitResultP12($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p13': $status = ZapZapQuestionHelper::SubmitResultP13($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p14': $status = ZapZapQuestionHelper::SubmitResultP14($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p15': $status = ZapZapQuestionHelper::SubmitResultP15($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p16': $status = ZapZapQuestionHelper::SubmitResultP16($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p17': $status = ZapZapQuestionHelper::SubmitResultP17($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p18': $status = ZapZapQuestionHelper::SubmitResultP18($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p23': $status = ZapZapQuestionHelper::SubmitResultP23($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p32': $status = ZapZapQuestionHelper::SubmitResultP32($planetId, $gamePlay, $gameResult, $profileId); break;

				default: return ResponseHelper::OutputJSON('fail', 'submit answer error');
			}

			ZapZapQuestionHelper::UserMapV1_0($profileId, $planetId, $gamePlay, $gameResult); //update user_map

			$profile = GameProfile::find($profileId);
			$systemPlanet = GameSystemPlanet::where('planet_id' , $planetId)->first();

			ZapZapQuestionHelper::LeaderboardUpdate($profile, $systemPlanet, $gameResult);

			LogHelper::LogPostResult($planetId , $jsonGameResult, $gameCode);//log post result

		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiGameController > result', 
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}

		return ResponseHelper::OutputJSON('success');
	}

	public function resultV1_1($planetId) {

		try{
			$planet = GamePlanet::find($planetId);
			$jsonGameResult = Request::input('game_result');
			$hash = Request::input('hash');
			$random = Request::input('random');
			$playedTime = Request::input('played_time', 0);

			$profileId = Request::input('game_code_profile_id');
			$userId = Request::input('user_id');
			$deviceId = Request::input('game_code_device_id');
			$gameCode = Request::input('game_code');
			$gameCodeType = Request::input('game_code_type');

			if(!$jsonGameResult || !$hash || !$random ){
				return ResponseHelper::OutputJSON('fail', 'missing parameter');

			}

			$planet = GamePlanet::where('enable', 1)
				->where('id', '>=', 100)
				->find($planetId);

			if(!$planet){
				return ResponseHelper::OutputJSON('fail', 'planet not found');
			}

			$gameResult = json_decode($jsonGameResult, true);

			if(!isset($gameResult['score']) || !isset($gameResult['answers'])|| !isset($gameResult['status']) || !isset($gameResult['difficulty'])){ 

				return ResponseHelper::OutputJSON('fail', 'invalid game result format');

			}
			// check hash
			$hash1 = sha1($jsonGameResult.$random.Config::get('app.p02_key'));
			$hash2 = $hash;
			
			if($hash1 != $hash2){ 
				return  [
					'status' => "fail",
					'message' => "invalid hash",
					'hash1' => $hash1,
					'hash2' => $hash2,
					'key' => Config::get('app.p02_key'),
				]; 
			}

			$checkResult = GamePlay::where('hash', $hash1)->first();	

			if($checkResult){
				return ResponseHelper::OutputJSON('fail', 'no double submit');
			}

			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];

				$question = GameQuestion::find($inAnswer['question_id']);

				if(!$question){
					return ResponseHelper::OutputJSON('fail', 'invalid question id');
				}
			}

			$sql = "
				SELECT t.`name` 
					FROM `t0123_game_planet` p, `t0121_game_type` t
						WHERE p.`id` = :planet_id	
							AND p.`game_type_id` = t.`id`
								LIMIT 1;		
			";

			$result = DB::SELECT($sql, ['planet_id'=>$planetId]);

			$gameStatus = strtolower($gameResult['status']);
			switch($gameStatus){
				case 'false': $gameStatus = 'fail'; break;
				case 'true': $gameStatus = 'pass'; break;
			}
				
			$gamePlay = new GamePlay;
			$gamePlay->user_id = $userId;
			$gamePlay->profile_id = $profileId;
			$gamePlay->planet_id = $planetId;
			$gamePlay->target_type = $result[0]->name;
			$gamePlay->type = $gameCodeType;
			$gamePlay->score = $gameResult['score'];
			$gamePlay->device_id = $deviceId;
			$gamePlay->code = $gameCode;
			$gamePlay->hash = $hash1;
			$gamePlay->status = $gameStatus;
			$gamePlay->played_time = $playedTime;
			$gamePlay->difficulty = $gameResult['difficulty'];

			if(isset($gameResult['badges'])){
				
				$gameResult['badges']['speed'] = ($gameResult['badges']['speed'] == 'True')?1:0;
				$gameResult['badges']['accuracy'] = ($gameResult['badges']['accuracy'] == 'True')?1:0;

				$gamePlay->badges_metrics = json_encode($gameResult['badges']);		
			}
			if(isset($gameResult['level'])){
				$gamePlay->level =  $gameResult['level'];
			}
			$gamePlay->save();

			GameCode::where('code', $gameCode)->update([
				'played' => '1'
			]);;

			switch($result[0]->name){
				case 'p00': $status = ZapZapQuestionHelper::SubmitResultP00($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p01': $status = ZapZapQuestionHelper::SubmitResultP01($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p02': $status = ZapZapQuestionHelper::SubmitResultP02($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p03': $status = ZapZapQuestionHelper::SubmitResultP03($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p06': $status = ZapZapQuestionHelper::SubmitResultP06($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p07': $status = ZapZapQuestionHelper::SubmitResultP07($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p08': $status = ZapZapQuestionHelper::SubmitResultP08($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p09': $status = ZapZapQuestionHelper::SubmitResultP09($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p10': $status = ZapZapQuestionHelper::SubmitResultP10($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p11': $status = ZapZapQuestionHelper::SubmitResultP11($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p12': $status = ZapZapQuestionHelper::SubmitResultP12($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p13': $status = ZapZapQuestionHelper::SubmitResultP13($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p14': $status = ZapZapQuestionHelper::SubmitResultP14($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p15': $status = ZapZapQuestionHelper::SubmitResultP15($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p16': $status = ZapZapQuestionHelper::SubmitResultP16($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p17': $status = ZapZapQuestionHelper::SubmitResultP17($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p18': $status = ZapZapQuestionHelper::SubmitResultP18($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p19': $status = ZapZapQuestionHelper::SubmitResultP19($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p20': $status = ZapZapQuestionHelper::SubmitResultP20($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p21': $status = ZapZapQuestionHelper::SubmitResultP21($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p22': $status = ZapZapQuestionHelper::SubmitResultP22($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p23': $status = ZapZapQuestionHelper::SubmitResultP23($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p24': $status = ZapZapQuestionHelper::SubmitResultP24($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p25': $status = ZapZapQuestionHelper::SubmitResultP25($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p27': $status = ZapZapQuestionHelper::SubmitResultP27($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p28': $status = ZapZapQuestionHelper::SubmitResultP28($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p29': $status = ZapZapQuestionHelper::SubmitResultP29($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p30': $status = ZapZapQuestionHelper::SubmitResultP30($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p31': $status = ZapZapQuestionHelper::SubmitResultP31($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p32': $status = ZapZapQuestionHelper::SubmitResultP32($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p33': $status = ZapZapQuestionHelper::SubmitResultP33($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p34': $status = ZapZapQuestionHelper::SubmitResultP34($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p35': $status = ZapZapQuestionHelper::SubmitResultP35($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p36': $status = ZapZapQuestionHelper::SubmitResultP36($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p37': $status = ZapZapQuestionHelper::SubmitResultP37($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p38': $status = ZapZapQuestionHelper::SubmitResultP38($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p39': $status = ZapZapQuestionHelper::SubmitResultP39($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p40': $status = ZapZapQuestionHelper::SubmitResultP40($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p41': $status = ZapZapQuestionHelper::SubmitResultP41($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p42': $status = ZapZapQuestionHelper::SubmitResultP42($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p43': $status = ZapZapQuestionHelper::SubmitResultP43($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p44': $status = ZapZapQuestionHelper::SubmitResultP44($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p45': $status = ZapZapQuestionHelper::SubmitResultP45($planetId, $gamePlay, $gameResult, $profileId); break;
				case 'p46': $status = ZapZapQuestionHelper::SubmitResultP46($planetId, $gamePlay, $gameResult, $profileId); break;
				

				default: return ResponseHelper::OutputJSON('fail', 'submit answer error');
			}

			ZapZapQuestionHelper::UserMapV1_1($profileId, $planetId, $gamePlay, $gameResult, $gameResult['difficulty']); //update user_map
			ZapZapQuestionHelper::LastSession($userId , $profileId, $gameResult, $playedTime);

			$profile = GameProfile::find($profileId);
			$systemPlanet = GameSystemPlanet::where('planet_id' , $planetId)->first();

			ZapZapQuestionHelper::LeaderboardUpdate($profile,$systemPlanet,$gameResult);
			LogHelper::LogPostResult($planetId , $jsonGameResult, $gameCode);//log post result
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiGameController > result', 
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}

		return ResponseHelper::OutputJSON('success');
	}

	public function resultV1_3($planetId) {

		try{
			$jsonGameResult = Request::input('game_result');
			$hash = Request::input('hash');
			$random = Request::input('random');
			$playedTime = Request::input('played_time', 0);

			$profileId = Request::input('game_code_profile_id');
			$userId = Request::input('user_id');
			$deviceId = Request::input('game_code_device_id');
			$gameCode = Request::input('game_code');
			$gameCodeType = Request::input('game_code_type');

			$planet = GamePlanet::where('enable', 1)
					->where('id', '>=', 100)
					->find($planetId);

			if(!$planet){
				return ResponseHelper::OutputJSON('fail', 'planet not found');
			}

			if(!$jsonGameResult || !$hash || !$random ){
				return ResponseHelper::OutputJSON('fail', 'missing parameter');
			}

			$gameResult = json_decode($jsonGameResult, true);

			if(!isset($gameResult['score']) || !isset($gameResult['answers'])|| !isset($gameResult['status']) || !isset($gameResult['difficulty'])){ 
				return ResponseHelper::OutputJSON('fail', 'invalid game result format');
			}

			// check hash
			$hash1 = sha1($jsonGameResult.$random.Config::get('app.p02_key'));
			$hash2 = $hash;
			
			if($hash1 != $hash2){ 
				return  [
					'status' => "fail",
					'message' => "invalid hash",
					'hash1' => $hash1,
					'hash2' => $hash2,
					'key' => Config::get('app.p02_key'),
				]; 
			}

			$checkResult = GamePlay::where('hash', $hash1)->first();	

			if($checkResult){
				return ResponseHelper::OutputJSON('fail', 'no double submit');
			}

			//validate question ids
			foreach ($gameResult['answers'] as $answer){
				array_push($questionIds, $answer['question_id']); 
			}

			$sql = "
				SELECT COUNT(*) AS `count`
					FROM `t0200_game_question`
						WHERE `id` IN(".join(',', $questionIds).")	
			";
			$result = DB::SELECT($sql);

			if($result[0]->count !== count($questionIds)){
				return ResponseHelper::OutputJSON('fail', 'invalid question id');
			}
			//validate question ids =end

			$sql = "
				SELECT t.`name` 
					FROM `t0123_game_planet` p, `t0121_game_type` t
						WHERE p.`id` = :planet_id	
							AND p.`game_type_id` = t.`id`
								LIMIT 1;		
			";

			$result = DB::SELECT($sql, ['planet_id'=>$planetId]);
			$typeName = $result[0]->name;

			$gamePlay = new GamePlay;

			$gameStatus = strtolower($gameResult['status']);
			switch($gameStatus){
				case 'false': $gameStatus = 'fail'; break;
				case 'true': $gameStatus = 'pass'; break;
			}

			if($gameStatus === 'pass'){
				$gamePlay->coin = $planet->{'coin_star'.$gameResult['difficulty']};
			}

			$gamePlay->user_id = $userId;
			$gamePlay->profile_id = $profileId;
			$gamePlay->planet_id = $planetId;
			$gamePlay->target_type = $typeName;
			$gamePlay->type = $gameCodeType;
			$gamePlay->score = $gameResult['score'];
			$gamePlay->device_id = $deviceId;
			$gamePlay->code = $gameCode;
			$gamePlay->hash = $hash1;
			$gamePlay->status = $gameStatus;
			$gamePlay->played_time = $playedTime;
			$gamePlay->difficulty = $gameResult['difficulty'];

			if(isset($gameResult['badges'])){
				$gameResult['badges']['speed'] = ($gameResult['badges']['speed'] == 'True')?1:0;
				$gameResult['badges']['accuracy'] = ($gameResult['badges']['accuracy'] == 'True')?1:0;

				$gamePlay->badges_metrics = json_encode($gameResult['badges']);		
			}
			if(isset($gameResult['level'])){
				$gamePlay->level =  $gameResult['level'];
			}

			$gamePlay->save();

			GameCode::where('code', $gameCode)->update([
				'played' => '1'
			]);;


			AbstractGameResult::SubmitTypeResult($typeName, [
				'planetId' => $planetId, 
				'gamePlay' => $gamePlay, 
				'gameResult' => $gameResult, 
				'profileId' => $profileId, 
			]);


			$profile = GameProfile::find($profileId);
			$profile->coin = $profile->coin + $planet->{'coin_star'.$gameResult['difficulty']};
			$profile->save();

			ZapZapQuestionHelper::UserMapV1_1($profileId, $planetId, $gamePlay, $gameResult, $gameResult['difficulty']); //update user_map
			ZapZapQuestionHelper::LastSession($userId , $profileId, $gameResult, $playedTime);

			$profile = GameProfile::find($profileId);
			$systemPlanet = GameSystemPlanet::where('planet_id' , $planetId)->first();

			ZapZapQuestionHelper::LeaderboardUpdate($profile,$systemPlanet,$gameResult);
			LogHelper::LogPostResult($planetId , $jsonGameResult, $gameCode);//log post result
			
			$gameCoinTransaction = new GameCoinTransaction;
			$gameCoinTransaction->profile_id = $profileId;
			$gameCoinTransaction->description = join('.', ['game.pass' , $planetId ,$gameResult['difficulty']]);
			$gameCoinTransaction->coin_amount = $planet->{'coin_star'.$gameResult['difficulty']};
			$gameCoinTransaction->coin_balance = $profile->coin;
			$gameCoinTransaction->save();
			
			} catch (Exception $ex) {

				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
					'source' => 'ApiGameController > result', 
					'inputs' => Request::all(),
				])]);
				return ResponseHelper::OutputJSON('exception');
			}

			return ResponseHelper::OutputJSON('success');
	}

	public function getUserMapV1_0(){
		$profileId = Request::input('game_code_profile_id');
		$userId = Request::input('user_id');
		$deviceId = Request::input('game_code_device_id');
		$gameCode = Request::input('game_code');
		

		try{
			$result = ZapZapQuestionHelper::GetUserMapV1_0($profileId);
			$totalStar = UserMap::where('profile_id', $profileId)->sum('star');

			$systems = [];		
			$prevSystemId = 0;

			$prevPlanetStar = 5;
			$prevPlanetEnable = true;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->system_id != $prevSystemId){
					array_push($systems, [
						'system_id' => $r->system_id,
						'name' => $r->system_name,
						'planets' => []
					]);
				}

				$planetEnable = ($prevPlanetStar >= 3) && $prevPlanetEnable;
				$prevPlanetEnable = $planetEnable;
		

				array_push($systems[count($systems)-1]['planets'], [
					'planet_id' => $r->planet_id,
					'name' => $r->planet_name,
					'description' => $r->description,
					'star' => $r->star,
					'enable' => ($planetEnable)?1:0,

				]);				

				$prevPlanetStar = $r->star;
				$prevSystemId = $r->system_id;
			}

	
			return ResponseHelper::OutputJSON('success', '' , $systems );
		
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiGameController > getUserMap',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function getUserMapV1_1(){
		//user type : 0 = no pay money , 1 = paid money, 2 = annonymous
		$profileId = Request::input('game_code_profile_id');
		$userId = Request::input('user_id');
		$deviceId = Request::input('game_code_device_id');
		$gameCode = Request::input('game_code');

		try{
			$result = ZapZapQuestionHelper::GetUserMapV1_1($profileId);

			$totalStar = UserMap::where('profile_id', $profileId)->sum('star');

			$profile = GameProfile::find($profileId);

			$profile->nickName1;
			$profile->nickName2;
			$profile->avatar;

			$userType = 2;

			if($userId){
				$user = User::find($userId);
				
				$userType = $user->paid;
			}

			$systems = [];		
			$prevSystemId = 0;
			$prevSubsytemId = 0;
			$prevPlanetStar = 5;
			$prevPlanetEnable = true;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->system_id != $prevSystemId){
					array_push($systems, [
						'system_id' => $r->system_id,
						'name' => $r->system_name,
						'subsystem' => [
							[
								'subsystem_id' => '1',
								'subsystem_name' => 'Basics',
								'planet' => []
							],
							
						]
					]);
				}


				if($r->subsystem_id != $prevSubsytemId){
					array_push($systems[count($systems)-1]['subsystem'], [
						'subsystem_id' => $r->subsystem_id,
						'subsystem_name' => $r->subsystem_name,
						'planet' => []
					]);				
				}

				$planetEnable = ($prevPlanetStar >= 3) && $prevPlanetEnable;
				$prevPlanetEnable = $planetEnable;

				array_push($systems[count($systems)-1]['subsystem'][count($systems[count($systems)-1]['subsystem'])-1]['planet'], [
					'planet_id' => $r->planet_id,
					'name' => $r->planet_name,
					'description' => $r->description,
					'star' => $r->star,
					'enable' => ($planetEnable)?1:0,

				]);				
				$prevPlanetStar = $r->star;
				$prevSystemId = $r->system_id;
				$prevSubsytemId = $r->subsystem_id;
			}

			return ResponseHelper::OutputJSON('success', '' , [
					'profile' => [
						'first_name' => $profile->first_name,
						'last_name' => $profile->last_name,
						'grade' =>$profile->grade,
						'total_star' => $totalStar,
						'user_type' => $userType,
						'game_code' => $gameCode,
						'nick_name1' =>$profile->nickName1->name,
						'nick_name2' =>$profile->nickName2->name,
						'avatar' => $profile->avatar,
						] ,
					'system_planet' => $systems
					 ]);
		
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiGameController > getUserMap',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function getUserMapV1_2(){
		//user type : 0 = no pay money , 1 = paid money, 2 = annonymous
		$profileId = Request::input('game_code_profile_id');
		$userId = Request::input('user_id');
		$deviceId = Request::input('game_code_device_id');
		$gameCode = Request::input('game_code');

		try{
			$result = ZapZapQuestionHelper::GetUserMapV1_2($profileId);

			$totalStar = UserMap::where('profile_id', $profileId)->sum('star');

			$profile = GameProfile::find($profileId);
			
			$profile->nickName1;
			$profile->nickName2;
			$profile->avatar;

			$userEnablePlanet = 0;

			$userType = 2;
			if($profile->user_id){
				$userType = 0;

				if($profile->expired_at > date("Y-m-d H:i:s") || GameClass::find($profile->class_id)->expired_at > date("Y-m-d H:i:s")){
					$userType = 1;
				}
			}

			$systems = [];		
			$prevSystemId = 0;
			$prevSubsytemId = 0;
			$prevPlanetStar = 5;
			$prevPlanetEnable = true;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->system_id != $prevSystemId){
					array_push($systems, [
						'system_id' => $r->system_id,
						'name' => $r->system_name,
						'subsystem' => [
							[
								'subsystem_id' => '1',
								'subsystem_name' => 'Basics',
								'planet' => []
							],
							
						]
					]);
					$prevSubsytemId = 0;
				}


				if($r->subsystem_id != $prevSubsytemId){
					array_push($systems[count($systems)-1]['subsystem'], [
						'subsystem_id' => $r->subsystem_id,
						'subsystem_name' => $r->subsystem_name,
						'planet' => []
					]);				
				}

				// need change the paid to date and 
				$enable = 1;

				if($r->enable){
					if($userType == 2 && $r->user_type != 2 || $userType == 0 && $r->user_type == 1){
						$enable = 0;
					}
				}else{
					$enable = 0;
				}


				array_push($systems[count($systems)-1]['subsystem'][count($systems[count($systems)-1]['subsystem'])-1]['planet'], [
					'planet_id' => $r->planet_id,
					'name' => $r->planet_name,
					'description' => $r->description,
					'star' => $r->star,
					'enable' => $enable,

				]);				
				$prevPlanetStar = $r->star;
				$prevSystemId = $r->system_id;
				$prevSubsytemId = $r->subsystem_id;
			}

			return ResponseHelper::OutputJSON('success', '' , [
					'profile' => [
						'first_name' => $profile->first_name,
						'last_name' => $profile->last_name,
						'grade' =>$profile->grade,
						'total_star' => $totalStar,
						'user_type' => $userType,
						'game_code' => $gameCode,
						'nick_name1' =>$profile->nickName1->name,
						'nick_name2' =>$profile->nickName2->name,
						'avatar' => $profile->avatar,
						] ,
					'system_planet' => $systems
					 ]);
		
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiGameController > getUserMap',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function getUserMapV1_3(){
		//user type : 0 = no pay money , 1 = paid money, 2 = annonymous
		$profileId = Request::input('game_code_profile_id');
		$userId = Request::input('user_id');
		$deviceId = Request::input('game_code_device_id');
		$gameCode = Request::input('game_code');

		try{
			$result = ZapZapQuestionHelper::GetUserMapV1_2($profileId);

			$totalStar = UserMap::where('profile_id', $profileId)->sum('star');

			$profile = GameProfile::find($profileId);
			
			$profile->nickName1;
			$profile->nickName2;
			$profile->avatar;

			$userEnablePlanet = 0;

			if($profile->user_id){
				$userType = 0;

				if($profile->expired_at > date("Y-m-d H:i:s") || GameClass::find($profile->class_id)->expired_at > date("Y-m-d H:i:s")){
					$userType = 1;
				}
			}

			$systems = [];		
			$prevSystemId = 0;
			$prevSubsytemId = 0;
			$prevPlanetEnable = true;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->system_id != $prevSystemId){
					array_push($systems, [
						'system_id' => $r->system_id,
						'name' => $r->system_name,
						'subsystem' => [
							[
								'subsystem_id' => '1',
								'subsystem_name' => 'Basics',
								'planet' => []
							],
							
						]
					]);
					$prevSubsytemId = 0;
				}


				if($r->subsystem_id != $prevSubsytemId){
					array_push($systems[count($systems)-1]['subsystem'], [
						'subsystem_id' => $r->subsystem_id,
						'subsystem_name' => $r->subsystem_name,
						'planet' => []
					]);				
				}

				// need change the paid to date and 
				$enable = 1;

				if($r->enable){
					if($userType == 2 && $r->user_type != 2 || $userType == 0 && $r->user_type == 1){
						$enable = 0;
					}
				}else{
					$enable = 0;
				}

				array_push($systems[count($systems)-1]['subsystem'][count($systems[count($systems)-1]['subsystem'])-1]['planet'], [
					'planet_id' => $r->planet_id,
					'name' => $r->planet_name,
					'description' => $r->description,
					'star' => $r->star,
					'enable' => $enable,

				]);				
				$prevSystemId = $r->system_id;
				$prevSubsytemId = $r->subsystem_id;
			}

			return ResponseHelper::OutputJSON('success', '' , [
					'profile' => [
						'first_name' => $profile->first_name,
						'last_name' => $profile->last_name,
						'grade' =>$profile->grade,
						'total_star' => $totalStar,
						'user_type' => $userType,
						'game_code' => $gameCode,
						'nick_name1' =>$profile->nickName1->name,
						'nick_name2' =>$profile->nickName2->name,
						'avatar' => $profile->avatar,
						'coin' => $profile->coin,
						] ,
					'system_planet' => $systems
					 ]);
		
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiGameController > getUserMap',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function clearLeaderBoard(){
		try{
			$sql = "
					DELETE FROM `t0603_leaderboard_planet` WHERE  `rank` >100;
			";
			DB::SELECT($sql);
			
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiGameController > clearLeaderBoard',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function leaderBoardPlanet($version ,$planetId){
		try{

			$leaderBoardPlanet = LeaderBoardPlanet::where('planet_id', $planetId)->where('rank' ,'<' ,101)->orderBy('rank')->get()->toArray();

			if(!$leaderBoardPlanet){
				return ResponseHelper::OutputJSON('fail', 'planet not found');
			}

			return ResponseHelper::OutputJSON('success', '' , ['Leaderboard_planet'=>$leaderBoardPlanet]);
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiGameController > leaderBoardPlanet',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function createPackage(){

		$planet = GamePlanet::where('available', 1)->get();

		$set = [
			[1, 5], //0
			[2, 5], //1
			[3, 5], //2
			[4, 5], //3
			[5, 5], //4
		];
		for($k=0; $k<count($planet); $k++){
			$p = $planet[$k];

			for($i=0; $i<5; $i++){
				$difficulty = $set[$i][0];

				$star = $difficulty;
				if($difficulty != 5){ 
					$star = $star-1; 
				}

				for($j=0; $j<$set[$i][1]; $j++){
					switch($p->game_type_id){
						case '1':$questions = ZapZapQuestionHelper::GetQuestionP01($p->id,$difficulty,$p->question_count,'en'); break;
						case '2':$questions = ZapZapQuestionHelper::GetQuestionP02($p->id,$difficulty,$p->question_count); break;
						case '3':$questions = ZapZapQuestionHelper::GetQuestionP03($p->id,$difficulty,$p->question_count); break;
						case '6':$questions = ZapZapQuestionHelper::GetQuestionP06($p->id,$difficulty,$p->question_count); break;
						case '7':$questions = ZapZapQuestionHelper::GetQuestionP07($p->id,$difficulty,$p->question_count); break;
						case '8':$questions = ZapZapQuestionHelper::GetQuestionP08($p->id,$difficulty,$p->question_count); break;
						case '9':$questions = ZapZapQuestionHelper::GetQuestionP09($p->id,$difficulty,$p->question_count); break;
						case '10':$questions = ZapZapQuestionHelper::GetQuestionP10($p->id,$difficulty,$p->question_count); break;
						case '11':$questions = ZapZapQuestionHelper::GetQuestionP11($p->id,$difficulty,$p->question_count); break;
						case '12':$questions = ZapZapQuestionHelper::GetQuestionP12($p->id,$difficulty,$p->question_count); break;
						case '13':$questions = ZapZapQuestionHelper::GetQuestionP13($p->id,$difficulty,$p->question_count); break;
						case '14':$questions = ZapZapQuestionHelper::GetQuestionP14($p->id,$difficulty,$p->question_count); break;
						case '15':$questions = ZapZapQuestionHelper::GetQuestionP15($p->id,$difficulty,$p->question_count); break;
						case '16':$questions = ZapZapQuestionHelper::GetQuestionP16($p->id,$difficulty,$p->question_count); break;
						case '17':$questions = ZapZapQuestionHelper::GetQuestionP17($p->id,$difficulty,$p->question_count); break;
						case '18':$questions = ZapZapQuestionHelper::GetQuestionP18($p->id,$difficulty,$p->question_count); break;
						case '19':$questions = ZapZapQuestionHelper::GetQuestionP19($p->id,$difficulty,$p->question_count); break;
						case '20':$questions = ZapZapQuestionHelper::GetQuestionP20($p->id,$difficulty,$p->question_count); break;
						case '21':$questions = ZapZapQuestionHelper::GetQuestionP21($p->id,$difficulty,$p->question_count); break;
						case '22':$questions = ZapZapQuestionHelper::GetQuestionP22($p->id,$difficulty,$p->question_count); break;
						case '23':$questions = ZapZapQuestionHelper::GetQuestionP23($p->id,$difficulty,$p->question_count); break;
						case '24':$questions = ZapZapQuestionHelper::GetQuestionP24($p->id,$difficulty,$p->question_count); break;
						case '25':$questions = ZapZapQuestionHelper::GetQuestionP25($p->id,$difficulty,$p->question_count); break;
						case '26':$questions = ZapZapQuestionHelper::GetQuestionP26($p->id,$difficulty,$p->question_count); break;
						case '27':$questions = ZapZapQuestionHelper::GetQuestionP27($p->id,$difficulty,$p->question_count); break;
						case '28':$questions = ZapZapQuestionHelper::GetQuestionP28($p->id,$difficulty,$p->question_count); break;
						case '29':$questions = ZapZapQuestionHelper::GetQuestionP29($p->id,$difficulty,$p->question_count); break;
						case '30':$questions = ZapZapQuestionHelper::GetQuestionP30($p->id,$difficulty,$p->question_count); break;
						case '31':$questions = ZapZapQuestionHelper::GetQuestionP31($p->id,$difficulty,$p->question_count); break;
						case '32':$questions = ZapZapQuestionHelper::GetQuestionP32($p->id,$difficulty,$p->question_count); break;
						case '33':$questions = ZapZapQuestionHelper::GetQuestionP33($p->id,$difficulty,$p->question_count); break;
						case '34':$questions = ZapZapQuestionHelper::GetQuestionP34($p->id,$difficulty,$p->question_count); break;
						case '35':$questions = ZapZapQuestionHelper::GetQuestionP35($p->id,$difficulty,$p->question_count); break;
						case '36':$questions = ZapZapQuestionHelper::GetQuestionP36($p->id,$difficulty,$p->question_count); break;
						case '37':$questions = ZapZapQuestionHelper::GetQuestionP37($p->id,$difficulty,$p->question_count); break;
						case '38':$questions = ZapZapQuestionHelper::GetQuestionP38($p->id,$difficulty,$p->question_count); break;
						case '39':$questions = ZapZapQuestionHelper::GetQuestionP39($p->id,$difficulty,$p->question_count); break;
						case '40':$questions = ZapZapQuestionHelper::GetQuestionP40($p->id,$difficulty,$p->question_count); break;
						case '41':$questions = ZapZapQuestionHelper::GetQuestionP41($p->id,$difficulty,$p->question_count); break;
						case '42':$questions = ZapZapQuestionHelper::GetQuestionP42($p->id,$difficulty,$p->question_count); break;
						case '43':$questions = ZapZapQuestionHelper::GetQuestionP43($p->id,$difficulty,$p->question_count); break;
						case '44':$questions = ZapZapQuestionHelper::GetQuestionP44($p->id,$difficulty,$p->question_count); break;
						case '45':$questions = ZapZapQuestionHelper::GetQuestionP45($p->id,$difficulty,$p->question_count); break;
						case '46':$questions = ZapZapQuestionHelper::GetQuestionP46($p->id,$difficulty,$p->question_count); break;
						case '47':$questions = ZapZapQuestionHelper::GetQuestionP47($p->id,$difficulty,$p->question_count); break;
						case '48':$questions = ZapZapQuestionHelper::GetQuestionP48($p->id,$difficulty,$p->question_count); break;
						case '49':$questions = ZapZapQuestionHelper::GetQuestionP49($p->id,$difficulty,$p->question_count); break;
						default: continue;
					}	
					
					$file = [
						'status' => "success",
						'data' => [
							'planet' => [
								'id' => $p->id,
								'name' => $p->name,
								'description' => $p->description,
								'question_count' => $p->question_count,
								'badges' => json_decode($p->badges_metrics),
							],
							'status' => [
								'star' => $star,	
								'difficulty' => $difficulty,
								'top_score' => 0,
							],
							'planet_top_score'=> [],
			            	'questions' => $questions,
			            ],
		           	];

		           	$dir1 = 'package/download/'.$p->id;
		           	$dir2 = 'package/download/'.$p->id.'/'.$difficulty;
		           
		           	if (!is_dir($dir1)){
						mkdir($dir1); //create the directory
						chmod($dir1, 0777); //make it writable
					}

					if (!is_dir($dir2)){
						mkdir($dir2); //create the directory
						chmod($dir2, 0777); //make it writable
					}

			        file_put_contents($dir2.'/'.$j.'.json', json_encode($file));
					}
			}
		}
     	$files = glob(public_path().'/package/download/');
		$try = Zipper::make(public_path().'/package/application.zip')->add($files);

		$file= public_path(). "/package/application.zip";
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-type: application/zip");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize(public_path().'/package/application.zip'));
		readfile(public_path().'/package/application.zip');
	}

	public function checkGameCode(){
		$gameCode = Request::input('game_code');
		$deviceId = Request::input('device_id');

		$checkGameCode = GameCode::where('code' , $gameCode)->first();

		if(!$checkGameCode){
			$idCounter = IdCounter::find(1);
			$gameCodeSeed = $idCounter->game_code_seed;
			$idCounter->game_code_seed = $gameCodeSeed + 1;
			$idCounter->save();

			$gamePro = new GameProfile;
			$gamePro->user_id = 0;
			$gamePro->first_name = "Player 1";
			$gamePro->last_name = "Player 1";
			$gamePro->nickname1 = 999;
			$gamePro->nickname2 = 999;
			$gamePro->avatar_id = 999;
			$gamePro->save();

			$code = new GameCode;
			$code->profile_id = $gamePro->id;
			$code->type = 'anonymous';
			$code->code = ZapZapHelper::GenerateGameCode($gameCodeSeed);
			$code->seed = $gameCodeSeed;
			$code->device_id = $deviceId;
			$code->save();

			return ResponseHelper::OutputJSON('success', '', [] , [] , [] , 'change_game_code', ['game_code' => $code->code]);
		}

		return ResponseHelper::OutputJSON('success');
	}

	public function checkGameCodeV1_1(){
		$gameCode = Request::input('game_code');
		$deviceId = Request::input('device_id');

		if(!$gameCode){
			return ResponseHelper::OutputJSON('fail', 'missing parameter' );
		}

		$sql = "
			SELECT *
				FROM `t0113_game_code`
					WHERE `code` = :game_code
		";

		$result = DB::SELECT($sql, ['game_code' => $gameCode]);
	
		if(!$result){
			return ResponseHelper::OutputJSON('fail', 'game code not found' );
		} 

		if($result[0]->deleted_at){
			return ResponseHelper::OutputJSON('fail', 'game code deleted' );
		}

		return ResponseHelper::OutputJSON('success', '' , ['account_type' => $result[0]->type] );
	}

	public function offlinePost(){
		$result = Request::input('result');

		$profileId = Request::input('game_code_profile_id');
		$userId = Request::input('user_id');
		$deviceId = Request::input('game_code_device_id');
		$gameCode = Request::input('game_code');
		$gameCodeType = Request::input('game_code_type');
		// $results = array($result);
		$results = json_decode( ($result), true );

		try{

			for($i=0; $i<=(count($results) - 1); $i++){
				$r = $results[$i];

				$gameResult = $r['game_result'];

				$sgameResult = json_decode(($gameResult), true);
				$planetId = $r['planet_id'];

				$planet = GamePlanet::find($planetId);

				if(!$planet){
					return ResponseHelper::OutputJSON('fail', 'planet not found');
				}

				if(!$planet->enable){
					return ResponseHelper::OutputJSON('fail', 'planet is not enable');
				}

				if(!$gameResult || !$r['hash'] || !$r['random'] || !$r['played_time']){
					return ResponseHelper::OutputJSON('fail', 'missing parameter');
				}

				if(!isset($sgameResult['score']) || !isset($sgameResult['answers'])|| !isset($sgameResult['status']) || !isset($sgameResult['difficulty'])){ 
					return ResponseHelper::OutputJSON('fail', 'invalid game result format');
				}
				// check hash

				$hash1 = sha1($gameResult.$r['random'].Config::get('app.p02_key'));
				$hash2 = $r['hash'];
			
				if($hash1 != $hash2){ 
					return  [
						'status' => "fail",
						'message' => "invalid hash",
						'hash1' => $hash1,
						'hash2' => $hash2,
						'key' => Config::get('app.p02_key'),
					]; 
				}

				$checkResult = GamePlay::where('hash', $hash1)->first();	
				if($checkResult){
					return ResponseHelper::OutputJSON('fail', 'no double submit '.$r['planet_id']);
				}

				for($j=0; $j<count($sgameResult['answers']); $j++){
					$inAnswer = $sgameResult['answers'][$j];

					$question = GameQuestion::find($inAnswer['question_id']);

					if(!$question){
						return ResponseHelper::OutputJSON('fail', 'invalid question id');
					}
				}

				$sql = "
					SELECT `name` 
						FROM `t0121_game_type`
							WHERE `id` IN(
								SELECT `game_type_id` 
									FROM `t0123_game_planet`
										WHERE `id` = :planet_id
							)
								LIMIT 1;
				";

				$result = DB::SELECT($sql, ['planet_id'=>$planetId]);

				$gameStatus = $sgameResult['status'];
				if($gameStatus == 'False'){
					$gameStatus = 'fail';
				}elseif($gameStatus == 'True'){
					$gameStatus = 'pass';
				}
					
				$gamePlay = new GamePlay;
				$gamePlay->user_id = $userId;
				$gamePlay->profile_id = $profileId;
				$gamePlay->planet_id = $planetId;
				$gamePlay->target_type = $result[0]->name;
				$gamePlay->type = $gameCodeType;
				$gamePlay->score = $sgameResult['score'];
				$gamePlay->device_id = $deviceId;
				$gamePlay->code = $gameCode;
				$gamePlay->hash = $hash1;
				$gamePlay->status = $gameStatus;
				$gamePlay->played_time = $r['played_time'];

				if(isset($sgameResult['badges'])){
					
					if($sgameResult['badges']['speed'] == 'True'){
						$sgameResult['badges']['speed'] = '1';
					}elseif($sgameResult['badges']['speed'] == 'False'){
						$sgameResult['badges']['speed'] = '0';
					}

					if($sgameResult['badges']['accuracy'] == 'True'){
						$sgameResult['badges']['accuracy'] = '1';
					}elseif($sgameResult['badges']['accuracy'] == 'False'){
						$sgameResult['badges']['accuracy'] = '0';
					}

					$gamePlay->badges_metrics = json_encode($sgameResult['badges']);		
				}

				if(isset($sgameResult['level'])){
					$gamePlay->level =  $sgameResult['level'];
				}
				$gamePlay->save();

				$gameCodePlayed = GameCode::where('code', $gameCode)->update([
						'played' => '1'
						]);;
				switch($result[0]->name){
					case 'p00': $status = ZapZapQuestionHelper::SubmitResultP00($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p01': $status = ZapZapQuestionHelper::SubmitResultP01($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p02': $status = ZapZapQuestionHelper::SubmitResultP02($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p03': $status = ZapZapQuestionHelper::SubmitResultP03($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p06': $status = ZapZapQuestionHelper::SubmitResultP06($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p07': $status = ZapZapQuestionHelper::SubmitResultP07($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p08': $status = ZapZapQuestionHelper::SubmitResultP08($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p09': $status = ZapZapQuestionHelper::SubmitResultP09($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p10': $status = ZapZapQuestionHelper::SubmitResultP10($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p11': $status = ZapZapQuestionHelper::SubmitResultP11($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p12': $status = ZapZapQuestionHelper::SubmitResultP12($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p13': $status = ZapZapQuestionHelper::SubmitResultP13($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p14': $status = ZapZapQuestionHelper::SubmitResultP14($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p15': $status = ZapZapQuestionHelper::SubmitResultP15($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p16': $status = ZapZapQuestionHelper::SubmitResultP16($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p17': $status = ZapZapQuestionHelper::SubmitResultP17($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p18': $status = ZapZapQuestionHelper::SubmitResultP18($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p19': $status = ZapZapQuestionHelper::SubmitResultP19($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p20': $status = ZapZapQuestionHelper::SubmitResultP20($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p21': $status = ZapZapQuestionHelper::SubmitResultP21($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p23': $status = ZapZapQuestionHelper::SubmitResultP23($planetId,$gamePlay,$sgameResult,$profileId); break;
					case 'p32': $status = ZapZapQuestionHelper::SubmitResultP32($planetId,$gamePlay,$sgameResult,$profileId); break;

					default: return ResponseHelper::OutputJSON('fail', 'submit answer error');
				}

				ZapZapQuestionHelper::UserMapV1_1($profileId, $planetId, $gamePlay, $gameResult, $sgameResult['difficulty']); //update user_map

				$profile = GameProfile::find($profileId);
				$systemPlanet = GameSystemPlanet::where('planet_id' , $planetId)->first();

				ZapZapQuestionHelper::LeaderboardUpdate($profile,$systemPlanet,$gameResult);
				LogHelper::LogPostResult($planetId , $gameResult, $gameCode);//log post result
			}

		} catch (Exception $ex) {

				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
					'source' => 'ApiGameController > result', 
					'inputs' => Request::all(),
				])]);
				return ResponseHelper::OutputJSON('exception');
		}

		return ResponseHelper::OutputJSON('success');
	}

	public function getGameCodeInfo(){
		$code = Request::input('game_code');

		if(!$code){
			return ResponseHelper::OutputJSON('fail' , 'missing parameter');
		}

		$gameCode = GameCode::where('code' , $code)->first();

		if(!$gameCode){
			return ResponseHelper::OutputJSON('fail' , 'game code not found');
		}

		$totalStar = UserMap::where('profile_id', $gameCode->profile_id)->sum('star');

		$profile = GameProfile::find($gameCode->profile_id);

		$profile->nickName1;
		$profile->nickName2;
		$profile->avatar;

		return ResponseHelper::OutputJSON('success', '' , [
				'first_name' => $profile->first_name,
				'last_name' => $profile->last_name,
				'grade' =>$profile->grade,
				'total_star' => $totalStar,
				'game_code' => $code,
				'nick_name1' =>$profile->nickName1->name,
				'nick_name2' =>$profile->nickName2->name,
				'avatar_id' => $profile->avatar->id,
		 ]);
	}

	function updateGameProfileLocationInfo($profileId){
		$profile = GameProfile::find($profileId);
		if(!$profile){return;}

		if(!$profile->country || !$profile->latitude || !$profile->longitude){
			$secret = 'SAKA5639953H5Z26Q74Z';
			$ip = Request::ip();
		
			$res = json_decode(file_get_contents("http://api.apigurus.com/iplocation/v1.8/locateip?key={$secret}&ip={$ip}&format=json&compact=y"), true);

			if(isset($res['geolocation_data'])) { 
				$data = $res['geolocation_data'];

				$profile->city = $data['city'];
				$profile->country = $data['country_name'];
				$profile->latitude = $data['latitude'];
				$profile->longitude = $data['longitude'];
				$profile->save();
			}
		}
	}	

}
