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
use App\Models\GameResultP00;
use App\Models\GameResultP01;
use App\Models\GameResultP02;
use App\Models\GameResultP03;
use App\Models\GameResultP06;
use App\Models\GameResultP07;
use App\Models\GameResultP08;
use App\Models\GameResultP09;
use App\Models\GameResultP10;
use App\Models\GameResultP18;
use App\Models\GameResultP23;
use App\Models\GameResultP32;
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
				SELECT t.`name` AS `game_type` , p.`id` ,p.`name` , p.`description` , p.`badges_metrics` , p.`question_count` , p.`enable` 
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

			if($planetId){
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
				SELECT um.`level`,um.`exp`, um.`top_score` , s.`id` AS `system_id` , s.`name` AS `system_name` , p.`id` AS `planet_id` , p.`name` AS `planet_name` , p.`description` ,CAST(IFNULL(um.`star`, 0) AS UNSIGNED) AS `star`
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

	public static function GetQuestionP01($planetId, $difficulty,$questionCount){
		try{
			
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

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

	public static function GetQuestionP02($planetId,$difficulty,$questionCount) {
		try{

			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

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

	public static function GetQuestionP03($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

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
						'image_id' => $r->image_id,
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

	public static function GetQuestionP06($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

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

	public static function GetQuestionP07($planetId,$difficulty,$questionCount){
		try{

			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

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

	public static function GetQuestionP08($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0208_game_question_p08` p08
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p08'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p08.`enable` = '1'
	                            AND p08.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;
			
			$sql2 = "
				SELECT  p08.* ,  q.`difficulty`, q.`id` AS `id`, IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description` 
					 FROM (`t0208_game_question_p08` p08 , `t0200_game_question` q)

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p08.`id` IN( {$targetIds} )
                        AND q.`target_id` = p08.`id`
                        AND q.`target_type` = 'p08'

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
						'param_1' => $r->param_1,
						'param_2' => $r->param_2,
						'param_3' => $r->param_3,
						'param_4' => $r->param_4,
						'param_5' => $r->param_5,
						'param_6' => $r->param_6,
						'param_7' => $r->param_7,
						'hexagon_path' => $r->hexagon_path,
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp08', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
				'sql' =>  $sql,
			])]);
		return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GetQuestionP09($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0209_game_question_p09` p09
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p09'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p09.`enable` = '1'
	                            AND p09.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;
			
			$sql2 = "
				SELECT  p09.* ,  q.`difficulty`, q.`id` AS `id`, IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description` 
					 FROM (`t0209_game_question_p09` p09 , `t0200_game_question` q)

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p09.`id` IN( {$targetIds} )
                        AND q.`target_id` = p09.`id`
                        AND q.`target_type` = 'p09'

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
						'param_1' => $r->question_object1,
						'param_2' => $r->question_object2,
						'param_3' => $r->question_object3,
						'param_4' => $r->question_object4,
						'param_5' => $r->question_object5,
						'answer' => $r->answer,
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp09', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
				'sql' =>  $sql,
			])]);
		return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GetQuestionP10($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0210_game_question_p10` p10
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p10'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p10.`enable` = '1'
	                            AND p10.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;
			$sql2 = "
				SELECT  p10.* ,  q.`difficulty`, q.`id` AS `id`, IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description` 
					 FROM (`t0210_game_question_p10` p10 , `t0200_game_question` q)

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p10.`id` IN( {$targetIds} )
                        AND q.`target_id` = p10.`id`
                        AND q.`target_type` = 'p10'

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
						'answer' => $r->answer,
						'option_type' => $r->option_type,
						'option_generate' => $r->option_generate,
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp10', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
				'sql' =>  $sql,
			])]);
		return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GetQuestionP18($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			

			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0218_game_question_p18` p18
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p18'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p18.`enable` = '1'
	                            AND p18.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;
			$sql2 = "
				SELECT  p18.* ,  q.`difficulty`, q.`id` AS `id`, IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description` 
					 FROM (`t0218_game_question_p18` p18 , `t0200_game_question` q)

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p18.`id` IN( {$targetIds} )
                        AND q.`target_id` = p18.`id`
                        AND q.`target_type` = 'p18'

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
						'option_from' => $r->option_from,
						'option_until_total' => $r->option_until_total,
						'answer' => $r->answer,
						'ruler_type' => $r->ruler_type,
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp18', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
				'sql' =>  $sql,
			])]);
		return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GetQuestionP23($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0223_game_question_p23` p23
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p23'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p23.`enable` = '1'
	                            AND p23.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;

			$sql2 = "
				SELECT  p23.* ,  q.`difficulty`, q.`id` AS `id`, IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description` 
					 FROM (`t0223_game_question_p23` p23 , `t0200_game_question` q)

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p23.`id` IN( {$targetIds} )
                        AND q.`target_id` = p23.`id`
                        AND q.`target_type` = 'p23'

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
						'answer' => $r->answer,
						'plane' => $r->plane,
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp23', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
				'sql' =>  $sql,
			])]);
		return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GetQuestionP32($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			$sql = "
				  SELECT GROUP_CONCAT(ran.`target_id`)  AS `ids`
						FROM (SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0232_game_question_p32` p32
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p32'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p32.`enable` = '1'
	                            AND p32.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = :difficulty
		                        AND pq.`planet_id` = :planet_id
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT :questionCount
	                    ) ran
										
			";

			$targetIds = DB::SELECT($sql, ['planet_id'=>$planetId , 'difficulty'=>$difficulty , 'questionCount' => $questionCount ])[0]->ids;

			$sql2 = "
				SELECT  p32.* ,  q.`difficulty`, q.`id` AS `id`, IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description` 
					 FROM (`t0232_game_question_p32` p32 , `t0200_game_question` q)

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p32.`id` IN( {$targetIds} )
                        AND q.`target_id` = p32.`id`
                        AND q.`target_type` = 'p32'

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
						'answer_x' => $r->answer_x,
						'answer_y' => $r->answer_y,
						'origin_x' => $r->origin_x,
						'origin_y' => $r->origin_y,
						'diff_x' => $r->diff_x,
						'diff_y' => $r->diff_y,
						'initial_x' => $r->initial_x,
						'initial_y' => $r->initial_y,
						'planet_1' => $r->planet_1,
						'planet_1_x' => $r->planet_1_x,
						'planet_1_y' => $r->planet_1_y,
						'planet_2' => $r->planet_2,
						'planet_2_x' => $r->planet_2_x,
						'planet_2_y' => $r->planet_2_y,
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp32', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
				'sql' =>  $sql,
			])]);
		return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function GetQuestionP00($planetId,$gameType,$level,$profileId){
		try{
			

			if(!$gameType){
				return 'missing game_type';
			}

			$userMap = UserMap::where('profile_id', $profileId)->where('planet_id' , $planetId)->first();

			if(!$level){
				$userMap->level = 1;
				$userMap->exp = 0;
				$userMap->save();

				$level = $userMap->level;
			}
			
			if($level == '1'){
				$easy = '25';
				$average = '15';
				$hard = '10';
			}
			if($level == '2'){
				$easy = '20';
				$average = '20';
				$hard = '10';
			
			}
			if($level == '3'){
				$easy = '15';
				$average = '25';
				$hard = '10';
			
			}
			if($level == '4'){
				$easy = '15';
				$average = '20';
				$hard = '15';
			
			}
			if($level == '5'){
				$easy = '10';
				$average = '25';
				$hard = '15';
			
			}
			if($level == '6'){
				$easy = '5';
				$average = '25';
				$hard = '20';
			
			}
			if($level == '7'){
				$easy = '5';
				$average = '20';
				$hard = '25';
			
			}
			if($level == '8'){
				$easy = '5';
				$average = '10';
				$hard = '35';
			
			}
			if($level == '9'){
				$easy = '0';
				$average = '10';
				$hard = '40';
			
			}
			if($level == '10'){
				$easy = '0';
				$average = '0';
				$hard = '50';
			
			}
		
			$sqlQuestionId = "
				  SELECT GROUP_CONCAT(a.`target_id`)  AS `ids` 
						FROM (
							SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0200_game_question_p00` p00
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p00'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p00.`enable` = '1'
	                            AND p00.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = 1
		                        AND pq.`planet_id` = {$planetId}
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT {$easy}
	                    ) a
						
						UNION

					SELECT GROUP_CONCAT(b.`target_id`)  AS `ids`
						FROM (
							SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0200_game_question_p00` p00
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p00'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p00.`enable` = '1'
	                            AND p00.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = 2
		                        AND pq.`planet_id` = {$planetId}
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT {$average}
	                    ) b

						UNION

					SELECT GROUP_CONCAT(c.`target_id`)  AS `ids`
						FROM (
							SELECT  q.`target_id` , RAND() AS `rand`
	                        FROM `t0126_game_planet_question` pq ,`t0200_game_question` q , `t0123_game_planet` gp , `t0200_game_question_p00` p00
	                            WHERE  pq.`question_id` = q.`id`
	                            AND q.`target_type`  = 'p00'
	                            AND pq.`enable` = '1'
	                            AND q.`enable` = '1'
	                            AND p00.`enable` = '1'
	                            AND p00.`id` = q.`target_id`
	                          	AND gp.`id` =  pq.`planet_id`
		                        AND q.`difficulty` = 3
		                        AND pq.`planet_id` = {$planetId}
	                       		
	                       		ORDER BY  pq.`sequence` * ABS(gp.`question_random`-1) , `rand`
	                           	LIMIT {$hard}
	                    ) c
										
			";

			$questionId = DB::SELECT($sqlQuestionId);
			$count = count($questionId);

			if(!$questionId[0]->ids){
				$targetIds = $questionId[1]->ids;
			}elseif($count == 2){
				$targetIds = $questionId[0]->ids.','.$questionId[1]->ids;
			}elseif($count == 3){
				$targetIds = $questionId[0]->ids.','.$questionId[1]->ids.','.$questionId[2]->ids;
			}
			
			$sql2 = "
				SELECT  p00.* ,  q.`difficulty`, q.`id` AS `id`, IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description` 
					 FROM (`t0200_game_question_p00` p00 , `t0200_game_question` q)

						LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` = q.`id`)
						LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
                        
                        WHERE p00.`id` IN( {$targetIds} )
                        AND q.`target_id` = p00.`id`
                        AND q.`target_type` = 'p00'

                        ORDER BY q.`id`
			";
			
			$result = DB::SELECT($sql2);
			$results = [];
			$prevQuestionId = 0;
			array_push($results , [
				'level' => $userMap->level,
				'exp' => $userMap->exp,
				'top_score' => $userMap->top_score,
				'question' => [],
			]);
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results[0]['question'], [
						'id' => $r->id,
						'question' => $r->question,
						'question_option1' => $r->question_option1,
						'question_option2' => $r->question_option2,
						'question_option3' => $r->question_option3,
						'question_option4' => $r->question_option4,
						'answer' => $r->answer,
						'difficulty' => $r->difficulty,
						'subject' => []
					]);
				}

				array_push($results[0]['question'][count($results[0]['question'])-1]['subject'],[
								'subject_code'=>$r->subject_code,
									'name' => $r->name,
									'description'=>$r->description
								]);

				$prevQuestionId = $r->id;
			}

			//opponent
			$opponent = []; 
			$gameType = $gameType - 1;
			$smallest = $level -1;
			$biggest = $level +1;

			$gamePlay = GamePlay::where('planet_id', $planetId)->where('level' , '>' , $smallest)->where('level', '<' ,$biggest)->take($gameType)->get();

			if(!$gamePlay){
				continue;
			}
			$setGenerate = $gameType - count($gamePlay);
			var_export($setGenerate); die();
			$targetId = explode(',', $targetIds);

			for($j=0; $j<$setGenerate; $j++){
				$gamePlay = new GamePlay;
				$gamePlay->user_id = 0;
				$gamePlay->profile_id = 0;
				$gamePlay->planet_id = $planetId;
				$gamePlay->target_type = 'p00';
				$gamePlay->type = 'anonymous';
				$gamePlay->score = '75200';
				$gamePlay->status = 'pass';
				$gamePlay->level = $level;
				$gamePlay->save();
				for($l=0; $l< 50; $l++){
					$rand = rand(0,1);
					$randAnswer = rand(1,4);
					$t = $targetId[$l];

					$question = GameQuestion::find($t);
					$resultP00 = new GameResultP00;
					$resultP00->correct = $rand;
					$resultP00->target_type = 'p00';
					$resultP00->target_id = $question->target_id;
					$resultP00->answer = $randAnswer;
					$resultP00->answer_option = $randAnswer;
					$resultP00->save();

					$gameResults = new GameResult;
					$gameResults->play_id = $gamePlay->id;
					$gameResults->question_id = $t;
					$gameResults->target_type = 'p00';
					$gameResults->target_id = $resultP00->id;
					$gameResults->game_type_id = '0';
					$gameResults->complete_time = '3';
					$gameResults->save();

					}
			}
			$lenght = $gameType * 2;
			$sqlPlayIds = "
				SELECT GROUP_CONCAT(`id`)  AS `ids`
					FROM `t0400_game_play`
						WHERE `planet_id` = {$planetId}
						AND `level` > {$smallest}
						AND `level` < {$biggest}

						ORDER BY `id` DESC
			";

			$playId = DB::select($sqlPlayIds);

			$playIds = $playId[0]->ids;
			$playIds = str_split($playIds , $lenght);
			$playIds = $playIds[0];

			if($gameType != 7){
				$playIds = substr_replace($playIds, "", -1);
			}
			//get opponent result
			$sqlNpcQuestion = "
				SELECT  p.`id` AS `play_id` , p.`level`, p.`score`, r00.`answer` ,r00.`answer_option`, r00.`correct`  ,r00.`difficulty`, r.`complete_time` 
					FROM `t0300_game_result_p00` r00 , `t0400_game_play` p ,`t0300_game_result` r
						WHERE r00.`id` = r.`target_id`
						AND p.`id` IN ({$playIds}) 
						AND r.`play_id` = p.`id`
						AND r.`game_type_id` = 0

						ORDER BY `play_id` DESC 

				";
				$npcQuestion = DB::select($sqlNpcQuestion);

				$prevPlayId = 0;

				for($k=0; $k<count($npcQuestion); $k++){
					$n = $npcQuestion[$k];

					if($n->play_id != $prevPlayId){
						array_push($opponent , [
							'play_id' => $n->play_id,
							'level' => $n->level,
							'score' => $n->score,
							'ghost_data' => []
							]);
					}
					array_push($opponent[count($opponent) -1 ]['ghost_data'], [
							
							'answer' => $n->answer,
							'answer_option' => $n->answer_option,
							'correct' => $n->correct,
							'complete_time' => $n->complete_time,
							'difficulty' => $n->difficulty
					]);
					$prevPlayId = $n->play_id;
				}
			shuffle($results);
			return [
					'player' => $results, 
					'opponent' => $opponent
					];

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper::GetQuestionp99', ['environment' => json_encode([
				'ex' =>  $ex->getMessage(),
			])]);
		return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function SubmitResultP00($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{	
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];

				$question = GameQuestion::find($inAnswer['question_id']);
				$resultP00 = new GameResultP00;
				$resultP00->correct = $inAnswer['correct'];
				$resultP00->target_type = 'p00';
				$resultP00->target_id = $question->target_id;
				$resultP00->answer = $inAnswer['answer'];
				$resultP00->answer_option = $inAnswer['answer_option'];
				$resultP00->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p00';
				$gameResults->target_id = $resultP00->id;
				$gameResults->game_type_id = '0';
				if(isset($inAnswer['complete_time']) ){
					$gameResults->complete_time = $inAnswer['complete_time'];
				}
			
				$gameResults->save();

				}

			} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
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

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function submitResultP08($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP08 = new GameResultP08;
				$resultP08->target_type = 'p08';
				$resultP08->target_id = $question->target_id;
				$resultP08->answer = $inAnswer['answer'];
				$resultP08->correct = $inAnswer['correct'];
				$resultP08->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p08';
				$gameResults->target_id = $resultP08->id;
				$gameResults->game_type_id = '8';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function submitResultP09($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP09 = new GameResultP09;
				$resultP09->target_type = 'p09';
				$resultP09->target_id = $question->target_id;
				$resultP09->answer = $inAnswer['answer'];
				$resultP09->correct = $inAnswer['correct'];
				$resultP09->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p09';
				$gameResults->target_id = $resultP09->id;
				$gameResults->game_type_id = '9';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function submitResultP10($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP10 = new GameResultP10;
				$resultP10->target_type = 'p10';
				$resultP10->target_id = $question->target_id;
				$resultP10->answer = $inAnswer['answer'];
				$resultP10->correct = $inAnswer['correct'];
				$resultP10->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p10';
				$gameResults->target_id = $resultP10->id;
				$gameResults->game_type_id = '10';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function submitResultP18($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP18 = new GameResultP18;
				$resultP18->target_type = 'p18';
				$resultP18->target_id = $question->target_id;
				$resultP18->answer = $inAnswer['answer'];
				$resultP18->correct = $inAnswer['correct'];
				$resultP18->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p18';
				$gameResults->target_id = $resultP18->id;
				$gameResults->game_type_id = '18';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function submitResultP23($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP18 = new GameResultP23;
				$resultP18->target_type = 'p23';
				$resultP18->target_id = $question->target_id;
				$resultP18->answer = $inAnswer['answer'];
				$resultP18->correct = $inAnswer['correct'];
				$resultP18->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p23';
				$gameResults->target_id = $resultP18->id;
				$gameResults->game_type_id = '23';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function submitResultP32($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP18 = new GameResultP32;
				$resultP18->target_type = 'p32';
				$resultP18->target_id = $question->target_id;
				$resultP18->answer_x = $inAnswer['answer_x'];
				$resultP18->answer_y = $inAnswer['answer_y'];
				$resultP18->correct = $inAnswer['correct'];
				$resultP18->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p32';
				$gameResults->target_id = $resultP18->id;
				$gameResults->game_type_id = '32';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public static function UserMap($profileId,$planetId,$gamePlay){
		$userMap = UserMap::where('profile_id', $profileId)->where('planet_id' , $planetId)->first();
			if(!$userMap){
				$userMap = new UserMap;
				$userMap->profile_id = $profileId;
				$userMap->planet_id = $planetId;
				$userMap->played = '1';
				$userMap->save();
			}

			$userMap->star += ($gamePlay->status == 'pass')?1:0;
			$userMap->star = ($userMap->star > 5)?5:$userMap->star;
			$userMap->top_score = ($userMap->top_score > $gamePlay->score)?$userMap->top_score:$gamePlay->score;
			$userMap->played = '1';
			$userMap->level =  $gamePlay->level;
			if(isset($gameResult['experience']) ){
				$userMap->exp =  $gameResult['experience'];
			}
			
			$userMap->save();		
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

