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
use App\Libraries\ZapZapQuestionHelper;

use App\Models;
use App\Models\GameProfile;
use App\Models\GamePlay;
use App\Models\GameCode;
use App\Models\GameSystem;
use App\Models\GamePlanet;
use App\Models\UserMap;
use App\Models\GameResult;
use App\Models\GameResultP01;
use App\Models\GameResultP02;
use App\Models\GameResultP03;
use App\Models\GameResultP06;
use App\Models\GameResultP07;
use App\Models\GameResultP10;
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
		// try{
			$profileId =  Request::input('game_code_profile_id');

			if($planetId < 100){
				return ResponseHelper::OutputJSON('fail', 'planet not yet support');
			}

			//get planet info
			$planet = ZapZapQuestionHelper::GetPlanetInfo($planetId);

			if(!$planet){
				return ResponseHelper::OutputJSON('fail', 'planet not found');
			}
      
			if(!$planet->enable){
				return ResponseHelper::OutputJSON('fail', 'planet is not enable');
			}	
			
			//get user map
			$userMap = ZapZapQuestionHelper::GetUserMap($profileId, $planetId);

			$planetTopScore = ZapZapQuestionHelper::GameScreenPlanetTopScore($planetId);
			$playerTopScore = ZapZapQuestionHelper::GameScreenPlayerTopScore($planetId,$profileId);

			$top_scre_result =[];
			for($i=0; $i<count($planetTopScore); $i++){

				array_push($top_scre_result,  [
					'nickname1'=>$planetTopScore[$i]->nickname1,
					'nickname2'=>$planetTopScore[$i]->nickname2,
					'avatar'=>$planetTopScore[$i]->avatar,
					'score'=>$planetTopScore[$i]->score,
					]);

			}

			$difficulty = $userMap[0]->star + 1;
			if($difficulty > 5){ $difficulty = 5; }

			switch($planet->game_type){
				case 'p01':$questions = ZapZapQuestionHelper::GetQuestionP01($planetId,$difficulty); break;
				case 'p02':$questions = ZapZapQuestionHelper::GetQuestionP02($planetId,$difficulty); break;
				case 'p03':$questions = ZapZapQuestionHelper::GetQuestionP03($planetId,$difficulty); break;
				case 'p06':$questions = ZapZapQuestionHelper::GetQuestionP06($planetId,$difficulty); break;
				case 'p07':$questions = ZapZapQuestionHelper::GetQuestionP07($planetId,$difficulty); break;
				case 'p10':$questions = ZapZapQuestionHelper::GetQuestionP10($planetId,$difficulty); break;

			}	

			return ResponseHelper::OutputJSON('success', '', [
					'planet' => [
						'id' => $planet->id,
						'name' => $planet->name,
						'description' => $planet->description,
						'parameters' => json_decode($planet->param),
						'question_count' => $planet->question_count,
						'badges' => json_decode($planet->badges_metrics),
					],
					'status' => [
						'star' => $userMap[0]->star,	
						'difficulty' =>$difficulty,
						'top_score' => $userMap[0]->top_score,
					],
					'planet_top_score'=>$top_scre_result,
						
	            	'questions' => $questions,
	            ]);

			// } catch (Exception $ex) {

			// 	LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
			// 		'source' => 'ApiGameController > request',
			// 		'inputs' => Request::all(),
			// 	])]);
			// 	return ResponseHelper::OutputJSON('exception');
			// }
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
		$gameType = Request::input('game_code_type');

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
	
			if(!isset($gameResult['score']) || !isset($gameResult['answers'])|| !isset($gameResult['status']) || !isset($gameResult['badges'])){ 
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

			$gamePlay = new GamePlay;
			$gamePlay->user_id = $userId;
			$gamePlay->profile_id = $profileId;
			$gamePlay->planet_id = $planetId;
			$gamePlay->target_type = $result[0]->name;
			$gamePlay->type = $gameType;
			$gamePlay->score = $gameResult['score'];
			$gamePlay->device_id = $deviceId;
			$gamePlay->code = $gameCode;
			$gamePlay->hash = $hash1;
			$gamePlay->status = $gameResult['status'];
			$gamePlay->badges_matrick = json_encode($gameResult['badges']);
			$gamePlay->save();

			$gameCodePlayed = GameCode::where('code', $gameCode)->update([
					'played' => '1'
					]);;

			switch($result[0]->name){
				case 'p01': $status = ZapZapQuestionHelper::SubmitResultP01($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p02': $status = ZapZapQuestionHelper::SubmitResultP02($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p03': $status = ZapZapQuestionHelper::SubmitResultP03($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p06': $status = ZapZapQuestionHelper::SubmitResultP06($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p07': $status = ZapZapQuestionHelper::SubmitResultP07($planetId,$gamePlay,$gameResult,$profileId); break;
				case 'p10': $status = ZapZapQuestionHelper::SubmitResultP10($planetId,$gamePlay,$gameResult,$profileId); break;

			}	

			$profile = GameProfile::find($profileId);
			$systemPlanet = GameSystemPlanet::where('planet_id' , $planetId)->first();

			ZapZapQuestionHelper::LeaderboardUpdate($profile,$systemPlanet,$gameResult);
			
			} catch (Exception $ex) {

				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
					'source' => 'ApiGameController > result', 
					'inputs' => Request::all(),
				])]);
				return ResponseHelper::OutputJSON('exception');
			}

			return ResponseHelper::OutputJSON('success');

	}

	public function systemPlanetProgress() {
		$gameCode = Request::input('game_code');
		$profileId = Request::input('game_code_profile_id');
		$page = Request::input("page", '1');
		$pageSize = Request::input("page_size", '30');

		try{

			$startIndex = $pageSize*($page - 1);
			

			$total = GameSystem::where('enable' , 1)->count();

	       	$resultSystemIds = GameSystem::where('enable', 1)->skip($startIndex)->take($pageSize)->select('id')->get();

	       	$systemIds = [];
	       	for($i=0; $i<count($resultSystemIds); $i++){
	       		array_push($systemIds, $resultSystemIds[$i]->id);
	       	}

	       	$systemIds = implode(',', $systemIds);

			$sql = " 
				SELECT s.`id` AS `system_id` , s.`name` AS `system_name` , p.`id` AS `planet_id`, p.`description` AS `subtitle`, COUNT(gp.`id`) AS `play_count` ,IFNULL(MAX(gp.`score`), 0) AS `max_score` , IFNULL(um.`star`, 0) AS `star`
					FROM (`t0122_game_system` s, `t0123_game_planet` p, `t0124_game_system_planet` sp)
	                
						LEFT JOIN `t0400_game_play` gp ON( p.`id` = gp.`planet_id` AND gp.`code` = :game_code )
	                    LEFT JOIN `t0501_game_user_map` um ON( um.`profile_id` = :profileId AND um.`planet_id` = p.`id`)
	                    
							WHERE s.`id` IN ($systemIds)
								AND sp.`planet_id` = p.`id`
								AND sp.`system_id` = s.`id` 
								AND sp.`enable` = 1
	                                    GROUP BY s.`id`, p.`id`
										ORDER BY s.`sequence` ASC
			";

			$result = DB::SELECT($sql, ['game_code'=>$gameCode , 'profileId'=>$profileId]);

			$answers = [];
			$prev_system_id = '';
			for($i=0; $i<count($result); $i++){
				$played = (rand(0, 100) / 100) < 0.7;
				$r = $result[$i];
				if($r->system_id != $prev_system_id){
					array_push($answers, [
						'id' => $r->system_id,
						'system_name' => $r->system_name,
						'played' => ($played)?1:0,
						'planets' => []
					]);
				}

				array_push($answers[count($answers) - 1]['planets'], [
						'id' => $r->planet_id,
						'subtitle' => $r->subtitle,
						'play_count' => $r->play_count,
						'star' => $r->star,
						'max_score' => $r->max_score,
						'played' => ($played)?1:0,
				]);


				$prev_system_id = $r->system_id;
			}	
			return ResponseHelper::OutputJSON('success', '' , [
				'system' =>$answers,
				'page' => $page,
				'page_size' => $pageSize, 
				'pageTotal' => ceil($total/$pageSize) ,
				]);
			} catch (Exception $ex) {

				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
					'source' => 'ApiGameController > systemPlanetProgress',
					'inputs' => Request::all(),
				])]);
				return ResponseHelper::OutputJSON('exception');
			}
	}

	public function systemPlanetPlay($profileId,$planetId){
		$gameCode = Request::input('game_code');
		$pageSize = Request::input('page_size', '30');
		$page = Request::input("page", '1');
		try {
			$startIndex = $pageSize*($page - 1);


			$playId = GamePlay::where('planet_id', $planetId)->skip($startIndex)->take($pageSize)->get();			
			if(!$playId){
				return ResponseHelper::OutputJSON('fail', 'game play not found');
			}
			$gamePlay = GamePlay::where('planet_id', $planetId)->first();

			if(!$gameCode){
				$gameCode = GameCode::where('profile_id', $profileId)->select('code')->first();
				$gameCode = $gameCode->code;
			}

			$total = GamePlay::where('planet_id', $planetId)->where('code', $gameCode)->count();

			$systemIds = [];
	       	for($i=0; $i<count($playId); $i++){
	       		//$played for flag play 0/1
				$played = (rand(0, 100) / 100) < 0.7;

	       		array_push($systemIds, $playId[$i]->id);
	       	}
	       	$systemIds = implode(',', $systemIds);

			switch ($playId[0]->target_type) {

				case 'p01':
					$sql = "
						SELECT  p.`id` AS `play_id` , p.`planet_id` , p.`score` , p.`status` , p.`target_type` ,p.`created_at` AS `play_time`, r.`id` AS `result_id` , r.`play_id` , r.`question_id` , r.`target_type` ,
						 r1.`correct`, r1.`angle3` ,r1.`angle4` , r1.`angle5`,r1.`angle6` ,q1.*,
						IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`

							FROM (`t0400_game_play` p, `t0300_game_result` r, `t0301_game_result_p01` r1 , `t0201_game_question_p01` q1  )
								LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
								LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
							
								WHERE  p.`id` IN ({$systemIds})
								AND r1.`target_id` = q1.`id`
								AND r.`target_id` = r1.`id`
								AND r.`play_id` = p.`id`
								AND p.`planet_id` =  :planet_id
								AND p.`code` = :gameCode

							ORDER BY r.`id` ASC;


					";	
					$params = ['planet_id'=>$planetId , 'gameCode'=>$gameCode];
					$result = DB::SELECT($sql , $params);

					$results = [];		
					$prevPlayId = 0;
					
					for($i=0; $i<count($result); $i++){
						$r = $result[$i];
						if($r->play_id != $prevPlayId){
							array_push($results, [
								'id' => $r->play_id,
								'planet_id'=>$r->planet_id,
								'score'=>$r->score,
								'status'=>$r->status,
								'target_type'=>$r->target_type,
								'played' => ($played)?1:0,
								'play_time' => $r->play_time,
								'result'=> []
							]);
						}
						$r2 = $results[count($results)-1]['result'];
						if(!$r2 || $r->question_id != $prevQuestionId){
							array_push($results[count($results)-1]['result'], [
							'id' => $r->question_id,
							'question' => $r->question,
							'question_angle3' => $r->question_angle3,
							'question_angle4' => $r->question_angle4,
							'question_angle5' => $r->question_angle5,
							'question_angle6' => $r->question_angle6,
							'answer_angle3' => $r->answer_angle3,
							'answer_angle4' => $r->answer_angle4,
							'answer_angle5' => $r->answer_angle5,
							'answer_angle6' => $r->answer_angle6,
							'answer' => [
								'result_id' => $r->result_id,
								'correct'=> $r->correct,
								'angle3'=>$r->angle3,
								'angle4'=>$r->angle4,
								'angle5'=>$r->angle5,
								'angle6'=>$r->angle6,
								],
							'subjects' => []
						]);
						}
					array_push($results[count($results)-1]['result'][count($results[count($results)-1]['result'])-1]['subjects'] ,[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);

					$prevPlayId = $r->play_id; 
					$prevQuestionId = $r->question_id;
				}
				break;

				case 'p02':

					$sql = "
						SELECT  p.`id` AS `play_id` , p.`planet_id` , p.`score` , p.`status` , p.`target_type` , r.`id` AS `result_id` , r.`play_id` , r.`question_id` , r.`target_type` ,
						 r2.`correct` , r2.`answer_1` ,r2.`answer_2` , r2.`answer_3`,r2.`answer_4` ,r2.`answer_5` ,r2.`answer_6` ,q2.*,
						IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`

							FROM (`t0400_game_play` p, `t0300_game_result` r, `t0302_game_result_p02` r2 , `t0202_game_question_p02` q2  )
								LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
								LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
							
								WHERE p.`id` IN ({$systemIds})
								AND  r2.`target_id` = q2.`id`
								AND r.`target_id` = r2.`id`
								AND r.`play_id` = p.`id`
								AND p.`planet_id` =  :planet_id
								AND p.`code` = :gameCode

							ORDER BY r.`id` ASC;


					";	
					$result = DB::SELECT($sql , ['planet_id'=>$planetId , 'gameCode'=>$gameCode]);

					$results = [];		
					$prevPlayId = 0;
					
					for($i=0; $i<count($result); $i++){
						$r = $result[$i];
						if($r->play_id != $prevPlayId){
							array_push($results, [
								'id' => $r->play_id,
								'planet_id'=>$r->planet_id,
								'score'=>$r->score,
								'status'=>$r->status,
								'target_type'=>$r->target_type,
								'result'=> []
							]);
						}
						$r2 = $results[count($results)-1]['result'];
						if(!$r2 || $r->question_id != $prevQuestionId){

							array_push($results[count($results)-1]['result'], [
							'id' => $r->question_id,
							'question' => $r->question,
							'answer_option_1' => $r->answer_option_1,
							'answer_option_2' => $r->answer_option_2,
							'answer_option_3' => $r->answer_option_3,
							'answer_option_4' => $r->answer_option_4,
							'answer_option_5' => $r->answer_option_5,
							'answer_option_6' => $r->answer_option_6,

							'answer' => [
								'result_id' => $r->result_id,
								'correct'=> $r->correct,
								'answer_1'=>$r->answer_1,
								'answer_2'=>$r->answer_2,
								'answer_3'=>$r->answer_3,
								'answer_4'=>$r->answer_4,
								'answer_5'=>$r->answer_5,
								'answer_6'=>$r->answer_6,
								],
							'subjects' => []
						]);
						}
					array_push($results[count($results)-1]['result'][count($results[count($results)-1]['result'])-1]['subjects'] ,[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);

					$prevPlayId = $r->play_id; 
					$prevQuestionId = $r->question_id;
				}
				break;

				case 'p03':

					$sql = "
						SELECT  p.`id` AS `play_id` , p.`planet_id` , p.`score` , p.`status` , p.`target_type` , r.`id` AS `result_id` , r.`play_id` , 
						r.`question_id` ,r3.`answer` AS `result_answer`, r3.`correct` , q3.`question` ,q3.`answer` , q3.`answer_option_1`,q3.`answer_option_2` ,IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`

							FROM (`t0400_game_play` p, `t0300_game_result` r, `t0303_game_result_p03` r3 , `t0203_game_question_p03` q3  )
								LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
								LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
							
								WHERE  p.`id` IN ({$systemIds})
								AND r3.`target_id` = q3.`id`
								AND r.`target_id` = r3.`id`
								AND r.`play_id` = p.`id`
								AND p.`planet_id` =  :planet_id
								AND p.`code` = :gameCode

							ORDER BY r.`id` ASC;


					";	
				
					$result = DB::SELECT($sql ,['planet_id'=>$planetId , 'gameCode'=>$gameCode]);

					$results = [];		
					$prevPlayId = 0;

					for($i=0; $i<count($result); $i++){
						$r = $result[$i];
						if($r->play_id != $prevPlayId){
							array_push($results, [
								'id' => $r->play_id,
								'planet_id'=>$r->planet_id,
								'score'=>$r->score,
								'status'=>$r->status,
								'target_type'=>$r->target_type,
								'result'=> []
							]);
						}
						$r2 = $results[count($results)-1]['result'];

						if(!$r2 || $r->question_id != $prevQuestionId){
							array_push($results[count($results)-1]['result'], [
							'id' => $r->question_id,
							'question'=>[
								'question' => $r->question,
								'correct_answer' => $r->answer,
								'answer_option_1' => $r->answer_option_1,
								'answer_option_2' => $r->answer_option_2
								],
							'answer' => [
								'result_id' => $r->result_id,
								'correct'=> $r->correct,
								'answer'=>$r->result_answer,
								],
							'subjects' => []
							]);
						}
					array_push($results[count($results)-1]['result'][count($results[count($results)-1]['result'])-1]['subjects'] ,[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);

					$prevPlayId = $r->play_id; 
					$prevQuestionId = $r->question_id;
				}
				break;

				// case 'p04':
				// 	
				// break;

				case 'p06':

					$sql = "
						SELECT  p.`id` AS `play_id` , p.`planet_id` , p.`score` , p.`status` , p.`target_type` , r.`id` AS `result_id` , r.`play_id` , 
						r.`question_id` , r.`target_type` , r6.`answer` AS `result_answer`, r6.`correct` , q6.* , q6t.`part_1` ,q6t.`part_2`, q6t.`part_3`, q6t.`expression`  , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`

							FROM (`t0400_game_play` p, `t0300_game_result` r, `t0306_game_result_p06` r6 , `t0206_game_question_p06` q6 ,`t0206_game_question_p06_template` q6t)

								LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
								LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
								
								WHERE p.`id` IN ({$systemIds})
								AND q6t.`id` = q6.`template_id`
								AND r6.`target_id` = q6.`id`
								AND r.`target_id` = r6.`id`
								AND r.`play_id` = p.`id`
								AND p.`planet_id` =  :planet_id
								AND p.`code` = :gameCode

							ORDER BY p.`id` ASC, r.`question_id` ASC;
					";	

					$params = ['planet_id'=>$planetId , 'gameCode'=>$gameCode];
					$result = DB::SELECT($sql , $params);

					$results = [];		
					$prevPlayId = 0;
					for($i=0; $i<count($result); $i++){
						$r = $result[$i];
						if($r->play_id != $prevPlayId){
							array_push($results, [
								'id' => $r->play_id,
								'planet_id'=>$r->planet_id,
								'score'=>$r->score,
								'status'=>$r->status,
								'target_type'=>$r->target_type,
								'result'=> []
							]);
						}
					
						$part1 =  str_replace("@1", $r->tpl_param_1, $r->part_1);
						$part1 =  str_replace("@2", $r->tpl_param_2, $part1);
						$part1 =  str_replace("@3", $r->tpl_param_3, $part1);

						$part2 =  str_replace("@1", $r->tpl_param_1, $r->part_2);
						$part2 =  str_replace("@2", $r->tpl_param_2, $part2);
						$part2 =  str_replace("@3", $r->tpl_param_3, $part2);

						$part3 =  str_replace("@1", $r->tpl_param_1, $r->part_3);
						$part3 =  str_replace("@2", $r->tpl_param_2, $part3);
						$part3 =  str_replace("@3", $r->tpl_param_3, $part3);

						$expression =  str_replace("@1", $r->tpl_param_1, $r->expression);
						$expression =  str_replace("@2", $r->tpl_param_2, $expression);
						$expression =  str_replace("@3", $r->tpl_param_3, $expression);

						$r2 = $results[count($results)-1]['result'];
						
						if(!$r2 || $r->question_id != $prevQuestionId){
							array_push($results[count($results)-1]['result'], [
								'question_id' => $r->question_id,
								'question'=>[
									'param_1' => $r->game_param_1,
									'param_2' => $r->game_param_2,
									'param_3' => $r->game_param_3,
									'p1_object' => $r->game_param_4,
									'p2_object' => $r->game_param_5,
									'p3_object' => $r->game_param_6,
									'setting' => $r->game_param_7,
									'part_1' => $part1,
									'part_2' => $part2,
									'part_3' => $part3,
									'expression' => $expression,
									],
								'answer' => [
									'result_id' => $r->result_id,
									'correct'=> $r->correct,
									'answer'=>$r->result_answer,
									],
								'subjects' => []
							]);
						}


						array_push($results[count($results)-1]['result'][count($results[count($results)-1]['result'])-1]['subjects'] ,[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);

					$prevPlayId = $r->play_id; 
					$prevQuestionId = $r->question_id;
				}
				break;

				case 'p07':

					$sql = "
						SELECT  p.`id` AS `play_id` , p.`planet_id` , p.`score` , p.`status` , p.`target_type` , r.`id` AS `result_id` ,
						r.`question_id`  , r7.`answer` AS `result_answer`, r7.`correct` , q7.* , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`

							FROM (`t0400_game_play` p, `t0300_game_result` r, `t0307_game_result_p07` r7 , `t0207_game_question_p07` q7)

								LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
								LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
								
								WHERE p.`id` IN ({$systemIds})
								AND q7t.`id` = q7.`template_id`
								AND r7.`target_id` = q7.`id`
								AND r.`target_id` = r7.`id`
								AND r.`play_id` = p.`id`
								AND p.`planet_id` =  :planet_id
								AND p.`code` = :gameCode

							ORDER BY p.`id` ASC, r.`question_id` ASC;
					";	

					$params = ['planet_id'=>$planetId , 'gameCode'=>$gameCode];
					$result = DB::SELECT($sql , $params);

					$results = [];		
					$prevPlayId = 0;
					for($i=0; $i<count($result); $i++){
						$r = $result[$i];
						if($r->play_id != $prevPlayId){
							array_push($results, [
								'id' => $r->play_id,
								'planet_id'=>$r->planet_id,
								'score'=>$r->score,
								'status'=>$r->status,
								'target_type'=>$r->target_type,
								'result'=> []
							]);
						}
					
						$r2 = $results[count($results)-1]['result'];
						
						if(!$r2 || $r->question_id != $prevQuestionId){
							array_push($results[count($results)-1]['result'], [
								'question_id' => $r->question_id,
								'question'=>[
									'left_question_1'=>$r->left_question_1,
									'left_question_2'=>$r->left_question_2,
									'left_question_3'=>$r->left_question_3,
									'answer'=>$r->answer,
									'right_question_1'=>$r->right_question_1,
									'right_question_2'=>$r->right_question_2,
									'right_question_3'=>$r->right_question_3
									],
								'answer' => [
									'result_id' => $r->result_id,
									'correct'=> $r->correct,
									'answer'=>$r->result_answer,
									],
								'subjects' => []
							]);
						}


						array_push($results[count($results)-1]['result'][count($results[count($results)-1]['result'])-1]['subjects'] ,[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);

					$prevPlayId = $r->play_id; 
					$prevQuestionId = $r->question_id;
				}
				break;
		}

		return ResponseHelper::OutputJSON('success', '',[
					'results' => $results,
					'page' => $page,
					'page_size' => $pageSize, 
					'pageTotal' => ceil($total/$pageSize)
					]);

		} catch (Exception $ex) {

				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
					'source' => 'ApiGameController > systemPlanetPlay',
					'inputs' => Request::all(),
				])]);
				return ResponseHelper::OutputJSON('exception');
			}	
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

}
 