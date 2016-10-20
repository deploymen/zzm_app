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
use App\Libraries\ApiProfileHelper;

use App\Models;
use App\Models\GameProfile;
use App\Models\User;
use App\Models\GameClass;
use App\Models\GamePlay;
use App\Models\GamePlayThreshold;
use App\Models\GameCode;
use App\Models\GameSystem;
use App\Models\GamePlanet;
use App\Models\GameType;
use App\Models\UserMap;
use App\Models\GameQuestion;
use App\Models\GameSubject;
use App\Models\GamePlanetSubject;
use App\Models\GameSubjectSchedule;
use App\Models\GameMission;
use App\Models\GameQuestionP04ChallengeSet;
use App\Models\GameSystemPlanet;
use App\Models\UserExternalId;
use App\Models\LeaderboardWorld;
use App\Models\LeaderboardSystem;
use App\Models\LeaderboardPlanet;
use App\Models\IdCounter;
use App\Models\GameCoinTransaction;
use App\Models\CoinReward;
use App\Models\Spaceship;
use App\Models\SpaceshipUserSpaceship;
use App\Models\SpaceshipUserItem;
use App\Models\SpaceshipUserFloor;
use App\Models\SpaceshipFloor;
use App\Models\SpaceshipItem;

use App\Models\Questions\AbstractGameQuestion;
use App\Models\Results\AbstractGameResult;




Class ApiGameController extends Controller {
	
	//GET QUESTION
	public function requestV1_0($planetId, $language = 'en') {	

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

	public function requestV1_3($planetId, $language = 'en') {	

		$ON_CACHE = false;
		$CATCH_EX = false;
		
		try{
			$studentId = Request::input('student_id');
			$difficulty = Request::input('difficulty');			
			$questionCount = Request::input('question_count');
			$profileId =  Request::input('student_profile_id');//middle

			LogHelper::LogGetQuestions($planetId, $studentId);

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

				if(!$type){
					return ResponseHelper::OutputJSON('fail', 'missing game type');
				}
				$questions = AbstractGameQuestion::GetTypeQuestions($type->name, [
					'planetId' => $planetId, 
					'difficulty' => $difficulty, 
					'questionCount' => $questionCount, 
					'language' => $language, 
				]);

				Cache::put($planetDifficultyCacheKey, $questions, Carbon::now()->addMinutes(5));
			}
			$coinDaily = 0;
			$coinTutorial = 0;
			$coinVideo = 0;

			$playedEver = !!GamePlay::where('planet_id', $planetId)->where('profile_id', $profileId)->where('difficulty', $difficulty)->count();

			$playedDaily = GamePlay::where('profile_id', $profileId)->whereRaw('DATE(`created_at`) = DATE(NOW())')->count();

			$watchedTutorial = GamePlay::where('planet_id', $planetId)->where('profile_id', $profileId)->where('difficulty', $difficulty)->where('watched_tutorial' , 1)->first();

			$rewardName = ($planet->popularity == 'basic')?'play-basic':'play-hots';
			if($playedEver){
				$rewardName = 'play-repeat';
			}

			$coinRegular = CoinReward::GetEntitleCoinReward($rewardName , 'difficulty-'.$difficulty );

			if(!$playedDaily){
				$coinDaily = CoinReward::GetEntitleCoinReward('play-daily');
			}

			if(!$watchedTutorial){
				$coinTutorial = CoinReward::GetEntitleCoinReward('watch-tutorial');
			}

			//fail 2 time show video!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			$failCount = GamePlayThreshold::where('profile_id', $profileId)->where('planet_id', $planetId)->where('difficulty', $difficulty)->where('hit' , 2)->first();

			if($failCount){
				$coinVideo = CoinReward::GetEntitleCoinReward('watch-video');
			}
			//end show video
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
					'coin_rewards' => [
						'game_pass' => $coinRegular,
						'game_daily_first' => $coinDaily,
						'watch_tutorial' => $coinTutorial,
						'watch_video' => $coinVideo,
					],
					'planet_top_score'=>$topScoreResult,
						
	            	'questions' => $questions,
	            ]);

			} catch (Exception $ex) {

					throw $ex;
			
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

			//validate question ids
			$questionIds = [];
			foreach ($gameResult['answers'] as $answer){
				array_push($questionIds, $answer['question_id']); 
			}

			$sql = "
				SELECT COUNT(*) AS `count`
					FROM `t0200_game_question`
						WHERE `id` IN(".join(',', $questionIds).")	
			";
			$result = DB::SELECT($sql);

			if($result[0]->count != count($questionIds)){
				return ResponseHelper::OutputJSON('fail', 'invalid question id');
			}
			//validate question ids =end

			LogHelper::LogPostResult($planetId, $jsonGameResult, $gameCode);//log post result

			$sql = "
				SELECT t.`name` 
					FROM `t0123_game_planet` p, `t0121_game_type` t
						WHERE p.`id` = :planet_id	
							AND p.`game_type_id` = t.`id`
								LIMIT 1;		
			";

			$result = DB::SELECT($sql, ['planet_id'=>$planetId]);
			$typeName =  $result[0]->name; 

			$gameStatus = strtolower($gameResult['status']);
			switch($gameStatus){
				case 'false': $gameStatus = 'fail'; break;
				case 'true': $gameStatus = 'pass'; break;
			}

				
			$gamePlay = new GamePlay;
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

			ZapZapQuestionHelper::UserMapV1_0($profileId, $planetId, $gamePlay, $gameResult); //update user_map

			$profile = GameProfile::find($profileId);
			$systemPlanet = GameSystemPlanet::where('planet_id', $planetId)->first();

			ZapZapQuestionHelper::LeaderboardUpdate($profile, $systemPlanet, $gameResult);

			LogHelper::LogPostResult($planetId, $jsonGameResult, $gameCode);//log post result

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

			LogHelper::LogPostResult($planetId, $jsonGameResult, $gameCode);//log post result

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

			// if($checkResult){
			// 	return ResponseHelper::OutputJSON('fail', 'no double submit');
			// }

			//validate question ids
			$questionIds = [];
			foreach ($gameResult['answers'] as $answer){
				array_push($questionIds, $answer['question_id']); 
			}

			$sql = "
				SELECT COUNT(*) AS `count`
					FROM `t0200_game_question`
						WHERE `id` IN(".join(',', $questionIds).")	
			";
			$result = DB::SELECT($sql);

			if($result[0]->count != count($questionIds)){
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
			$gameStatus = strtolower($gameResult['status']);
			switch($gameStatus){
				case 'false': $gameStatus = 'fail'; break;
				case 'true': $gameStatus = 'pass'; break;
			}
				
			$gamePlay = new GamePlay;
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

			ZapZapQuestionHelper::UserMapV1_1($profileId, $planetId, $gamePlay, $gameResult, $gameResult['difficulty']); //update user_map
			ZapZapQuestionHelper::LastSession($userId, $profileId, $gameResult, $playedTime);

			$profile = GameProfile::find($profileId);
			$systemPlanet = GameSystemPlanet::where('planet_id', $planetId)->first();

			ZapZapQuestionHelper::LeaderboardUpdate($profile, $systemPlanet, $gameResult);
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
			$watchedTutorial = Request::input('watch_tutorial', 0);

			$profileId = Request::input('student_profile_id');
			$userId = Request::input('user_id');
			$studentId = Request::input('student_id');
			$profileType = Request::input('student_profile_type');

			$planet = GamePlanet::where('enable', 1)
					->where('id', '>=', 100)
					->find($planetId);

			$coinCollected = 0;

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

			$difficulty = $gameResult['difficulty'];

			//validate question ids
			$questionIds = [];
			foreach ($gameResult['answers'] as $answer){
				array_push($questionIds, $answer['question_id']); 
			}

			$sql = "
				SELECT COUNT(*) AS `count`
					FROM `t0200_game_question`
						WHERE `id` IN(".join(',', $questionIds).")	
			";
			$result = DB::SELECT($sql);

			if($result[0]->count != count($questionIds)){
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

			$gamePlay->user_id = $userId;
			$gamePlay->profile_id = $profileId;
			$gamePlay->planet_id = $planetId;
			$gamePlay->target_type = $typeName;
			$gamePlay->type = $profileType;
			$gamePlay->score = $gameResult['score'];
			$gamePlay->code = $studentId;
			$gamePlay->hash = $hash1;
			$gamePlay->status = $gameStatus;
			$gamePlay->played_time = $playedTime;
			$gamePlay->difficulty = $difficulty;

			if(isset($gameResult['badges'])){
				$gameResult['badges']['speed'] = ($gameResult['badges']['speed'] == 'True')?1:0;
				$gameResult['badges']['accuracy'] = ($gameResult['badges']['accuracy'] == 'True')?1:0;

				$gamePlay->badges_metrics = json_encode($gameResult['badges']);		
			}
			if(isset($gameResult['level'])){
				$gamePlay->level =  $gameResult['level'];
			}

			GameCode::where('code', $studentId)->update([
				'played' => '1'
			]);;

			//= Coin Rewards @start
			$playedEver = !!GamePlay::where('planet_id', $planetId)->where('profile_id', $profileId)->where('difficulty', $difficulty)->count();			
			$playedDaily = GamePlay::where('profile_id', $profileId)->whereRaw('DATE(`created_at`) = DATE(NOW())')->count();

			$rewardName = ($planet->popularity == 'basic')?'play-basic':'play-hot';
			if($playedEver){
				$rewardName = 'play-repeat';
			}

			$gamePlay->save();

			$coinRegular = CoinReward::GetEntitleCoinReward($rewardName , 'difficulty-'.$difficulty );
			$descriptionRegular = GameCoinTransaction::GetDescription($rewardName , ['playId' => $gamePlay->id , 'planetId' => $planetId , 'difficulty' => $difficulty ]);
			GameCoinTransaction::DoTransaction($profileId, $coinRegular, $descriptionRegular);

			if(!$playedDaily){
				$coinDaily = CoinReward::GetEntitleCoinReward('play-daily');
				$descriptionDaily = GameCoinTransaction::GetDescription('play-daily' , ['playId' => $gamePlay->id ]);
				GameCoinTransaction::DoTransaction($profileId, $coinDaily, $descriptionDaily);	
			}
			if($watchedTutorial){
				$coinTutorial = CoinReward::GetEntitleCoinReward('watch-tutorial');
				$descriptionTutorial = GameCoinTransaction::GetDescription('watch-tutorial' , ['playId' => $gamePlay->id ]);
				GameCoinTransaction::DoTransaction($profileId, $coinTutorial, $descriptionTutorial);	
			}

			//update play record too, again.
			if($gameStatus === 'pass'){
				$gamePlay->coin = $coinRegular;
				$gamePlay->save();
			}	
			//= Coin Rewards @end

			AbstractGameResult::SubmitTypeResult($typeName, [
				'planetId' => $planetId, 
				'gamePlay' => $gamePlay, 
				'gameResult' => $gameResult, 
				'profileId' => $profileId, 
			]);
			
			ZapZapQuestionHelper::UserMapV1_1($profileId, $planetId, $gamePlay, $gameResult, $difficulty); //update user_map
			ZapZapQuestionHelper::LastSession($userId, $profileId, $gameResult, $playedTime);

			//check mission
			// $threshold = GamePlayThreshold::UpdateThreshold($profileId, $planetId, $difficulty, $gameStatus);		
			// GameMission::CheckMission($threshold);

			$profile = GameProfile::find($profileId);
			$systemPlanet = GameSystemPlanet::where('planet_id', $planetId)->first();

			ZapZapQuestionHelper::LeaderboardUpdate($profile, $systemPlanet, $gameResult);
			LogHelper::LogPostResult($planetId, $jsonGameResult, $studentId);//log post result
			
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

	
			return ResponseHelper::OutputJSON('success', '', $systems );
		
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
			}

			if($profile->expired_at > date("Y-m-d H:i:s") ){
				$userType = 1;
			}else{
				$class = GameClass::find($profile->class_id);
				if($class){
					if($class->expired_at > date("Y-m-d H:i:s") ){
						$userType = 1;
					}
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
					if($userType == 2 && $r->user_type != 2 || $userType == 0 && $r->user_type == 1){ //2 = anonymous , 1 = paid
						//if profile user_type is anonymous(2) and planet user_type is not 2 , set enable false
						//if profile user_type is registed(0) but not paid and planet user_type = 1 , set enable false
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
		$profileId = Request::input('student_profile_id');
		$userId = Request::input('user_id');
		$studentId = Request::input('student_id');

		try{
			$result = ZapZapQuestionHelper::GetUserMapV1_3($profileId);

			$totalStar = UserMap::where('profile_id', $profileId)->sum('star');

			$profile = GameProfile::find($profileId);
			$profile->nickName1;
			$profile->nickName2;
			$profile->avatar;

			$userRole = 'anonymous';
			$user = User::find($profile->user_id);
			if($user){
				$userRole = $user->role;
			}

			$userEnablePlanet = 0;
			$userType = 2;
			if($profile->user_id){
				$userType = 0;
			}

			if($profile->expired_at > date("Y-m-d H:i:s") ){
				$userType = 1;
			}else{
				$class = GameClass::find($profile->class_id);
				if($class){
					if($class->expired_at > date("Y-m-d H:i:s") ){
						$userType = 1;
					}
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
					'playable' => $r->playable,

				]);				
				$prevSystemId = $r->system_id;
				$prevSubsytemId = $r->subsystem_id;
			}

			$mission = GameMission::GetMission($profileId);

			return ResponseHelper::OutputJSON('success', '' , [
					'profile' => [
						'first_name' => $profile->first_name,
						'grade' =>$profile->grade,
						'total_star' => $totalStar,
						'user_type' => $userType,
						'student_id' => $studentId,
						'nick_name1' =>$profile->nickName1->name,
						'nick_name2' =>$profile->nickName2->name,
						'avatar' => $profile->avatar,
						'coin' => $profile->coin,
						'user_role' => $userRole,
						] ,
					'game_mission' => $mission,
					'system_planet' => $systems,
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

	public function leaderBoardPlanet($version, $planetId){
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
					$language = 'en';

					$type = GameType::find($p->game_type_id);
					$questions = AbstractGameQuestion::GetTypeQuestions($type->name, [
						'planetId' => $p->id, 
						'difficulty' => $difficulty, 
						'questionCount' => $p->question_count, 
						'language' => $language, 
					]);
					
					
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

		$checkGameCode = GameCode::where('code', $gameCode)->first();

		if(!$checkGameCode){
			$idCounter = IdCounter::find(1);
			$gameCodeSeed = $idCounter->game_code_seed;
			$idCounter->game_code_seed = $gameCodeSeed + 1;
			$idCounter->save();

			$gamePro = new GameProfile;
			$gamePro->user_id = 0;
			$gamePro->first_name = "Anonymous";
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

	public function checkStudentIdV1_3(){
		// middleware check
		$studentId = Request::input('student_id');

		if(!$studentId){
			return ResponseHelper::OutputJSON('fail', 'missing parameter' );
		}

		$profile = GameProfile::where('student_id' , $studentId)->first();

		if(!$profile){
			return ResponseHelper::OutputJSON('fail', 'student id not found' );
		}

		return ResponseHelper::OutputJSON('success',  '' , ['account_type' => $profile->profile_type]);

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
					case 'p00': $status = ZapZapQuestionHelper::SubmitResultP00($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p01': $status = ZapZapQuestionHelper::SubmitResultP01($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p02': $status = ZapZapQuestionHelper::SubmitResultP02($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p03': $status = ZapZapQuestionHelper::SubmitResultP03($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p06': $status = ZapZapQuestionHelper::SubmitResultP06($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p07': $status = ZapZapQuestionHelper::SubmitResultP07($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p08': $status = ZapZapQuestionHelper::SubmitResultP08($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p09': $status = ZapZapQuestionHelper::SubmitResultP09($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p10': $status = ZapZapQuestionHelper::SubmitResultP10($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p11': $status = ZapZapQuestionHelper::SubmitResultP11($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p12': $status = ZapZapQuestionHelper::SubmitResultP12($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p13': $status = ZapZapQuestionHelper::SubmitResultP13($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p14': $status = ZapZapQuestionHelper::SubmitResultP14($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p15': $status = ZapZapQuestionHelper::SubmitResultP15($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p16': $status = ZapZapQuestionHelper::SubmitResultP16($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p17': $status = ZapZapQuestionHelper::SubmitResultP17($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p18': $status = ZapZapQuestionHelper::SubmitResultP18($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p19': $status = ZapZapQuestionHelper::SubmitResultP19($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p20': $status = ZapZapQuestionHelper::SubmitResultP20($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p21': $status = ZapZapQuestionHelper::SubmitResultP21($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p23': $status = ZapZapQuestionHelper::SubmitResultP23($planetId, $gamePlay, $sgameResult, $profileId); break;
					case 'p32': $status = ZapZapQuestionHelper::SubmitResultP32($planetId, $gamePlay, $sgameResult, $profileId); break;

					default: return ResponseHelper::OutputJSON('fail', 'submit answer error');
				}

				ZapZapQuestionHelper::UserMapV1_1($profileId, $planetId, $gamePlay, $gameResult, $sgameResult['difficulty']); //update user_map

				$profile = GameProfile::find($profileId);
				$systemPlanet = GameSystemPlanet::where('planet_id', $planetId)->first();

				ZapZapQuestionHelper::LeaderboardUpdate($profile, $systemPlanet, $gameResult);
				LogHelper::LogPostResult($planetId, $gameResult, $gameCode);//log post result
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

	public function offlinePostV1_3(){
		$jsonGameResult = Request::input('result');

		$profileId = Request::input('student_profile_id');
		$userId = Request::input('user_id');
		$studentId = Request::input('student_id');
		$profileType = Request::input('student_profile_type');
		// $results = array($result);
		$results = json_decode( ($jsonGameResult), true );

		try{

			for($i=0; $i<=(count($results) - 1); $i++){
				$r = $results[$i];

				$gameResult = $r['game_result'];

				$sgameResult = json_decode(($gameResult), true);
				$planetId = $r['planet_id'];

				$planet = GamePlanet::where('enable', 1)
						->where('id', '>=', 100)
						->find($planetId);

				$coinCollected = 0;

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
					return ResponseHelper::OutputJSON('fail', 'no double submit');
				}

				//validate question ids
				$questionIds = [];
				foreach ($sgameResult['answers'] as $answer){
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

				$gameStatus = strtolower($sgameResult['status']);
				switch($gameStatus){
					case 'false': $gameStatus = 'fail'; break;
					case 'true': $gameStatus = 'pass'; break;
				}

				$gamePlay->user_id = $userId;
				$gamePlay->profile_id = $profileId;
				$gamePlay->planet_id = $planetId;
				$gamePlay->target_type = $typeName;
				$gamePlay->type = $profileType;
				$gamePlay->score = $sgameResult['score'];
				$gamePlay->code = $studentId;
				$gamePlay->hash = $hash1;
				$gamePlay->status = $gameStatus;
				$gamePlay->played_time = $playedTime;
				$gamePlay->difficulty = $sgameResult['difficulty'];

				if(isset($sgameResult['badges'])){
					$sgameResult['badges']['speed'] = ($sgameResult['badges']['speed'] == 'True')?1:0;
					$sgameResult['badges']['accuracy'] = ($sgameResult['badges']['accuracy'] == 'True')?1:0;

					$gamePlay->badges_metrics = json_encode($sgameResult['badges']);		
				}

				if(isset($sgameResult['level'])){
					$gamePlay->level =  $sgameResult['level'];
				}

				$gamePlay->save();

				GameCode::where('code', $studentId)->update([
					'played' => '1'
				]);;


				AbstractGameResult::SubmitTypeResult($typeName, [
					'planetId' => $planetId, 
					'gamePlay' => $gamePlay, 
					'gameResult' => $sgameResult, 
					'profileId' => $profileId, 
				]);
				
				//= Coin Rewards @start
				$playedEver = !!GamePlay::where('planet_id', $planetId)->where('profile_id', $profileId)->where('difficulty', $sgameResult['difficulty'])->count();			
				$playedDaily = GamePlay::where('profile_id', $profileId)->whereRaw('DATE(`created_at`) = DATE(NOW())')->count();

				$rewardName = ($planet->popularity == 'basic')?'play-basic':'play-hot';
				if($playedEver){
					$rewardName = 'play-repeat';
				}

				$coinRegular = CoinReward::GetEntitleCoinReward($rewardName , 'difficulty-'.$sgameResult['difficulty'] );
				$descriptionRegular = GameCoinTransaction::GetDescription($rewardName , ['playId' => $gamePlay->id , 'planetId' => $planetId , 'difficulty' => $sgameResult['difficulty'] ]);
				GameCoinTransaction::DoTransaction($profileId, $coinRegular, $descriptionRegular);

				if(!$playedDaily){
					$coinDaily = CoinReward::GetEntitleCoinReward('play-daily');
					$descriptionDaily = GameCoinTransaction::GetDescription('play-daily' , ['playId' => $gamePlay->id, 'planetId' => $planetId , 'difficulty' => $sgameResult['difficulty'] ]);
					GameCoinTransaction::DoTransaction($profileId, $coinDaily, $descriptionDaily);	
				}

				if($watchedTutorial){
					$coinTutorial = CoinReward::GetEntitleCoinReward('watch-tutorial' , 'difficuldifficulty' );
					$descriptionTutorial = GameCoinTransaction::GetDescription('watch-tutorial' , ['playId' => $gamePlay->id, 'planetI' => $sgameResult['difficulty'] ]);
					GameCoinTransaction::DoTransaction($profileId, $coinTutorial, $descriptionTutorial);	
				}

				//update play record too, again.
				if($gameStatus === 'pass'){
					$gamePlay->coin = $coinRegular;
					$gamePlay->save();
				}			
				//= Coin Rewards @end


				ZapZapQuestionHelper::UserMapV1_1($profileId, $planetId, $gamePlay, $sgameResult, $sgameResult['difficulty']); //update user_map
				ZapZapQuestionHelper::LastSession($userId, $profileId, $sgameResult, $playedTime);

				$profile = GameProfile::find($profileId);
				$systemPlanet = GameSystemPlanet::where('planet_id', $planetId)->first();

				ZapZapQuestionHelper::LeaderboardUpdate($profile, $systemPlanet, $sgameResult);
				LogHelper::LogPostResult($planetId, $jsonGameResult, $studentId);//log post result
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

		$gameCode = GameCode::where('code', $code)->first();

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
				'grade' =>$profile->grade,
				'total_star' => $totalStar,
				'game_code' => $code,
				'nick_name1' =>$profile->nickName1->name,
				'nick_name2' =>$profile->nickName2->name,
				'avatar_id' => $profile->avatar->id,
		 ]);
	}

	public function getStudentIdInfo(){
		$studentId = Request::input('student_id');

		if(!$studentId){
			return ResponseHelper::OutputJSON('fail' , 'missing parameter');
		}

		$gameProfile = GameProfile::where('student_id', $studentId)->first();

		if(!$gameProfile){
			return ResponseHelper::OutputJSON('fail' , 'student id not found');
		}

		$totalStar = UserMap::where('profile_id', $gameProfile->id)->sum('star');
		$gameProfile->nickName1;
		$gameProfile->nickName2;
		$gameProfile->avatar;

		return ResponseHelper::OutputJSON('success', '' , [
				'first_name' => $gameProfile->first_name,
				'grade' =>$gameProfile->grade,
				'total_star' => $totalStar,
				'student_id' => $studentId,
				'nick_name1' =>$gameProfile->nickName1->name,
				'nick_name2' =>$gameProfile->nickName2->name,
				'avatar_id' => $gameProfile->avatar->id,
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

	public function getSpaceship(){
		$profileId = Request::input('student_profile_id');
		$spaceship = $this->getSpaceshipSub($profileId);

		return ResponseHelper::OutputJSON('success', '' ,$spaceship);
	}

	function getSpaceshipSub($profileId){
		$spaceship = Spaceship::getSpaceShip($profileId);

		$profile = GameProfile::select('coin')->find($profileId);

		if (!$profile) {
			return ResponseHelper::OutputJSON('fail', 'profile not found');
		}

		$spaceshipArray = [];		
		$prevSpaceshipId = 0;
		$prevFloorId = 0;
		$prevPlanetEnable = true;

		for($i=0; $i<count($spaceship); $i++){
			$r = $spaceship[$i];

			if($r->spaceship_id != $prevSpaceshipId){
				$floors = SpaceshipUserFloor::totalFloor($profileId , $r->spaceship_id);
				$spaceships = Spaceship::find($r->spaceship_id);
				$count = $floors + 1;

				if($count >= 4){
					$count = 4;
				}

				$coinUnlockFloor = 'coin_unlock_floor_'.$count;
				array_push($spaceshipArray, [
					'spaceship_id' => $r->spaceship_id,
					'spaceship_name' => $r->spaceship_name,
					'locked' => $r->spaceship_locked,
					'next_floor_coin' => $spaceships->$coinUnlockFloor,
					'floor' => []
				]);
			}

			if($r->floor_id != $prevFloorId){
				$items = SpaceshipUserItem::totalItems($profileId , $r->floor_id);
				$floor = SpaceshipFloor::find($r->floor_id);
				$count = $items + 1;

				if($count >= 16){
					$count = 16;
				}

				$coinUnlockItem = 'coin_unlock_item_'.$count;
				array_push($spaceshipArray[count($spaceshipArray)-1]['floor'], [
					'floor_id' => $r->floor_id,
					'floor_name' => $r->floor_name,
					'locked' =>$r->floor_locked,
					'next_item_coin' => $floor->$coinUnlockItem,
					'selected_items' => [],
					'items' => []
				]);				
			}

			if($r->selected){
				array_push($spaceshipArray[count($spaceshipArray)-1]['floor'][count($spaceshipArray[count($spaceshipArray)-1]['floor'])-1]['selected_items'], $r->item_id);	
			}
			array_push($spaceshipArray[count($spaceshipArray)-1]['floor'][count($spaceshipArray[count($spaceshipArray)-1]['floor'])-1]['items'], [
				'item_id' => $r->item_id,
				'item_name' => $r->item_name,
				'locked' => $r->item_locked,
				'selected' => $r->selected,

			]);				
			$prevSpaceshipId = $r->spaceship_id;
			$prevFloorId = $r->floor_id;
		}

		return [
			'profile' => $profile,
			'spaceship' => $spaceshipArray
			];
	}

	public function unlockSpaceship(\Illuminate\Http\Request $request){

		if(!$request->spaceship_id){
			return ResponseHelper::OutputJSON('fail' , 'missing parameter');
		}

		$spaceship = SpaceshipUserSpaceship::where('profile_id' , $request->student_profile_id)->count();
		
		$cointUnlockSpaceship = '0';
		if($spaceship == 1){
			$cointUnlockSpaceship = '10000';
		}

		$gameCoinTransaction = GameCoinTransaction::DoPaymentTransaction( $request->student_profile_id , $cointUnlockSpaceship ,'unlock-spaceship-spaceship-'.$request->spaceship_id);

		if(!$gameCoinTransaction){
			return ResponseHelper::OutputJSON('fail' , 'transaction denied');
		}

		SpaceshipUserSpaceship::create([
			'user_id' => $request->user_id,
			'profile_id' => $request->student_profile_id,
			'spaceship_id' => $request->spaceship_id,
			'locked' => 0,
			]);

		$spaceship = $this->getSpaceshipSub($request->student_profile_id);

		return ResponseHelper::OutputJSON('success' , '' , $spaceship);
	}

	public function unlockFloor(\Illuminate\Http\Request $request){

		if(!$request->floor_id || !$request->spaceship_id){
			return ResponseHelper::OutputJSON('fail' , 'missing parameter');
		}

		$userFloor = SpaceshipUserFloor::where('floor_id' ,$request->floor_id )->where('profile_id', $request->student_profile_id)->first();
		if($userFloor){
			return ResponseHelper::OutputJSON('fail' , 'floor already unlocked');
		}

		$floors = SpaceshipUserFloor::totalFloor($request->student_profile_id , $request->spaceship_id);
		$spaceships = Spaceship::find($request->spaceship_id);
		$count = $floors + 1;

		if($count >= 4){
			$count = 4;
		}

		$coinUnlockFloor = 'coin_unlock_floor_'.$count;
		$spaceship = Spaceship::find($request->spaceship_id);

		$gameCoinTransaction = GameCoinTransaction::DoPaymentTransaction( $request->student_profile_id , $spaceship->$coinUnlockFloor ,'unlock-spaceship-floor-'.$request->floor_id);

		if(!$gameCoinTransaction){
			return ResponseHelper::OutputJSON('fail' , 'transaction denied');
		}

		$spaceshipItem = SpaceshipItem::where('floor_id', $request->floor_id)->first();

		SpaceshipUserItem::create([
			'user_id' => $request->user_id,
			'profile_id' => $request->student_profile_id,
			'floor_id' => $request->floor_id,
			'item_id' => $spaceshipItem->id,
			'selected' => 1,
			'locked' => 0,
			]);
		//CANNOT INSERT THIS EVERYTIME
		SpaceshipUserFloor::create([
			'user_id' => $request->user_id,
			'profile_id' => $request->student_profile_id,
			'floor_id' => $request->floor_id,
			'locked' => 0,
			]);
		
		$spaceship = $this->getSpaceshipSub($request->student_profile_id);

		return ResponseHelper::OutputJSON('success' , '' , $spaceship);
	}

	public function unlockItem(\Illuminate\Http\Request $request){

		if(!$request->item_id || !$request->floor_id){
			return ResponseHelper::OutputJSON('fail' , 'missing parameter');
		}

		$userItem = SpaceshipUserItem::where('item_id', $request->item_id)->where('profile_id' , $request->student_profile_id)->first();
		if($userItem){
			return ResponseHelper::OutputJSON('fail' , 'item already unlocked');
		}

		$items = SpaceshipUserItem::totalItems($request->student_profile_id , $request->floor_id);
		$floor = SpaceshipFloor::find($request->floor_id);

		$count = $items + 1;
		if($count >= 16){
			$count = 16;
		}

		$nextPurchase = 'coin_unlock_item_'.$count;
		$coinValue = $floor->$nextPurchase;

		$gameCoinTransaction = GameCoinTransaction::DoPaymentTransaction( $request->student_profile_id , $coinValue ,'unlock-spaceship-item-'.$request->item_id);
		if(!$gameCoinTransaction){
			return ResponseHelper::OutputJSON('fail' , 'transaction denied');
		}

		//CANNOT INSERT THIS EVERYTIME
		SpaceshipUserItem::create([
			'user_id' => $request->user_id,
			'profile_id' => $request->student_profile_id,
			'floor_id' => $request->floor_id,
			'item_id' => $request->item_id,
			'locked' => 0,
		]);

		$spaceship = $this->getSpaceshipSub($request->student_profile_id);

		return ResponseHelper::OutputJSON('success' , '' , $spaceship);
	}

	public function spaceshipItemSelected($floorId){
		$profileId = Request::input('student_profile_id');
		$items = Request::input('item_id');

		if(!$items){
			return ResponseHelper::OutputJSON('fail' , 'missing parameter');	
		}

		SpaceshipUserItem::where('profile_id' , $profileId)->where('floor_id' , $floorId)->update([
			'selected' => 0
		]);

		$item = explode(',', $items);

		foreach($item as $i){
			SpaceshipUserItem::where('profile_id' , $profileId)->where('floor_id',$floorId)->where('item_id', $i)->update(['selected' => 1]);
		}

		$spaceship = $this->getSpaceshipSub($profileId);
		
		return ResponseHelper::OutputJSON('success' , '' , $spaceship);
	}

	public function addCoin(){
		$studentId = Request::input('student_id');
		$coin = Request::input('coin');
		$profileId = Request::input('student_profile_id');
		$profile = GameProfile::where('student_id' , $studentId)->update([
			'coin' => $coin
			]);

		$spaceship = $this->getSpaceshipSub($profileId);

		return ResponseHelper::OutputJSON('success', '', $spaceship);

	}

}
