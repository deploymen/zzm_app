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
}
