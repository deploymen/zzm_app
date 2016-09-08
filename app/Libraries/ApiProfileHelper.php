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
use App\Libraries\ApiProfileHelper;


use App\Models;
use App\Models\GameProfile;
use App\Models\GamePlay;
use App\Models\GameCode;
use App\Models\GameClass;
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
use App\Models\IdCounter;
use App\Models\LastSession;

class ApiProfileHelper{

	public static function ProfileBestScore($p, $scoreType){
		try{

			if($scoreType == 'best_score'){
				$orderBy1 = 'ORDER BY `score`DESC , `created_at` DESC';
				$orderBy2 = 'GROUP by `system_id` ORDER BY `score` DESC';
			}else{
				$orderBy1 = 'ORDER BY `score` ASC , `created_at` DESC';
				$orderBy2 = 'GROUP by `system_id` ORDER BY `score` ASC';
			}

			$sql = "
	 			SELECT * 
					FROM (
				        	SELECT p.`profile_id`,s.`name`,p.`planet_id`,pl.`description`,  p.`score` ,p.`status` , p.`id` AS `play_id`, s.`id` AS `system_id`, p.`created_at`
				                FROM `t0400_game_play` p , `t0123_game_planet` pl , `t0124_game_system_planet` sp , `t0122_game_system` s 
				                    WHERE pl.`id` = p.`planet_id` 
				                    AND s.`id` = sp.`system_id` 
				                    AND sp.`planet_id` = p.`planet_id` 
				                    AND p.`profile_id`= :profileId
				  					{$orderBy1}

				        	) t 	
				    	{$orderBy2}
				    	LIMIT 3
	 		";
	 		$result = DB::SELECT($sql , ["profileId" =>$p->id] );

	 		return $result;
				
		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > get',
		 		'inputs' => Request::all(),
		 	])]);
		 	return ResponseHelper::OutputJSON('exception');
		 }	
	}

	public static function GetProfile($userId , $classId){
		$profileInfo = [];

		if($classId){
			$profiles = GameProfile::select('id', 'user_id', 'class_id', 'first_name', 'last_name', 'age', 'school', 'grade', 'city', 'email', 'nickname1', 'nickname2', 'avatar_id')->where('class_id', $classId)->orderBy('id')->get();
			$query = 'AND profile.`class_id` = '.$classId;
		}else{
			$profiles = GameProfile::select('id', 'user_id', 'class_id', 'first_name', 'last_name', 'age', 'school', 'grade', 'city', 'email', 'nickname1', 'nickname2', 'avatar_id')->where('user_id', $userId)->orderBy('id')->get();
			$query = 'AND profile.`user_id` = '.$userId;
	
		}

		foreach ($profiles as $profile) {
			$profile->nickName1;
			$profile->nickName2;
			$profile->avatar;
			$profile->gameCode;
		}

		$sql = "
			 SELECT t1.* , t3.`total_played` 
			 	FROM (
			 		SELECT profile.`id` AS `profile_id` , play.`created_at` ,play.`score` , play.`planet_id` , play.`played_time` AS `last_played_time` , IF(profile.`expired_at` > NOW()  , 1, 0) AS `paid`
			    		FROM `t0111_game_profile` profile
							LEFT JOIN `t0400_game_play` play ON (play.`profile_id` = profile.`id` AND play.`user_id` = {$userId} )
							LEFT JOIN `t0400_game_play` play2 ON (play2.`profile_id` = profile.`id` AND play2.`user_id` = {$userId} AND play2.`created_at` > play.`created_at`)

					    		WHERE profile.`deleted_at` IS NULL
					    		AND play2.`id` IS NULL
					    		{$query}

			    					GROUP BY profile.`id` ) t1 , 
					   (
					  SELECT profile.`id` AS `profile_id`, SUM(p.`played_time`) AS `total_played`
					   	FROM `t0111_game_profile` profile 
							LEFT JOIN `t0400_game_play` p ON p.`user_id` = {$userId} AND profile.`id` = p.`profile_id` AND  p.`created_at` > DATE_SUB(NOW(), INTERVAL 3 HOUR)
								WHERE profile.`user_id` = {$userId}
					        	AND profile.`deleted_at` IS NULL

					        	GROUP BY profile.`id`  ) t3
			    	WHERE t1.`profile_id` = t3.`profile_id`
		";

		$lastPlayed = DB::select($sql);

		for ($i = 0; $i < count($profiles); $i++) {
			$p = $profiles[$i];
			$lp = $lastPlayed[$i];

			$totalStar = UserMap::where('profile_id' , $p->id)->sum('star');
			$planet = GamePlanet::find($lp->planet_id);

			if($planet){
				$planetName = $planet->name;
			}else{
				$planetName = 'Null';
			}

			$lastSession = LastSession::where('profile_id', $p->id)->orderBy('updated_at', 'DESC')->first();

			if($lastSession){
				$minute = $lastSession->total_played_time / 60 ;
				$time = explode('.' , $minute);

				$totalPlayed = $time[0];
				$totalAnswered = $lastSession->total_answered;
				$totalCorrect = $lastSession->total_correct;
				$percentage = $lastSession->accuracy;

				if($totalPlayed == 0){
					$totalPlayed = '< 1';
				}
			}else{
				$totalPlayed = 0;
				$totalAnswered = 0;
				$totalCorrect = 0;
				$percentage = 0;
			}

			if($lp->last_played_time){
				$minute2 = $lp->last_played_time / 60 ;
				$time2 = explode('.' , $minute2);
				$lastPlayedTime = $time2[0];
			}else{
				$lastPlayedTime = '< 1';
			}

			if($classId){
				$GameClass = GameClass::find($classId);
				$paid = ($GameClass->expired_at > date("Y-m-d H:i:s") )?1:0;
			}else{
				$paid =  intval($lp->paid);
			}

			array_push($profileInfo, [
				'id' => $p->id,
				'user_id' => $p->user_id,
				'class_id' => $p->class_id,
				'first_name' => $p->first_name,
				'last_name' => $p->last_name,
				'age' => $p->age,
				'school' => $p->school,
				'grade' => $p->grade,
				'total_star' => $totalStar,
				'city' => $p->city,
				'email' => $p->email,
				'nickname1' => $p->nickName1,
				'nickname2' => $p->nickName2,
				'avatar' => $p->avatar,
				'game_code' => $p->gameCode,
				'last_played' => [
					'last_planet_name' => $planetName,
					'last_played' => $lp->created_at,
					'last_played_time' => $lastPlayedTime,
				],
				'last_session' => [
					'total_answered' => $totalAnswered,
					'total_correct' => $totalCorrect,
					'total_played_time' => $totalPlayed,
					'accuracy' => $percentage,
				],
				'paid' => $paid,

			]);
		}

		return $profileInfo;
	}

	public static function verifyTransfer($deviceGameCode , $gameCode){

		// device 		d.Played 	entered 		e.Played 	Can Transfer
		// ================================================================
		// ann			0			ann				0			0
		// ann			0			ann				1			0
		// ann			1			ann				0			1
		// ann			1			ann				1			0

		// ann			0			pro				0			0
		// ann			0			pro				1			0
		// ann			1			pro				0			1
		// ann			1			pro				1			0


		// pro			0			pro				0			0
		// pro			0			pro				1			0
		// pro			1			pro				0			0
		// pro			1			pro				1			0

		// pro			0			ann				0			0
		// pro			0			ann				1			0
		// pro			1			ann				0			0
		// pro			1			ann				1			0

		if ($deviceGameCode->type == 'anonymous' && $deviceGameCode->played) {	
			if($gameCode->type == 'signed_up_profile' && $gameCode->played || $gameCode->type == 'anonymous' && $gameCode->played){
				return  [
						'profile_transfer' => '0',
						'action' => 'warning'
					];
				}

			if($gameCode->type == 'anonymous' && !$gameCode->played || $gameCode->type == 'signed_up_profile' && !$gameCode->played){
				return  [
						'profile_transfer' => '1',
						'action' => 'new+claim'
					];
			}
		}

		return [
				'profile_transfer' => '0',
				'action' => 'n/a'
			];
	}

	public static function newProfile($userId , $classId , $firstName, $age, $school , $grade, $nickname1 , $nickname2 , $avatarId , $studentId = ''){

		$profileType = 'signed_up_profile';
		$seed = 0;

		if($studentId == ''){
			$idCounter = IdCounter::find(1);
			$seed = $idCounter->game_code_seed;
			$idCounter->game_code_seed = $seed + 1;
			$idCounter->save();

			$studentId = ZapZapHelper::GenerateGameCode($seed);
			$profileType = 'anonymous';

		}

		$profile = new GameProfile;
		$profile->profile_type = $profileType;
		$profile->user_id = $userId;
		$profile->class_id = $classId;
		$profile->student_id = $studentId;
		$profile->first_name = $firstName;
		$profile->age = $age;
		$profile->school = $school;
		$profile->grade = $grade;
		$profile->nickname1 = $nickname1;
		$profile->nickname2 = $nickname2;
		$profile->avatar_id = $avatarId;
		$profile->seed = $seed;
		$profile->save();

		$code = new GameCode;
		$code->type = $profileType;
		$code->code = $studentId;
		$code->seed = $seed;
		$code->profile_id = $profile->id;
		$code->save();
		
		return $profile;
	}
}
