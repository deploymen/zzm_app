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
use App\Models\GameResultP10;
use App\Models\GameResultP18;
use App\Models\GameQuestion;
use App\Models\GameQuestionP03;
use App\Models\GameQuestionP04ChallengeSet;
use App\Models\GameSystemPlanet;
use App\Models\UserExternalId;
use App\Models\LeaderboardWorld;
use App\Models\LeaderboardSystem;
use App\Models\LeaderboardPlanet;

class ReportProfileHelper{
	public static function TotalPlay($profileId){
		$sql = "
			SELECT count(`id`) AS `total_play` , count( CASE WHEN `status` = 'pass' THEN 1 END) AS `total_pass` , count( CASE WHEN `status` = 'fail' THEN 1 END) AS `total_fail`
				FROM `t0400_game_play`
					WHERE `profile_id` = {$profileId}
		";

		$totalPlay = DB::select($sql);

		return $totalPlay[0];
	}

	public static function TotalCompletedPlanet($profileId){
		$sql = "
			SELECT count( CASE WHEN `star` >= 3 THEN 1 END) AS `completed_planet` 
				FROM `t0501_game_user_map`
					WHERE `profile_id` = {$profileId}
		";

		$totalComplatedPlanet = DB::select($sql);

		return $totalComplatedPlanet[0];
	}

	public static function LastPlay($profileId){
		$sql = "
			SELECT s.`name` AS `system_name`, pl.`name` AS `planet_name` , pl.`description` ,p.`score` , p.`status`, p.`created_at` AS `last_play`
				FROM `t0400_game_play` p, `t0123_game_planet` pl , `t0124_game_system_planet` sp , `t0122_game_system` s
					WHERE p.`profile_id` = {$profileId}
					AND pl.`id` = p.`planet_id`
					AND sp.`planet_id` = pl.`id`
					AND sp.`system_id` = s.`id`

					ORDER BY p.`created_at` DESC
					LIMIT 5
		";

		$lastPlay = DB::select($sql);

		return $lastPlay;
	}

	public static function planetProgress($profileId){
		$sql = "
			SELECT p.`name`, IFNULL(um.`star` , 0) AS `star`
				FROM (`t0123_game_planet` p)
                	LEFT JOIN `t0501_game_user_map` um ON (um.`planet_id` = p.`id`)
					WHERE p.`enable` = 1
		";

		$planetProgress = DB::select($sql);

		return $planetProgress;
	}
}

