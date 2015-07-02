<?php namespace App\Libraries;

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
use App\Models\GameQuestion;
use App\Models\GameQuestionP03;
use App\Models\GameQuestionP04ChallengeSet;
use App\Models\GameSystemPlanet;
use App\Models\UserExternalId;
use App\Models\LeaderboardWorld;
use App\Models\LeaderboardSystem;
use App\Models\LeaderboardPlanet;

class ZapZapQuestionHelper{

	public static function GetPlanetInfo($planetId){
		try{
			$sql = "
				SELECT t.`name` AS `game_type` , p.`id` ,p.`name` , p.`description` , p.`badges_metrics` , p.`question_count` , p.`param` , p.`enable` 
					FROM `t0123_game_planet` p, `t0124_game_system_planet` sp, `t0122_game_system` s , `t0121_game_type` t
						WHERE sp.`system_id` = s.`id`
						AND t.id = p.`game_type_id`
						AND sp.`planet_id` = p.`id`
						AND sp.`planet_id`= :planet_id

						LIMIT 1;
			";

			$result = DB::SELECT($sql, ['planet_id' => $planetId]);
			if(!$result){ return null; }

			return $result[0];

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetPlanetInfo', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
				'sql' =>  $sql,
			])]);		
			return ResponseHelper::OutputJSON('exception');			
		}
	}

	public static function GetUserMap($profileId, $planetId = 0){
		try{
			$sqlWherePlanet = "";

			if($planetId != 0){
				$userMap = UserMap::where('profile_id', $profileId)->where('planet_id' , $planetId)->first();
				if(!$userMap){
					$userMap = new UserMap;
					$userMap->profile_id = $profileId;
					$userMap->planet_id = $planetId;
					$userMap->save();
				}	

				$sqlWherePlanet = " AND sp.`planet_id` = {$planetId} ";			
			}

			$sql = "
				SELECT um.`top_score` , s.`id` AS `system_id` , s.`name` AS `system_name` , p.`id` AS `planet_id` , p.`name` AS `planet_name` , p.`description` ,IFNULL(um.`star`, 0) AS `star`
					FROM (`t0122_game_system` s, `t0123_game_planet` p , `t0124_game_system_planet` sp) 
						LEFT JOIN `t0501_game_user_map` um 
							ON(
								um.`profile_id` = :profileId AND um.`planet_id` = p.`id`
								)
				 		WHERE  sp.`planet_id` = p.`id`
				 			AND sp.`system_id` = s.`id`
				 			AND sp.`enable` = '1'
				 			{$sqlWherePlanet}
				 			ORDER BY sp.`sequence`
				";

			$result = DB::SELECT($sql, ['profileId'=>$profileId]);
			
			return $result;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetUserMap', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
				'sql' =>  $sql,
			])]);		
			return ResponseHelper::OutputJSON('exception');			
		}
	}

	public static function GetQuestionP01($planetId, $difficulty){
		try{
			$gamePlanet = GamePlanet::find($planetId);
			$questionCount = $gamePlanet->question_count;

			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0201_game_question_p01` p01
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p01'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p01.`enable` = '1'
	                            AND p01.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;

			$sql2 = "
				SELECT p01.* , q.`difficulty` , q.`id` AS `id` , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`
                  		FROM (`t0201_game_question_p01` p01 , `t0200_game_question` q)

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p01.`id` IN( {$targetIds} )
                        AND q.`target_id` = p01.`id`
                        AND q.`target_type` = 'p01'

                        ORDER BY q.`id`
			";
			
			$result = DB::SELECT($sql2);

			$gamePlanet = GamePlanet::find($planetId);
			$questionCount = $gamePlanet->question_count;

			$results = [];

			$prevQuestionId = 0;
			
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->id,
						'question' => $r->question,
						'difficulty' => $r->difficulty,
						'questions' => [
							'angle3' => $r->question_angle3,
							'angle4' => $r->question_angle4,
							'angle5' => $r->question_angle5,
							'angle6' => $r->question_angle6,
						],
						'answers' => [
							'angle3' => $r->answer_angle3,
							'angle4' => $r->answer_angle4,
							'angle5' => $r->answer_angle5,
							'angle6' => $r->answer_angle6,
						],
						'subject' => []
					]);
				}
				array_push($results[count($results)-1]['subject'],[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);
				$prevQuestionId = $r->id;
			}
			shuffle($results);

			return $results;

		}catch(Exception $ex){
		LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp01', ['environment' => json_encode([
			'ex' =>  $ex->getMessage(),
			'sql' =>  $sql,
		])]);	
		return ResponseHelper::OutputJSON('exception');				
		}
	}

	public static function GetQuestionP02($planetId,$difficulty) {
		try{

			$gamePlanet = GamePlanet::find($planetId);
			$questionCount = $gamePlanet->question_count;

			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0202_game_question_p02` p02
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p02'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                           	AND p02.`enable` = '1'
	                            AND p02.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;

			$sql2 = "
				SELECT p02.* , q.`difficulty` , q.`id` AS `id` , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description` 
					 FROM (`t0202_game_question_p02` p02 , `t0200_game_question` q)

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p02.`id` IN( {$targetIds} )
                        AND q.`target_id` = p02.`id`
                        AND q.`target_type` = 'p02'

                        ORDER BY q.`id`
			";

			$result = DB::SELECT($sql2);

			$gamePlanet = GamePlanet::find($planetId);
			$questionCount = $gamePlanet->question_count;
			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->id,
						'question' => $r->question,
						'answer_option_1' => $r->answer_option_1,
						'answer_option_2' => $r->answer_option_2,
						'answer_option_3' => $r->answer_option_3,
						'answer_option_4' => $r->answer_option_4,
						'answer_option_5' => $r->answer_option_5,
						'answer_option_6' => $r->answer_option_6,
						'fixed_num' => $r->fixed,
						'difficulty' => $r->difficulty,
						'subject' => []
					]);
				}

				array_push($results[count($results)-1]['subject'],[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);
				$prevQuestionId = $r->id;
			}

			shuffle($results);

			return $results;

		}catch(Exception $ex){
		LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp02', ['environment' => json_encode([
			'ex' =>  $ex->getMessage(),
			'sql' =>  $sql,
		])]);
		return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GetQuestionP03($planetId,$difficulty){

		try{
			$gamePlanet = GamePlanet::find($planetId);
			$questionCount = $gamePlanet->question_count;

			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0203_game_question_p03` p03
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p03'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p03.`enable` = '1'
	                            AND p03.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;
			$sql2 = "
				SELECT  p03.* ,  q.`difficulty`, q.`id` AS `id`, IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description` 
					 FROM (`t0203_game_question_p03` p03 , `t0200_game_question` q)

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p03.`id` IN( {$targetIds} )
                        AND q.`target_id` = p03.`id`
                        AND q.`target_type` = 'p03'

                        ORDER BY q.`id`
			";

			$questionsMain = [];

			$result = DB::SELECT($sql2);

			$gamePlanet = GamePlanet::find($planetId);
			$questionCount = $gamePlanet->question_count;

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->id,
						'question' => $r->question,
						'answer' => $r->answer,
						'answer_option_1' => $r->answer_option_1,
						'answer_option_2' => $r->answer_option_2,
						'difficulty' => $r->difficulty,
						'subject' => []
					]);
				}
				array_push($results[count($results)-1]['subject'],[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);

				$prevQuestionId = $r->id;
			}

			shuffle($results);


			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp03', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
				'sql' =>  $sql,
			])]);
		return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GetQuestionP06($planetId,$difficulty){
		try{
			$gamePlanet = GamePlanet::find($planetId);
			$questionCount = $gamePlanet->question_count;

			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp, `t0206_game_question_p06` p06
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p06'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p06.`enable` = '1'
	                            AND p06.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;

			$sql2 = "
				SELECT q.`id` , p06.`template_id`, p06.`tpl_param_1` , p06.`tpl_param_2`, p06.`tpl_param_3`, p06.`game_param_1`,p06.`game_param_2`,p06.`game_param_3`,
				p06.`game_param_4`,p06.`game_param_5`,p06.`game_param_6`,p06.`game_param_7` ,p06.`answer` AS `answer_text`,template.`part_1` , template.`part_2` , 
				template.`part_3` , template.`expression` , template.`answer`,q.`difficulty` , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`

					FROM (`t0206_game_question_p06` p06 , `t0200_game_question` q, `t0206_game_question_p06_template` template) 

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p06.`id` IN( {$targetIds} )
                        AND q.`target_id` = p06.`id`
                        AND q.`target_type` = 'p06'
						AND template.`id` = p06.`template_id`

						 ORDER BY q.`id`
			";

			
			$result = DB::SELECT($sql2);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){

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

					//$answer =  str_replace("@1", $r->answer_text, '99@199');
					$answer = eval('return '.$expression.';');//COME BACK TO CHANGE AGAIN

					array_push($results, [
						'id' => $r->id,
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
						'answer' => $answer,
						'subject' => []
					]);
				}
				array_push($results[count($results)-1]['subject'],[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);

				$prevQuestionId = $r->id;

			}

			shuffle($results);

			return $results;

		}catch(Exception $ex){
		LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp06', ['environment' => json_encode([
			'ex' =>  $ex->getMessage(),
			'sql' =>  $sql,
		])]);
		return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GetQuestionP07($planetId,$difficulty){
		try{

			$gamePlanet = GamePlanet::find($planetId);
			$questionCount = $gamePlanet->question_count;

			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp, `t0207_game_question_p07` p07
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p07'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p07.`enable` = '1'
	                            AND p07.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;

			$sql2 = "
				SELECT p07.* , q.`difficulty` ,q.`id` AS `id` , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`
                     FROM (`t0207_game_question_p07` p07 , `t0200_game_question` q)
                        
                   		LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p07.`id` IN( {$targetIds} )
                        AND q.`target_id` = p07.`id`
                        AND q.`target_type` = 'p07'
                     
                      ORDER BY q.`id`
			";
			
			$result = DB::SELECT($sql2);
			$results = [];

			$prevQuestionId = 0;
			
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->id,
						'difficulty' => $r->difficulty,
						'questions' => [
							'left_question_1'=>$r->left_question_1,
							'left_question_2'=>$r->left_question_2,
							'left_question_3'=>$r->left_question_3,
							'right_question_1'=>$r->right_question_1,
							'right_question_2'=>$r->right_question_2,
							'right_question_3'=>$r->right_question_3,
						],
						'answers' => [
							'answer' => $r->answer,
						],
						'subject' => []
					]);
				}

				array_push($results[count($results)-1]['subject'],[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);
				$prevQuestionId = $r->id;
			}

			shuffle($results);

			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp07', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
				'sql' =>  $sql,
		])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function SubmitResultP01($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{	
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);
				$resultP01 = new GameResultP01;
				$resultP01->correct = $inAnswer['correct'];
				$resultP01->target_type = 'p01';
				$resultP01->target_id = $question->target_id;
				$resultP01->angle3 = $gameResult['answers'][$i]['answer']['angle3'];
				$resultP01->angle4 = $gameResult['answers'][$i]['answer']['angle4'];
				$resultP01->angle5 = $gameResult['answers'][$i]['answer']['angle5'];
				$resultP01->angle6 = $gameResult['answers'][$i]['answer']['angle6'];
				$resultP01->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p01';
				$gameResults->target_id = $resultP01->id;
				$gameResults->game_type_id = '1';
				$gameResults->save();

				
				}
				$userMap = UserMap::where('profile_id', $profileId)->where('planet_id' , $planetId)->first();
				if(!$userMap){
					$userMap = new UserMap;
					$userMap->profile_id = $profileId;
					$userMap->planet_id = $planetId;
					$userMap->save();
				}

				$userMap->star += ($gamePlay->status == 'pass')?1:0;
				$userMap->star = ($userMap->star > 5)?5:$userMap->star;
				$userMap->top_score = ($userMap->top_score > $gamePlay->score)?$userMap->top_score:$gamePlay->score;
				$userMap->save();		

			} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
			}
	}

	public static function SubmitResultP02($planetId,$gamePlay ,$gameResult,$profileId ) {
		try {
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];

				//explode answer
				$answers = array_merge(explode("," ,$gameResult['answers'][$i]['answer']), [0,0,0,0,0,0]);	

				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP02 = new GameResultP02;

				$resultP02->correct = $inAnswer['correct'];
				$resultP02->target_type = 'p02';
				$resultP02->target_id = $question->target_id;
				$resultP02->answer_1 = $answers[0];
				$resultP02->answer_2 = $answers[1];
				$resultP02->answer_3 = $answers[2];
				$resultP02->answer_4 = $answers[3];
				$resultP02->answer_5 = $answers[4];
				$resultP02->answer_6 = $answers[5];

				$resultP02->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p02';
				$gameResults->target_id = $resultP02->id;
				$gameResults->game_type_id = '2';
				$gameResults->save();
			}

			$userMap = UserMap::where('profile_id', $profileId)->where('planet_id' , $planetId)->first();
			if(!$userMap){
				$userMap = new UserMap;
				$userMap->profile_id = $profileId;
				$userMap->planet_id = $planetId;
				$userMap->save();
			}

			$userMap->star += ($gamePlay->status == 'pass')?1:0;
			$userMap->star = ($userMap->star > 5)?5:$userMap->star;
			$userMap->top_score = ($userMap->top_score > $gamePlay->score)?$userMap->top_score:$gamePlay->score;
			$userMap->save();


			} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
			}
	}

	public static function submitResultP03($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$answerCheck = GameQuestionP03::where('answer_option_1', $inAnswer['answer'])->first();

				if($answerCheck){
					$answerNo = '1';
				}else{
					$answerNo = '2';
				}

				$resultP03 = new GameResultP03;
				$resultP03->correct = $inAnswer['correct'];
				$resultP03->target_type = 'p03';
				$resultP03->target_id = $question->target_id;
				$resultP03->answer_text = $inAnswer['answer'];
				$resultP03->answer = $answerNo;
				$resultP03->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p03';
				$gameResults->target_id = $resultP03->id;
				$gameResults->game_type_id = '3';
				$gameResults->save();

			}

			$userMap = UserMap::where('profile_id', $profileId)->where('planet_id' , $planetId)->first();

			if(!$userMap){
				$userMap = new UserMap;
				$userMap->profile_id = $profileId;
				$userMap->planet_id = $planetId;
				$userMap->save();
			}

			$userMap->star += ($gamePlay->status == 'pass')?1:0;
			$userMap->star = ($userMap->star > 5)?5:$userMap->star;
			$userMap->top_score = ($userMap->top_score > $gamePlay->score)?$userMap->top_score:$gamePlay->score;
			$userMap->save();

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
			}
	}

	public static function submitResultP06($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP06 = new GameResultP06;
				$resultP06->target_type = 'p06';
				$resultP06->target_id = $question->target_id;
				$resultP06->answer = $inAnswer['answer'];
				$resultP06->correct = $inAnswer['correct'];
				$resultP06->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p06';
				$gameResults->target_id = $resultP06->id;
				$gameResults->game_type_id = '6';
				$gameResults->save();
			}	

			$userMap = UserMap::where('profile_id', $profileId)->where('planet_id' , $planetId)->first();

			if(!$userMap){
				$userMap = new UserMap;
				$userMap->profile_id = $profileId;
				$userMap->planet_id = $planetId;
				$userMap->save();
			}

			$userMap->star += ($gamePlay->status == 'pass')?1:0;
			$userMap->star = ($userMap->star > 5)?5:$userMap->star;
			$userMap->top_score = ($userMap->top_score > $gamePlay->score)?$userMap->top_score:$gamePlay->score;
			$userMap->save();

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function submitResultP07($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP07 = new GameResultP07;
				$resultP07->target_type = 'p07';
				$resultP07->target_id = $question->target_id;
				$resultP07->answer = $inAnswer['answer'];
				$resultP07->correct = $inAnswer['correct'];
				$resultP07->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p07';
				$gameResults->target_id = $resultP07->id;
				$gameResults->game_type_id = '7';
				$gameResults->save();
			}	

			$userMap = UserMap::where('profile_id', $profileId)->where('planet_id' , $planetId)->first();

			if(!$userMap){
				$userMap = new UserMap;
				$userMap->profile_id = $profileId;
				$userMap->planet_id = $planetId;
				$userMap->save();
			}

			$userMap->star += ($gamePlay->status == 'pass')?1:0;
			$userMap->star = ($userMap->star > 5)?5:$userMap->star;
			$userMap->top_score = ($userMap->top_score > $gamePlay->score)?$userMap->top_score:$gamePlay->score;
			$userMap->save();

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function LeaderboardUpdate($profile,$systemPlanet,$gameResult) {
		try{
			$leaderboardSql = '';
			$leaderboardSql1 = '';
			$leaderBoard = new LeaderboardPlanet;
			$leaderBoard->planet_id = $systemPlanet->planet_id;
			$leaderBoard->profile_id = $profile->id;
			$leaderBoard->nickname1 = $profile->nickName1->name;
			$leaderBoard->nickname2 =  $profile->nickName2->name;
			$leaderBoard->avatar =  $profile->avatar->filename;
			$leaderBoard->score = $gameResult['score'];
			$leaderBoard->save();
			$sql = "
				UPDATE `t0603_leaderboard_planet` AS l1 ,
					( SELECT `id`, FIND_IN_SET( `score`, ( SELECT GROUP_CONCAT( DISTINCT  `score` ORDER BY `score` DESC ) FROM `t0603_leaderboard_planet`
						WHERE `planet_id` = :planetid
					)) AS `set_rank` 
						FROM `t0603_leaderboard_planet`) AS l2
							SET l1.`rank` = l2.`set_rank`
							WHERE l1.`id` = l2.`id`
							AND l1.`planet_id` = :planet_id 
			";

			$param =  ['planetid' => $systemPlanet->planet_id, 'planet_id' => $systemPlanet->planet_id];
			DB::UPDATE($sql , $param);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GameScreenPlanetTopScore($planetId){
		$planetTopScore = LeaderBoardPlanet::select('nickname1' ,'nickname2' ,'avatar' ,'score')->where('planet_id' , $planetId)->orderBy('score' , 'DESC')->take(10)->get();

		if(!$planetTopScore){
			$planetTopScore = [];
		}
		return $planetTopScore;

	}

	public static function GameScreenPlayerTopScore($planetId,$profileId){

		$playerTopScore = GamePlay::where('planet_id' , $planetId)->where('profile_id',$profileId)->select('score')->orderBy('score' , 'DESC');
		return $playerTopScore;
	}
}

