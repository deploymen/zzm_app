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
use App\Models\GameSystemPlanet;
use App\Models\UserExternalId;
use App\Models\LeaderboardWorld;
use App\Models\LeaderboardSystem;
use App\Models\LeaderboardPlanet;
use App\Models\LastSession;

class ZapZapQuestionHelper{

	public static function UserMapV1_0($profileId, $planetId, $gamePlay, $gameResult){
		$userMap = UserMap::where('profile_id', $profileId)->where('planet_id', $planetId)->first();
		if(!$userMap){
			$userMap = new UserMap;
			$userMap->profile_id = $profileId;
			$userMap->planet_id = $planetId;
			$userMap->played = '1';
			$userMap->save();
		}
		$userMap->star += (in_array($userMap->star, range(0, 4)) && $gamePlay->status == 'pass')?1:0;
		$userMap->top_score = max($userMap->top_score, $gamePlay->score);
		$userMap->played = '1';
		$userMap->level =  $gamePlay->level;
		if(isset($gameResult['experience']) ){
			$userMap->exp =  $gameResult['experience'];
		}
		
		$userMap->save();		
	}

	public static function UserMapV1_1($profileId,$planetId,$gamePlay,$gameResult , $difficulty){
		$userMap = UserMap::where('profile_id', $profileId)->where('planet_id' , $planetId)->first();
		if(!$userMap){
			$userMap = new UserMap;
			$userMap->profile_id = $profileId;
			$userMap->planet_id = $planetId;
			$userMap->played = '1';
			$userMap->save();
		}

		$userMap->star += (in_array($userMap->star, range(0, 4)) && ($difficulty > $userMap->star) && ($gamePlay->status == 'pass'))?1:0;			
		$userMap->top_score = max($userMap->top_score, $gamePlay->score);
		$userMap->played = '1';
		$userMap->level =  $gamePlay->level;
		if(isset($gameResult['experience']) ){
			$userMap->exp =  $gameResult['experience'];
		}
		
		$userMap->save();		
	}

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

	public static function GetUserMapV1_0($profileId, $planetId = 0){
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


	public static function GetUserMapV1_1($profileId){
		try{
			
			$sql = "
				SELECT um.`level`,um.`exp`, um.`top_score` , s.`id` AS `system_id` , s.`name` AS `system_name` ,ss.`id` AS `subsystem_id` ,ss.`name`  AS `subsystem_name` , p.`id` AS `planet_id` , p.`name` AS `planet_name` , p.`description` ,CAST(IFNULL(um.`star`, 0) AS UNSIGNED) AS `star`
					FROM (`t0122_game_system_1` s, `t0122_game_system_sub` ss, `t0123_game_planet` p , `t0124_game_system_planet_1` sp ) 
						LEFT JOIN `t0501_game_user_map` um 
							ON(
								um.`profile_id` = :profileId AND um.`planet_id` = p.`id`
								)
				 		WHERE  sp.`planet_id` = p.`id`
				 			AND sp.`system_id` = s.`id`
				 			AND sp.`enable` = '1'
				 			AND sp.`subsystem_id` = ss.`id`
				 			
				 	
				 			ORDER BY sp.`system_id` , sp.`subsystem_id` , sp.`sequence`
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

	public static function GetUserMapV1_2($profileId){
		try{
			$profile = GameProfile::find($profileId);
			$userType = '';

			$sql = "
				SELECT um.`level`,um.`exp`, um.`top_score` , sp.`system_id` , s.`name` AS `system_name` ,sp.`subsystem_id` ,ss.`name`  AS `subsystem_name` , sp.`planet_id` , p.`name` AS `planet_name` , p.`description` ,CAST(IFNULL(um.`star`, 0) AS UNSIGNED) AS `star` , sp.`user_type` , sp.`enable`
					FROM `t0124_game_system_planet` sp
                     	LEFT JOIN `t0122_game_system_sub` ss ON sp.`subsystem_id` = ss.`id`
                    	LEFT JOIN `t0123_game_planet` p ON sp.`planet_id` = p.`id`
						LEFT JOIN `t0501_game_user_map` um ON um.`profile_id` = :profileId AND um.`planet_id` = p.`id`
						LEFT JOIN `t0122_game_system` s ON sp.`system_id` = s.`id`
				 		
				 			ORDER BY sp.`system_id` , sp.`subsystem_id` , sp.`sequence`
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

	public static function LastSession($userId , $profileId , $gameResult , $playedTime){
		$lastSession = LastSession::where('profile_id' , $profileId)->orderBy('updated_at', 'DESC')->first();
		$now = date('Y-m-d H:i:s',strtotime("-10 minute"));
		$today = date("Y-m-d H:i:s");
		
		$correct = 0;
		for($i=0; $i<count($gameResult['answers']); $i++){
			$inAnswer = $gameResult['answers'][$i];
			
			if($inAnswer['correct']){
				$correct = $correct+1;
			}
		}	

		if($lastSession){
			if($lastSession->updated_at > $now){
				$lastSession->total_played_time = $lastSession->total_played_time + $playedTime;
				$lastSession->total_correct = $lastSession->total_correct + $correct;
				$lastSession->total_answered = $lastSession->total_answered + count($gameResult['answers']);

				$accuracy = (($lastSession->total_correct / $lastSession->total_answered) * 100);
				$lastSession->accuracy = $accuracy;
				$lastSession->updated_at = $today;
				$lastSession->save();

				return;
			}
		}

		$newLastSession = new LastSession;
		$newLastSession->user_id = 
		$newLastSession->profile_id = $profileId;
		$newLastSession->total_played_time = $playedTime;
		$newLastSession->total_correct = $correct;
		$newLastSession->total_answered = count($gameResult['answers']);

		$accuracy = (($newLastSession->total_correct / $newLastSession->total_answered) * 100);
		$newLastSession->accuracy = $accuracy;
		$newLastSession->updated_at = $today;
		$newLastSession->save();
		
	}

}

