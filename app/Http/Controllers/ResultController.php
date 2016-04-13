<?php namespace App\Http\Controllers;

use App;
use App\Libraries\LogHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\ResultHelper;
use App\Models\GameCode;
use App\Models\GamePlanet;
use App\Models\GamePlay;
use App\Models\GameProfile;
use App\Models\GameSystem;
use DB;
use Exception;
use Request;

Class ResultController extends Controller {

	public function onlySystem() {
		$gameCode = Request::input('game_code');
		$profileId = Request::input('profile_id');
		$fake = Request::input('fake', 0);
		if ($fake) {
			$profileId = 365;
		}

		$page = Request::input("page", '1');
		$pageSize = Request::input("page_size", '30');
		$pagination = $pageSize * ($page - 1);
		// try {

			$sql = "
				SELECT s.`name` , sp.`system_id` , IF(SUM(um.`played`) > 0, 1, 0) AS `played` , IFNULL(SUM(um.`star`) , 0 ) AS `star` , count(sp.`planet_id`) AS `total_planet`
                    FROM (`t0124_game_system_planet` sp , `t0122_game_system` s)
                        LEFT JOIN `t0501_game_user_map` um ON (um.`planet_id` = sp.`planet_id` AND um.`profile_id`  = {$profileId})

						WHERE sp.`system_id` = s.`id`
						AND s.`enable` = 1
                        GROUP BY `system_id`
                        ORDER BY `system_id` ASC

                        LIMIT {$pagination} , {$pageSize}
			";

			$result = DB::SELECT($sql);
			$total = count($result);

			$system = [];
			for ($i = 0; $i < count($result); $i++) {
				$r = $result[$i];

				if($r->system_id != 999 && $r->system_id != 117){
					$totalPlanet = $r->total_planet * 5;
					$percentage = $r->star / $totalPlanet * 100 / 1;

					array_push($system, [
						'id' => $r->system_id,
						'system_name' => $r->name,
						'played' => $r->played,
						'percentage' => number_format($percentage, 0),
					]);
				}
			}

			return ResponseHelper::OutputJSON('success', '', [
				'system' => $system,
				'page' => $page,
				'page_size' => $pageSize,
				'pageTotal' => ceil($total / $pageSize),
			]);
		// } catch (Exception $ex) {
		// 	LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
		// 		'source' => 'ResultController > onlySystem',
		// 		'inputs' => Request::all(),
		// 	])]);
		// 	return ResponseHelper::OutputJSON('exception');
		// }
	}

	public function onlyPlanet() {
		$userId = Request::input('user_id');

		$gameCode = Request::input('game_code');

		$systmeId = Request::input('system_id');
		$profileId = Request::input('profile_id');

		$page = Request::input("page", '1');
		$pageSize = Request::input("page_size", '30');

		$fake = Request::input('fake', 0);
		if ($fake) {
			$profileId = 365;
		}

		try {

			if (!$profileId) {
				return ResponseHelper::OutputJSON('fail', 'missing profile id');
			}
			if (!$systmeId) {
				return ResponseHelper::OutputJSON('fail', 'missing parametter');
			}

			$profile = GameProfile::find($profileId);
			if (!$fake && $userId != $profile->user_id) {
				return ResponseHelper::OutputJSON('fail', 'invalid profile');
			}

			if (!$gameCode) {
				$gameCode = GameCode::where('profile_id', $profileId)->select('code')->first();
				$gameCode = $gameCode->code;
			}

			$system = GameSystem::find($systmeId);

			$startIndex = $pageSize * ($page - 1);
			$total = GamePlanet::where('available', 1)->count();

			$sql = "
				SELECT p.`id` AS `planet_id`, p.`description` AS `subtitle`, COUNT(gp.`id`) AS `play_count` ,IFNULL(MAX(gp.`score`), 0) AS `max_score` , IFNULL(um.`star`, 0) AS `star` , IFNULL(um.`played`,0) AS `played`
					FROM (`t0122_game_system` s, `t0123_game_planet` p, `t0124_game_system_planet` sp)

						LEFT JOIN `t0400_game_play` gp ON( p.`id` = gp.`planet_id` AND gp.`code` = :game_code )
		                LEFT JOIN `t0501_game_user_map` um ON( um.`profile_id` = :profileId AND um.`planet_id` = p.`id`)

							WHERE s.`id` = {$systmeId}
								AND sp.`planet_id` = p.`id`
								AND sp.`system_id` = s.`id`
								AND p.`available` = 1
		                                GROUP BY s.`id`, p.`id`
										ORDER BY sp.`sequence` ASC

										LIMIT {$startIndex} , {$pageSize}
			";

			$result = DB::SELECT($sql, ['game_code' => $gameCode, 'profileId' => $profileId]);

			$planet = [];
			for ($i = 0; $i < count($result); $i++) {
				$r = $result[$i];
				array_push($planet, [
					'id' => $r->planet_id,
					'subtitle' => $r->subtitle,
					'play_count' => $r->play_count,
					'star' => $r->star,
					'max_score' => $r->max_score,
					'played' => $r->played,
					'percentage' => $r->star * 20,
				]);
			}

			return ResponseHelper::OutputJSON('success', '', [
				'planet' => $planet,
				'breadcrumb' => [
					'system_id' => $systmeId,
					'system_name' => $system->name,
				],
				'page' => $page,
				'page_size' => $pageSize,
				'pageTotal' => ceil($total / $pageSize),
			]);
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ResultController > onlyPlanet',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}
	
	public function onlyQuestions() {
		$userId = Request::input('user_id');
		$gameCode = Request::input('game_code');

		// $playId = Request::input('play_id');
		$planetId = Request::input('planet_id');
		$profileId = Request::input('profile_id');

		$page = Request::input("page", '1');
		$pageSize = Request::input("page_size", '30');

		$fake = Request::input('fake', 0);
		if ($fake) {
			$profileId = 3613;
		}

		// try{
		if (!$profileId || !$planetId) {
			return ResponseHelper::OutputJSON('fail', 'missing parametter');
		}

		$profile = GameProfile::find($profileId);
		if (!$fake && $userId != $profile->user_id) {
			return ResponseHelper::OutputJSON('fail', 'invalid profile');
		}

		if (!$gameCode) {
			$gameCode = GameCode::where('profile_id', $profileId)->select('code')->first();
			$gameCode = $gameCode->code;
		}

		$planet = GamePlay::where('planet_id', $planetId)->where('profile_id', $profileId)->first();
		if (!$planet) {
			return ResponseHelper::OutputJSON('fail', 'record not found');

		}

		$breadcrumbSql = "
				SELECT sp.`system_id`, s.`name` , sp.`planet_id` , p.`description`
					FROM `t0124_game_system_planet` sp , `t0123_game_planet` p , `t0122_game_system` s
						WHERE s.`id` = sp.`system_id`
						AND p.`id` = sp.`planet_id`
						AND sp.`planet_id` = {$planetId}

			";

		$breadcrumb = DB::select($breadcrumbSql);
		$breadcrumb = $breadcrumb[0];

		$sqlGameType = "
				SELECT  `id`, `target_type`
					FROM  `t0400_game_play`
						WHERE `planet_id` = {$planetId}
						AND `profile_id` = {$profileId}
						ORDER BY `id`
			";
		$play = DB::SELECT($sqlGameType);

		$playId = [];
		for ($i = 0; $i < count($play); $i++) {
			array_push($playId, $play[$i]->id);
		}
		$playId = implode(',', $playId);

		$startIndex = $pageSize * ($page - 1);

		switch ($play[0]->target_type) {
			case 'p00':$question = ResultHelper::ResultQuestionP00($playId , $startIndex , $pageSize); break;
			case 'p01':$question = ResultHelper::ResultQuestionP01($playId , $startIndex , $pageSize); break;
			case 'p02':$question = ResultHelper::ResultQuestionP02($playId , $startIndex , $pageSize); break;
			case 'p03':$question = ResultHelper::ResultQuestionP03($playId , $startIndex , $pageSize); break;
			case 'p06':$question = ResultHelper::ResultQuestionP06($playId , $startIndex , $pageSize); break;
			case 'p07':$question = ResultHelper::ResultQuestionP07($playId , $startIndex , $pageSize); break;
			case 'p08':$question = ResultHelper::ResultQuestionP08($playId , $startIndex , $pageSize); break;
			case 'p09':$question = ResultHelper::ResultQuestionP09($playId , $startIndex , $pageSize); break;
			case 'p10':$question = ResultHelper::ResultQuestionP10($playId , $startIndex , $pageSize); break;
			case 'p11':$question = ResultHelper::ResultQuestionP11($playId , $startIndex , $pageSize); break;
			case 'p12':$question = ResultHelper::ResultQuestionP12($playId , $startIndex , $pageSize); break;
			case 'p13':$question = ResultHelper::ResultQuestionP13($playId , $startIndex , $pageSize); break;
			case 'p14':$question = ResultHelper::ResultQuestionP14($playId , $startIndex , $pageSize); break;
			case 'p15':$question = ResultHelper::ResultQuestionP15($playId , $startIndex , $pageSize); break;
			case 'p16':$question = ResultHelper::ResultQuestionP15($playId , $startIndex , $pageSize); break;
			case 'p17':$question = ResultHelper::ResultQuestionP15($playId , $startIndex , $pageSize); break;
			case 'p18':$question = ResultHelper::ResultQuestionP18($playId , $startIndex , $pageSize); break;
			case 'p23':$question = ResultHelper::ResultQuestionP23($playId , $startIndex , $pageSize); break;
			case 'p32':$question = ResultHelper::ResultQuestionP32($playId , $startIndex , $pageSize); break;
		}

		return ResponseHelper::OutputJSON('success', '', [
			'game_type' => $play[0]->target_type,
			'questions' => $question,
			'breadcrumb' => [
				'system_id' => $breadcrumb->system_id,
				'system_name' => $breadcrumb->name,
				'planet_id' => $breadcrumb->planet_id,
				'planet_subtitle' => $breadcrumb->description,
			],
			'page' => $page,
			'page_size' => $pageSize,
			'pageTotal' => ceil( count($question) / $pageSize),
		]);
		// } catch (Exception $ex) {

		// 	LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
		// 		'source' => 'ResultController > onlyQuestions',
		// 		'inputs' => Request::all(),
		// 	])]);
		// 	return ResponseHelper::OutputJSON('exception');
		// }
	}
}
