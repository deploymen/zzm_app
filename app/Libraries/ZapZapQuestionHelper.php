<?php namespace App\Libraries;

use App;
use Exception;
use Config;
use Request;
use DB;
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
use App\Models\GamePlanetQuestionCache;
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
use App\Models\GameResultP11;
use App\Models\GameResultP12;
use App\Models\GameResultP13;
use App\Models\GameResultP14;
use App\Models\GameResultP15;
use App\Models\GameResultP16;
use App\Models\GameResultP17;
use App\Models\GameResultP18;
use App\Models\GameResultP19;
use App\Models\GameResultP20;
use App\Models\GameResultP21;
use App\Models\GameResultP23;
use App\Models\GameResultP32;
use App\Models\GameQuestion;
use App\Models\GameQuestionP03;
use App\Models\GameQuestionP00;
use App\Models\GameQuestionP04ChallengeSet;
use App\Models\GameSystemPlanet;
use App\Models\UserExternalId;
use App\Models\LeaderboardWorld;
use App\Models\LeaderboardSystem;
use App\Models\LeaderboardPlanet;

class ZapZapQuestionHelper{

	public static function GetPlanetInfo( $planetId){
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetPlanetInfo', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);
			return false;			
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
				 			ORDER BY s.`id`
				";

			$result = DB::SELECT($sql, ['profileId'=>$profileId]);
			return $result;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetUserMap', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
			return false;			
		}
	}

	public static function GetUserMapV11($profileId){
		try{
			
			$sql = "
				SELECT um.`level`,um.`exp`, um.`top_score` , s.`id` AS `system_id` , s.`name` AS `system_name` ,ss.`id` AS `subsystem_id` ,ss.`name`  AS `subsystem_name` , p.`id` AS `planet_id` , p.`name` AS `planet_name` , p.`description` ,CAST(IFNULL(um.`star`, 0) AS UNSIGNED) AS `star`
					FROM (`t0122_game_system` s, `t0122_game_system_sub` ss, `t0123_game_planet` p , `t0124_game_system_planet` sp ) 
						LEFT JOIN `t0501_game_user_map` um 
							ON(
								um.`profile_id` = :profileId AND um.`planet_id` = p.`id`
								)
				 		WHERE  sp.`planet_id` = p.`id`
				 			AND sp.`system_id` = s.`id`
				 			AND sp.`enable` = '1'
				 			AND sp.`subsytem_id` = ss.`id`
				 	
				 			ORDER BY sp.`system_id` , sp.`subsytem_id`
				";
				
			$result = DB::SELECT($sql, ['profileId'=>$profileId]);

			return $result;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetUserMap', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
			return false;			
		}
	}

	public static function GetUserMapPersonal($profileId, $planetId){

		$userMap = UserMap::where('profile_id', $profileId)->where('planet_id' , $planetId)->first();	
		if(!$userMap){
			$userMap = new UserMap;
			$userMap->profile_id = $profileId;
			$userMap->planet_id = $planetId;
			$userMap->star = 0;
			$userMap->top_score = 0;
			$userMap->level = 0;
			$userMap->exp = 0;
			$userMap->save();
		}

		return $userMap;
	}

	public static function GetQuestionP01($planetId, $difficulty, $questionCount , $language){
		try{

			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			switch($language){
				case 'en': $languageTable = '`t0201_game_question_p01_en`'; break;
				case 'my': $languageTable = '`t0201_game_question_p01_my`'; break;
			}
			$sql = "
				SELECT l.`question`,p01.`difficulty`, p01.`question_angle3`,p01.`question_angle4`,p01.`question_angle5`,p01.`question_angle6`,p01.`answer_angle3`, p01.`answer_angle4`,p01.`answer_angle5`,p01.`answer_angle6`,qc.`question_id`
					FROM `t0201_game_question_p01` p01, {$languageTable} l,  `t0126_game_planet_question_cache` qc 
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p01.`id` = qc.`target_id`
                        	AND l.`question_id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";
			
			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;
			
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				array_push($results, [
					'id' => $r->question_id,
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
					
				]);
				
			}
			shuffle($results);
			if(!$results){
				return 'question not found';
			}
			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.','.$language.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp01', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
			return false;				
		}
	}

	public static function GetQuestionP02($planetId, $difficulty, $questionCount){
		try{

			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p02.*, qc.`question_id`
					FROM `t0202_game_question_p02` p02, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p02.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'question' => $r->question,
						'answer_option_1' => $r->answer_option_1,
						'answer_option_2' => $r->answer_option_2,
						'answer_option_3' => $r->answer_option_3,
						'answer_option_4' => $r->answer_option_4,
						'answer_option_5' => $r->answer_option_5,
						'answer_option_6' => $r->answer_option_6,
						'fixed_num' => $r->fixed,
						'difficulty' => $r->difficulty,
						
					]);
				}

				
				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}
			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp02', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP03($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p03.*, qc.`question_id` , obj.`question_object_1`,obj.`question_object_2` , obj.`question_type`
					FROM (`t0203_game_question_p03` p03, `t0126_game_planet_question_cache` qc)
						LEFT JOIN `t0203_game_question_p03_object` obj ON (obj.`question_id` = p03.`id` )
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p03.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";
			
			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'question' => $r->question,
						'question_type' => $r->question_type,
						'question_object_1' => $r->question_object_1,
						'question_object_2' => $r->question_object_2,
						'answer' => $r->answer,
						'answer_option_1' => $r->answer_option_1,
						'answer_option_2' => $r->answer_option_2,
						'image_id' => $r->image_id,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);
			if(!$results){
				return 'question not found';
			}
			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
				LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp03', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP06($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p06.*, t.`part_1`, t.`part_2`, t.`part_3`, t.`expression`,  t.`answer`,  qc.`question_id`
					FROM `t0206_game_question_p06` p06, `t0206_game_question_p06_template` t, `t0126_game_planet_question_cache` qc 
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p06.`id` = qc.`target_id`
                        	AND p06.`template_id` = t.`id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";

			$result = DB::SELECT($sql);

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
						'id' => $r->question_id,
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
						
					]);
				}
				

				$prevQuestionId = $r->id;

			}

			shuffle($results);
			if(!$results){
				return 'question not found';
			}
			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp06', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP07($planetId,$difficulty,$questionCount){
		try{

			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			$sql = "
				SELECT p07.*, qc.`question_id`
					FROM `t0207_game_question_p07` p07, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p07.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";
			
			$result = DB::SELECT($sql);
			$results = [];
			$prevQuestionId = 0;
			
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
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
						
					]);
				}

				
				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp07', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
			return false;
		}
	}

	public static function GetQuestionP08($planetId,$difficulty,$questionCount){
		try{

			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p08.*, qc.`question_id`
					FROM `t0208_game_question_p08` p08, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p08.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";

			$result = DB::SELECT($sql);
			
			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];
			
				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'param_1' => $r->param_1,
						'param_2' => $r->param_2,
						'param_3' => $r->param_3,
						'param_4' => $r->param_4,
						'param_5' => $r->param_5,
						'param_6' => $r->param_6,
						'param_7' => $r->param_7,
						'hexagon_path' => $r->hexagon_path,
						'difficulty' => $r->difficulty,
						
					]);
				}

				$prevQuestionId = $r->id;
			}
			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
				LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp08', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP09($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p09.*, qc.`question_id`
					FROM `t0209_game_question_p09` p09, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p09.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";
			$result = DB::SELECT($sql);
			

			$gamePlanet = GamePlanet::find($planetId);
			$questionCount = $gamePlanet->question_count;

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'param_1' => $r->question_object1,
						'param_2' => $r->question_object2,
						'param_3' => $r->question_object3,
						'param_4' => $r->question_object4,
						'param_5' => $r->question_object5,
						'answer' => $r->answer,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}
			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp09', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP10($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p10.*, qc.`question_id`
					FROM `t0210_game_question_p10` p10, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p10.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";
			$result = DB::SELECT($sql);
			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'question' => $r->question,
						'answer' => $r->answer,
						'option_type' => $r->option_type,
						'option_generate' => $r->option_generate,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp10', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP11($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p11.*, qc.`question_id`
					FROM `t0211_game_question_p11` p11, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p11.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";
			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'patty' => $r->patty,
						'greens' => $r->greens,
						'cheese' => $r->cheese,
						'preset_patty' => $r->preset_patty,
						'preset_greens' => $r->preset_greens,
						'preset_cheese' => $r->preset_cheese,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp11', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP12($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p12.*, qc.`question_id`
					FROM `t0212_game_question_p12` p12, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p12.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";			

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'question' => $r->question,
						'option1' => $r->option1,
						'option1_num' => $r->option1_num,
						'option2' => $r->option2,
						'option2_num' => $r->option2_num,
						'option3' => $r->option3,
						'option3_num' => $r->option3_num,
						'option4' => $r->option4,
						'option4_num' => $r->option4_num,
						'prefix1' => $r->prefix1,
						'prefix2' => $r->prefix2,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp12', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP13($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p13.*, qc.`question_id`
					FROM `t0213_game_question_p13` p13, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p13.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'answer' => $r->answer,
						'c1' => $r->c1 ,
						'c1u' => $r->c1u ,
						'c1d' => $r->c1d ,
						'c1au' => $r->c1au ,
						'c1ad' => $r->c1ad ,
						'c2' => $r->c2 ,
						'c2u' => $r->c2u ,
						'c2d' => $r->c2d ,
						'c2au' => $r->c2au ,
						'c2ad' => $r->c2ad ,
						'c3' => $r->c3 ,
						'c3u' => $r->c3u ,
						'c3d' => $r->c3d ,
						'c3au' => $r->c3au ,
						'c3ad' => $r->c3ad ,
						'c4' => $r->c4 ,
						'c4u' => $r->c4u ,
						'c4d' => $r->c4d ,
						'c4au' => $r->c4au ,
						'c4ad' => $r->c4ad ,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp13', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP14($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			$sql = "
				SELECT p14.*, qc.`question_id`
					FROM `t0214_game_question_p14` p14, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p14.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";			

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];


				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'answer' => $r->answer,
						'op' => $r->operator,
						'number1' => $r->number1,
						'number1_multiplier' => $r->number1_multiplier,
						'number2' => $r->number2,
						'number2_multiplier' => $r->number2_multiplier,
						'number3' => $r->number3,
						'number3_multiplier' => $r->number3_multiplier,
						'answer_option_1' => $r->answer_option_1,
						'answer_option_2' => $r->answer_option_2,
						'answer_option_3' => $r->answer_option_3,
						'answer_option_4' => $r->answer_option_4,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);
			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp14', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP15($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			$sql = "
				SELECT p15.*, qc.`question_id`
					FROM `t0215_game_question_p15` p15, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p15.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";			

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;
			
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];


				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'question' => $r->question,
						'option_hour' => $r->option_hour,
						'option_minute' => $r->option_minute,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);
			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp15', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP16($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			$sql = "
				SELECT p16.*, qc.`question_id`
					FROM `t0216_game_question_p16` p16, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p16.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";			

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;
			
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'answer' => $r->answer,
						'option_rows' => $r->option_rows,
						'option_columns' => $r->option_columns,
						'option_boxes' => $r->option_boxes,
						'option_product' => $r->option_product,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);
			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp16', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP17($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			$sql = "
				SELECT p17.*, qc.`question_id`
					FROM `t0217_game_question_p17` p17, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p17.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";			

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;
			
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'color_1' => $r->color_1,
						'number_1' => $r->number_1,
						'color_2' => $r->color_2,
						'number_2' => $r->number_2,
						'color_3' => $r->color_3,
						'number_3' => $r->number_3,
						'color_4' => $r->color_4,
						'number_4' => $r->number_4,
						'color_5' => $r->color_5,
						'number_5' => $r->number_5,
						'color_6' => $r->color_6,
						'number_6' => $r->number_6,
						'fake_color_1' => $r->fake_color_1,
						'fake_number_1' => $r->fake_number_2,
						'fake_color_2' => $r->fake_color_2,
						'fake_number_2' => $r->fake_number_2,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);
			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp17', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP18($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			
			$sql = "
				SELECT p18.*, qc.`question_id`
					FROM `t0218_game_question_p18` p18, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p18.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'question' => $r->question,
						'option_from' => $r->option_from,
						'option_until_total' => $r->option_until_total,
						'answer' => $r->answer,
						'ruler_type' => $r->ruler_type,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp18', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP19($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
			
			$sql = "
				SELECT p19.*, qc.`question_id`
					FROM `t0219_game_question_p19` p19, `t0126_game_planet_question_cache` qc 
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p19.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			$priceListSql = "
				SELECT `item_name` , `item_price`
					FROM `t0219_game_question_p19_price_list`
						WHERE `difficulty` = {$difficulty}
			";

			$priceList = DB::SELECT($priceListSql);


			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'essential_item_1' => $r->essential_item_1,
						'item_number_1' => $r->item_number_1,
						'essential_item_2' => $r->essential_item_2,
						'item_number_2' => $r->item_number_2,
						'essential_item_3' => $r->essential_item_3,
						'item_number_3' => $r->item_number_3,
						'essential_item_4' => $r->essential_item_4,
						'item_number_4' => $r->item_number_4,
						'budget' => $r->budget,
						'difficulty' => $r->difficulty,
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')',  ['question' =>$results , 'price_list' => $priceList] , $expiresAt);
		
			return ['question' =>$results , 'price_list' => $priceList];

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp19', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP20($planetId,$difficulty,$questionCount){

		try{

			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
		
			$sql = "
				SELECT p20.*, qc.`question_id`
					FROM `t0220_game_question_p20` p20, `t0126_game_planet_question_cache` qc 
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p20.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'question' => $r->question,
						'option_coin' => $r->option_coin,
						'option_bill' => $r->option_bill,
						'difficulty' => $r->difficulty,
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
		
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp20', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}	

	public static function GetQuestionP21($planetId,$difficulty,$questionCount){

		try{

			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}
		
			$sql = "
				SELECT p21.*, qc.`question_id`
					FROM `t0221_game_question_p21` p21, `t0126_game_planet_question_cache` qc 
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p21.`id` = qc.`target_id`	


                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'question' => $r->question,
						'param_time' => $r->param_time,
						'param_minimum' => $r->param_minimum,
						'param_lazy' => $r->param_lazy,
						'param_low' => $r->param_low,
						'param_very_low' => $r->param_very_low,
						'param_peak' => $r->param_peak,
						'param_over' => $r->param_over,
						'param_increase_rate' => $r->param_increase_rate,
						'param_decrease_rate' => $r->param_decrease_rate,
						'difficulty' => $r->difficulty,
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
		
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp21', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP23($planetId,$difficulty,$questionCount){

		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p23.*, qc.`question_id`
					FROM `t0223_game_question_p23` p23, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p23.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";

			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
						'question' => $r->question,
						'answer' => $r->answer,
						'plane' => $r->plane,
						'difficulty' => $r->difficulty,
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}

			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp23', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
		}
	}

	public static function GetQuestionP32($planetId,$difficulty,$questionCount){
		try{
			if(!$questionCount){
				$gamePlanet = GamePlanet::find($planetId);
				$questionCount = $gamePlanet->question_count;
			}

			$sql = "
				SELECT p32.*, qc.`question_id`
					FROM `t0232_game_question_p32` p32, `t0126_game_planet_question_cache` qc
                        WHERE qc.`planet_id` = {$planetId}
                        	AND qc.`difficulty` = {$difficulty}
                        	AND p32.`id` = qc.`target_id`

                        	ORDER BY RAND() 
                        	LIMIT {$questionCount}
			";
			$result = DB::SELECT($sql);

			$results = [];
			$prevQuestionId = 0;

			for($i=0; $i<count($result); $i++){
				$r = $result[$i];

				if($r->id != $prevQuestionId){
					array_push($results, [
						'id' => $r->question_id,
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
						
					]);
				}
				

				$prevQuestionId = $r->id;
			}
			shuffle($results);

			if(!$results){
				return 'question not found';
			}

			$expiresAt = Carbon::now()->addMinutes(5);
			Cache::put('ApiGameController@request('.$planetId.','.$difficulty.')', $results , $expiresAt);
			return $results;

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp32', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
		return false;
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
		
			$sql = "
				SELECT p00.* , qc.`question_id`
					FROM `t0200_game_question_p00` p00, (    
						SELECT * 
						    	FROM (
						    		SELECT  `target_id` , `question_id` 
										FROM `t0126_game_planet_question_cache`
										    WHERE `difficulty` = 1
										    AND `planet_id` = 228

										   	LIMIT 25
									)a
							
							UNION

							SELECT * 
						    	FROM (
									SELECT  `target_id` , `question_id` 
								        FROM `t0126_game_planet_question_cache`
								            WHERE `difficulty` = 2
								            AND `planet_id` = 228

								           	LIMIT 15
									 )b

						  
							UNION
							SELECT * 
						    	FROM (
									SELECT  `target_id` , `question_id` 
								        FROM `t0126_game_planet_question_cache`
								            WHERE `difficulty` = 3
								            AND `planet_id` = 228

								           	LIMIT 10			 
								     )c 
    					) qc
			         	WHERE p00.`id` = qc.`target_id`

                        ORDER BY RAND() 			
			";

			$result = DB::SELECT($sql);

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
						'id' => $r->question_id,
						'question' => $r->question,
						'question_option1' => $r->question_option1,
						'question_option2' => $r->question_option2,
						'question_option3' => $r->question_option3,
						'question_option4' => $r->question_option4,
						'answer' => $r->answer,
						'difficulty' => $r->difficulty,
						
					]);
				}

				$prevQuestionId = $r->id;
			}

			//opponent
			$opponent = []; 
			$gameType = $gameType - 1;
			$smallest = $level -1;
			$biggest = $level +1;

			$gamePlay = GamePlay::where('planet_id', $planetId)->where('level' , '>=' , $smallest)->where('level', '<=' ,$biggest)->where('status', 'pass')->take($gameType)->get();

			if(!$gamePlay){
				continue;
			}

			$setGenerate = $gameType - count($gamePlay);
	
			for($j=0; $j<$setGenerate; $j++){
				$preVal = 0;

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
					$t = $result[$l]->id;
					$question = GameQuestionP00::find($t);

					$time = rand(0, 1000) / 1000;
					$val = (2 * $time + 2);

					$resultP00 = new GameResultP00;
					$resultP00->correct = $rand;
					$resultP00->target_type = 'p00';
					$resultP00->target_id = $t;
					$resultP00->answer = $randAnswer;
					$resultP00->answer_option = $randAnswer;
					$resultP00->difficulty = $question->difficulty;
					$resultP00->answer_at = $val + $preVal;
					$resultP00->answer_use = $val;
					$resultP00->save();

					$preVal = $val + $preVal;

					$gameResults = new GameResult;
					$gameResults->play_id = $gamePlay->id;
					$gameResults->question_id = $t;
					$gameResults->target_type = 'p00';
					$gameResults->target_id = $resultP00->id;
					$gameResults->game_type_id = '0';
					$gameResults->save();

					}
			}

			$sqlPlayIds = "
				SELECT `id`
					FROM `t0400_game_play`
						WHERE `planet_id` = {$planetId}
						AND `level` >= {$smallest}
						AND `level` <= {$biggest}
						AND `status` = 'pass'

						ORDER BY `id` DESC
						LIMIT {$gameType}
			";
			$playId = DB::select($sqlPlayIds);

			$pi = [];
			for($o=0; $o<count($playId); $o++){
				array_push($pi , $playId[$o]->id);
				shuffle($pi);
			}
			$playIds = implode(",", $pi);	

			//get opponent result
			$sqlNpcQuestion = "
				SELECT  p.`id` AS `play_id` , p.`level`, p.`score`, r00.`answer` ,r00.`answer_option`, r00.`correct`  ,r00.`difficulty`, r00.`answer_at` 
					FROM `t0300_game_result_p00` r00 , `t0400_game_play` p ,`t0300_game_result` r
						WHERE r00.`id` = r.`target_id`
						AND p.`id` IN ({$playIds}) 
						AND r.`play_id` = p.`id`
						AND r.`game_type_id` = 0
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
							'complete_time' => $n->answer_at,
							'difficulty' => $n->difficulty
					]);
					$prevPlayId = $n->play_id;
				}
				
			shuffle($results[0]['question']);
			return [
					'player' => $results, 
					'opponent' => $opponent
					];

		}catch(Exception $ex){
			LogHelper::LogToDatabase('ZapZapQuestionHelper@GetQuestionp00', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
			return false;
		}
	}

	public static function SubmitResultP00($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{	
				$preUse = 0;
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];

				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP00 = new GameResultP00;
				$resultP00->correct = $inAnswer['correct'];
				$resultP00->target_type = 'p00';
				$resultP00->target_id = $question->target_id;
				$resultP00->answer = $inAnswer['answer'];
				$resultP00->answer_option = $inAnswer['answer_option'];
				$resultP00->difficulty = 1;
				$resultP00->answer_at = $inAnswer['complete_time'];
				$resultP00->answer_use = $inAnswer['complete_time'] - $preUse;
				$resultP00->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p00';
				$gameResults->target_id = $resultP00->id;
				$gameResults->game_type_id = '0';
				$gameResults->save();

				$preUse = $inAnswer['complete_time'];

				}

			} catch (Exception $ex) {
				LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP00', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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
				$resultP01->angle3 = $inAnswer['answer']['angle3'];
				$resultP01->angle4 = $inAnswer['answer']['angle4'];
				$resultP01->angle5 = $inAnswer['answer']['angle5'];
				$resultP01->angle6 = $inAnswer['answer']['angle6'];
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
				LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP01', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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
				LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP02', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP03', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'inputs' => Request::all(),
				]),
			]);		
			return false;
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP06', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP07', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP08', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP09', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP10', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP11($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP11 = new GameResultP11;
				$resultP11->target_type = 'p11';
				$resultP11->target_id = $question->target_id;
				$resultP11->patty = $inAnswer['answer']['patty'];
				$resultP11->green = $inAnswer['answer']['green'];
				$resultP11->cheese = $inAnswer['answer']['cheese'];
				$resultP11->correct = $inAnswer['correct'];
				$resultP11->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p11';
				$gameResults->target_id = $resultP11->id;
				$gameResults->game_type_id = '11';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP11', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP12($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP12 = new GameResultP12;
				$resultP12->target_type = 'p12';
				$resultP12->target_id = $question->target_id;
				$resultP12->answer = $inAnswer['answer'];
				$resultP12->correct = $inAnswer['correct'];
				$resultP12->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p12';
				$gameResults->target_id = $resultP12->id;
				$gameResults->game_type_id = '12';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP12', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP13($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP13 = new GameResultP13;
				$resultP13->target_type = 'p13';
				$resultP13->target_id = $question->target_id;
				$resultP13->answer = $inAnswer['answer'];
				$resultP13->correct = $inAnswer['correct'];
				$resultP13->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p13';
				$gameResults->target_id = $resultP13->id;
				$gameResults->game_type_id = '13';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP13', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP14($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP14 = new GameResultP14;
				$resultP14->target_type = 'p14';
				$resultP14->target_id = $question->target_id;
				$resultP14->answer = $inAnswer['answer'];
				$resultP14->correct = $inAnswer['correct'];
				$resultP14->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p14';
				$gameResults->target_id = $resultP14->id;
				$gameResults->game_type_id = '14';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP14', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP15($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP15 = new GameResultP15;
				$resultP15->target_type = 'p15';
				$resultP15->target_id = $question->target_id;
				$resultP15->answer = $inAnswer['answer'];
				$resultP15->correct = $inAnswer['correct'];
				$resultP15->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p15';
				$gameResults->target_id = $resultP15->id;
				$gameResults->game_type_id = '15';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP15', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP16($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP16 = new GameResultP16;
				$resultP16->target_type = 'p16';
				$resultP16->target_id = $question->target_id;
				$resultP16->answer = $inAnswer['answer'];
				$resultP16->correct = $inAnswer['correct'];
				$resultP16->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p16';
				$gameResults->target_id = $resultP16->id;
				$gameResults->game_type_id = '16';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP16', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP17($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP17 = new GameResultP17;
				$resultP17->target_type = 'p17';
				$resultP17->target_id = $question->target_id;
				$resultP17->answer = $inAnswer['answer'];
				$resultP17->correct = $inAnswer['correct'];
				$resultP17->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p17';
				$gameResults->target_id = $resultP17->id;
				$gameResults->game_type_id = '17';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP17', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP18', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP19($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP19 = new GameResultP19;
				$resultP19->target_type = 'p19';
				$resultP19->target_id = $question->target_id;
				$resultP19->answer = $inAnswer['answer'];
				$resultP19->correct = $inAnswer['correct'];
				$resultP19->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p19';
				$gameResults->target_id = $resultP19->id;
				$gameResults->game_type_id = '19';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP19', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP20($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP20 = new GameResultP20;
				$resultP20->target_type = 'p20';
				$resultP20->target_id = $question->target_id;
				$resultP20->answer = $inAnswer['answer'];
				$resultP20->correct = $inAnswer['correct'];
				$resultP20->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p20';
				$gameResults->target_id = $resultP20->id;
				$gameResults->game_type_id = '20';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP20', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP21($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP21 = new GameResultP21;
				$resultP21->target_type = 'p21';
				$resultP21->target_id = $question->target_id;
				$resultP21->answer = $inAnswer['answer'];
				$resultP21->correct = $inAnswer['correct'];
				$resultP21->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p21';
				$gameResults->target_id = $resultP21->id;
				$gameResults->game_type_id = '21';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP21', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function submitResultP22($planetId,$gamePlay ,$gameResult,$profileId ) {
		try{
			for($i=0; $i<count($gameResult['answers']); $i++){
				$inAnswer = $gameResult['answers'][$i];
				$question = GameQuestion::find($inAnswer['question_id']);

				$resultP22 = new GameResultP22;
				$resultP22->target_type = 'p22';
				$resultP22->target_id = $question->target_id;
				$resultP22->answer = $inAnswer['answer'];
				$resultP22->correct = $inAnswer['correct'];
				$resultP22->save();

				$gameResults = new GameResult;
				$gameResults->play_id = $gamePlay->id;
				$gameResults->question_id = $inAnswer['question_id'];
				$gameResults->target_type = 'p22';
				$gameResults->target_id = $resultP22->id;
				$gameResults->game_type_id = '22';
				$gameResults->save();
			}	

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP22', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP23', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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
			LogHelper::LogToDatabase('ZapZapQuestionHelper@SubmitResultP32', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
		}
	}

	public static function UserMap($profileId,$planetId,$gamePlay,$gameResult){
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
					( SELECT `id`, FIND_IN_SET( `score`, (
						 SELECT GROUP_CONCAT( DISTINCT  `score` ORDER BY `score` DESC ) FROM `t0603_leaderboard_planet`
							WHERE `planet_id` = :planetid
							)
					) AS `set_rank` 
						FROM `t0603_leaderboard_planet`
							WHERE `planet_id` = :planetid2
							) AS l2
								SET l1.`rank` = l2.`set_rank`
								WHERE l1.`id` = l2.`id`
								AND l1.`planet_id` = :planet_id 
			";

			$param =  ['planetid' => $systemPlanet->planet_id, 'planet_id' => $systemPlanet->planet_id , 'planetid2' => $systemPlanet->planet_id ];
			DB::UPDATE($sql , $param);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase('ZapZapQuestionHelper@LeaderboardUpdate', [
					'environment' => json_encode([
						'message' => $ex->getMessage(),
						'inputs' => Request::all(),
					]),
				]);		
				return false;
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

