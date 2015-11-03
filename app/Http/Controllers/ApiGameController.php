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
use App\Models\GameQuestionp03;
use App\Models\GameQuestionP04ChallengeSet;
use App\Models\GameSystemPlanet;
use App\Models\UserExternalId;
use App\Models\LeaderboardWorld;
use App\Models\LeaderboardSystem;
use App\Models\LeaderboardPlanet;

Class ApiGameController extends Controller {

	//GET QUESTION
	public function request($planetId) {	
		$gameCode = Request::input('game_code');
		$difficulty = Request::input('difficulty');

		LogHelper::LogGetQuestions($planetId, $gameCode);

		try{
			$questionCount = Request::input('question_count');
			$profileId =  Request::input('game_code_profile_id');
			$gameType = Request::input('game_type');

			if($planetId < 100){
				return ResponseHelper::OutputJSON('fail', 'planet not yet support');
			}

			//get planet info
			if (Cache::has('ApiGameController@request('.$planetId.')') ) {

				$planet = Cache::get('ApiGameController@request('.$planetId.')');


			}else{
				$planet = GamePlanet::find($planetId);

				if(!$planet){
					return ResponseHelper::OutputJSON('fail', 'planet not found');
				}

			    $expiresAt = Carbon::now()->addMinutes(60);
				Cache::put('ApiGameController@request('.$planetId.')', $planet , $expiresAt);
			}

			if(!$planet->available){
				Cache::forget('ApiGameController@request('.$planetId.')');
				return ResponseHelper::OutputJSON('fail', 'planet is not enable');
			}	

			//NEED UPDATE 26/10/2015
			$userMap = ZapZapQuestionHelper::GetUserMapPersonal($profileId, $planetId);

			$planetTopScore = ZapZapQuestionHelper::GameScreenPlanetTopScore($planetId);
			$top_scre_result =[];
			for($i=0; $i<count($planetTopScore); $i++){

				array_push($top_scre_result,  [
					'nickname1'=>$planetTopScore[$i]->nickname1,
					'nickname2'=>$planetTopScore[$i]->nickname2,
					'avatar'=>$planetTopScore[$i]->avatar,
					'score'=>$planetTopScore[$i]->score,
					]);

			}
			
			if(!$difficulty || $difficulty > 5){
				$difficulty = $userMap->star + 1;
				if($difficulty > 5){ $difficulty = 5; }
			}

			$level = $userMap->level;

			if ( Cache::has('ApiGameController@request('.$planetId.','.$difficulty.')') ){

				$questions = Cache::get('ApiGameController@request('.$planetId.','.$difficulty.')');
			}else{

				$type = GameType::find($planet->game_type_id);
				switch($type->name){
					case 'p01':$questions = ZapZapQuestionHelper::GetQuestionP01($planetId,$difficulty,$questionCount); break;
					case 'p02':$questions = ZapZapQuestionHelper::GetQuestionP02($planetId,$difficulty,$questionCount); break;
					case 'p03':$questions = ZapZapQuestionHelper::GetQuestionP03($planetId,$difficulty,$questionCount); break;
					case 'p06':$questions = ZapZapQuestionHelper::GetQuestionP06($planetId,$difficulty,$questionCount); break;
					case 'p07':$questions = ZapZapQuestionHelper::GetQuestionP07($planetId,$difficulty,$questionCount); break;
					case 'p08':$questions = ZapZapQuestionHelper::GetQuestionP08($planetId,$difficulty,$questionCount); break;
					case 'p09':$questions = ZapZapQuestionHelper::GetQuestionP09($planetId,$difficulty,$questionCount); break;
					case 'p10':$questions = ZapZapQuestionHelper::GetQuestionP10($planetId,$difficulty,$questionCount); break;
					case 'p11':$questions = ZapZapQuestionHelper::GetQuestionP11($planetId,$difficulty,$questionCount); break;
					case 'p12':$questions = ZapZapQuestionHelper::GetQuestionP12($planetId,$difficulty,$questionCount); break;
					case 'p13':$questions = ZapZapQuestionHelper::GetQuestionP13($planetId,$difficulty,$questionCount); break;
					case 'p14':$questions = ZapZapQuestionHelper::GetQuestionP14($planetId,$difficulty,$questionCount); break;
					case 'p15':$questions = ZapZapQuestionHelper::GetQuestionP15($planetId,$difficulty,$questionCount); break;
					case 'p16':$questions = ZapZapQuestionHelper::GetQuestionP16($planetId,$difficulty,$questionCount); break;
					case 'p18':$questions = ZapZapQuestionHelper::GetQuestionP18($planetId,$difficulty,$questionCount); break;
					case 'p23':$questions = ZapZapQuestionHelper::GetQuestionP23($planetId,$difficulty,$questionCount); break;
					case 'p32':$questions = ZapZapQuestionHelper::GetQuestionP32($planetId,$difficulty,$questionCount); break;
					case 'p00':$questions = ZapZapQuestionHelper::GetQuestionP00($planetId,$gameType,$level,$profileId); break;

					default: return ResponseHelper::OutputJSON('fail', $type->name.' not found');
				}	
			}

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
					'planet_top_score'=>$top_scre_result,
						
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

	//SUBMIT RESULT
	public function result($planetId) {

		$Planet = GamePlanet::find($planetId);
		$jsonGameResult = Request::input('game_result');
		$hash = Request::input('hash');
		$random = Request::input('random');

		$profileId = Request::input('game_code_profile_id');
		$userId = Request::input('user_id');
		$deviceId = Request::input('game_code_device_id');
		$gameCode = Request::input('game_code');
		$gameCodeType = Request::input('game_code_type');

		try{
			if($planetId < 100){
				return ResponseHelper::OutputJSON('fail', 'planet not yet support');
			}

			if(!$Planet){
				return ResponseHelper::OutputJSON('fail', 'planet not found');
			}

			if(!$Planet->enable){
				return ResponseHelper::OutputJSON('fail', 'planet is not enable');
			}

			if(!$jsonGameResult || !$hash || !$random){
				return  [
					'status' => "fail",
					'message' => "missing parameter",
				]; 
			}

			$gameResult = json_decode($jsonGameResult, true);
			if(!isset($gameResult['score']) || !isset($gameResult['answers'])|| !isset($gameResult['status']) ){ 
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

			$result = DB::SELECT($sql, ['planet_id'=>$planetId] );

			$gameStatus = $gameResult['status'];
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
			$gamePlay->score = $gameResult['score'];
			$gamePlay->device_id = $deviceId;
			$gamePlay->code = $gameCode;
			$gamePlay->hash = $hash1;
			$gamePlay->status = $gameStatus;

			if(isset($gameResult['badges']) ){
				
				if($gameResult['badges']['speed'] == 'True'){
					$gameResult['badges']['speed'] = '1';
				}elseif($gameResult['badges']['speed'] == 'False'){
					$gameResult['badges']['speed'] = '0';
				}

				if($gameResult['badges']['accuracy'] == 'True'){
					$gameResult['badges']['accuracy'] = '1';
				}elseif($gameResult['badges']['accuracy'] == 'False'){
					$gameResult['badges']['accuracy'] = '0';
				}

				$gamePlay->badges_matrick = json_encode($gameResult['badges']);		
			}
			if(isset($gameResult['level']) ){
				$gamePlay->level =  $gameResult['level'];
			}
			$gamePlay->save();

			$gameCodePlayed = GameCode::where('code', $gameCode)->update([
					'played' => '1'
					]);;

			switch($result[0]->name){
				case 'p00': $status = ZapZapQuestionHelper::SubmitResultP00($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p01': $status = ZapZapQuestionHelper::SubmitResultP01($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p02': $status = ZapZapQuestionHelper::SubmitResultP02($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p03': $status = ZapZapQuestionHelper::SubmitResultP03($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p06': $status = ZapZapQuestionHelper::SubmitResultP06($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p07': $status = ZapZapQuestionHelper::SubmitResultP07($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p08': $status = ZapZapQuestionHelper::SubmitResultP08($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p09': $status = ZapZapQuestionHelper::SubmitResultP09($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p10': $status = ZapZapQuestionHelper::SubmitResultP10($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p11': $status = ZapZapQuestionHelper::SubmitResultP11($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p12': $status = ZapZapQuestionHelper::SubmitResultP12($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p13': $status = ZapZapQuestionHelper::SubmitResultP13($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p14': $status = ZapZapQuestionHelper::SubmitResultP14($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p15': $status = ZapZapQuestionHelper::SubmitResultP15($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p18': $status = ZapZapQuestionHelper::SubmitResultP18($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p23': $status = ZapZapQuestionHelper::SubmitResultP23($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p32': $status = ZapZapQuestionHelper::SubmitResultP32($planetId,$gamePlay,$gameResult,$profileId); break;

				default: return ResponseHelper::OutputJSON('fail', 'submit answer error');
			}

			ZapZapQuestionHelper::UserMap($profileId,$planetId,$gamePlay, $gameResult); //update user_map

			$profile = GameProfile::find($profileId);
			$systemPlanet = GameSystemPlanet::where('planet_id' , $planetId)->first();

			ZapZapQuestionHelper::LeaderboardUpdate($profile,$systemPlanet,$gameResult);
			LogHelper::LogPostResult($jsonGameResult, $gameCode);//log post result
			} catch (Exception $ex) {

				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
					'source' => 'ApiGameController > result', 
					'inputs' => Request::all(),
				])]);
				return ResponseHelper::OutputJSON('exception');
			}

			return ResponseHelper::OutputJSON('success');

	}

	public function resultLog(){
		$gameCode = Request::input('game_code');
		$page = Request::input("page", '1');
		$pageSize = Request::input("page_size", '30');

		try{

			$pagination = $pageSize*($page - 1);
			$sql = "	
				SELECT pl.`name`, r.`question_id`,  q.`difficulty` , r.`complite_time`, r.`target_id`, p.`target_type` 
					FROM `t0400_game_play` p, `t0300_game_result` r , `t0123_game_planet` pl , `t0200_game_question` q
						WHERE r.`play_id` = p.`id`
							AND q.`id` = r.`question_id`
							AND pl.`id` = p.`planet_id`
							AND p.`code` = :game_code

							order BY r.`created_at` ASC 
							LIMIT :page , 30
			";

			$count = "	
				SELECT count(*)
					FROM `t0400_game_play` p, `t0300_game_result` r , `t0123_game_planet` pl , `t0200_game_question` q
						WHERE r.`play_id` = p.`id`
							AND q.`id` = r.`question_id`
							AND pl.`id` = p.`planet_id`
							AND p.`code` = :game_code

			";


			$result = DB::SELECT($sql, ['game_code'=>$gameCode , 'page'=>$pagination]);

			$count = DB::SELECT($count, ['game_code'=>$gameCode]);
			$c = (array)$count[0];
		
			$resultHistory = [];
			for($i=0; $i<count($result); $i++){

				$r = (array)$result[$i];
				switch($r['target_type']){
				case 'p01': 
					$results = GameResultP01::find($r['target_id']);
					$correct = ['correct' => $results->correct];
					array_push($resultHistory  ,array_merge($r, $correct));

				break;
				case 'p02': 
					$results = GameResultP02::find($r['target_id']);
					$correct = ['correct' => $results->correct];

					array_push($resultHistory , array_merge($r, $correct));
					
				break;
				case 'p03': 
					$results = GameResultP03::find($r['target_id']);
					$correct = ['correct' => $results->correct];
					array_push($resultHistory  ,array_merge($r, $correct));
					
				break;
				case 'p04': 
					$results = GameResultP04::find($r['target_id']);
					$correct = ['correct' => $results->correct];
					array_push($resultHistory  ,array_merge($r, $correct));
					
				break;
				case 'p06': 
					$results = GameResultP06::find($r['target_id']);
					$correct = ['correct' => $results->correct];
					array_push($resultHistory  ,array_merge($r, $correct));
					
				break;
				}
			}

			return ResponseHelper::OutputJSON('success', '', [
				"result_history" => $resultHistory,
				'pageSize' => $pageSize, 
				'pageTotal' => ceil($c['count(*)']/$pageSize)

				]);
			} catch (Exception $ex) {

				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
					'source' => 'ApiGameController > resultLog',
					'inputs' => Request::all(),
				])]);
				return ResponseHelper::OutputJSON('exception');
			}
	}

	public function getUserMap(){
		$profileId = Request::input('game_code_profile_id');
		$userId = Request::input('user_id');
		$deviceId = Request::input('game_code_device_id');
		$gameCode = Request::input('game_code');
		

		try{
			$result = ZapZapQuestionHelper::GetUserMap($profileId);

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
					'subjects' => [
						['id'=>'1', 'code'=>'c.0.1']
					],
					'enable' => ($planetEnable)?1:0,

				]);				

				$prevPlanetStar = $r->star;
				$prevSystemId = $r->system_id;
			}
		return ResponseHelper::OutputJSON('success', '' , $systems);

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

	public function leaderBoardPlanet($planetId){
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
						case '1':$questions = ZapZapQuestionHelper::GetQuestionP01($p->id,$difficulty,$p->question_count); break;
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
						case '18':$questions = ZapZapQuestionHelper::GetQuestionP18($p->id,$difficulty,$p->question_count); break;
						case '23':$questions = ZapZapQuestionHelper::GetQuestionP23($p->id,$difficulty,$p->question_count); break;
						case '32':$questions = ZapZapQuestionHelper::GetQuestionP32($p->id,$difficulty,$p->question_count); break;
				
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
		           
		           	if (!is_dir($dir1) ){
						mkdir($dir1); //create the directory
						chmod($dir1, 0777); //make it writable
					}

					if (!is_dir($dir2) ){
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

}
