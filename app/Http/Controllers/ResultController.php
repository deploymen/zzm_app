<?php namespace App\Http\Controllers;

use App;
use DB;
use Exception;
use Config;
use Request;
use Session;
use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\AuthHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\EmailHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\DatabaseUtilHelper;
use App\Libraries\ResultHelper;

use App\Models;
use App\Models\GameProfile;
use App\Models\GamePlay;
use App\Models\GameCode;
use App\Models\GameSystem;
use App\Models\GamePlanet;
use App\Models\GameSystemPlanet;
use App\Models\GameType;
use App\Models\UserMap;
use App\Models\GameResultP01;
use App\Models\GameResultP02;
use App\Models\GameResultP03;
use App\Models\GameResultP06;
use App\Models\GameQuestion;
use App\Models\GameQuestionP04ChallengeSet;
use App\Models\UserExternalId;


Class ResultController extends Controller {

	public function onlySystem(){
		$gameCode = Request::input('game_code');
		$profileId = Request::input('game_code_profile_id');
		
		$profileId = Request::input('profile_id');

		$page = Request::input("page", '1');
		$pageSize = Request::input("page_size", '30');

		try{
			
			/* pagination */
			$startIndex = $pageSize*($page - 1);
			$total = GameSystem::where('enable' , 1)->count();
	       	//end 

	       	/* get system id */
	       	$resultSystemIds = GameSystem::where('enable', 1)->skip($startIndex)->take($pageSize)->select('id')->get();

	       	$systemIds = [];
	       	for($i=0; $i<count($resultSystemIds); $i++){
	       		array_push($systemIds, $resultSystemIds[$i]->id);
	       	}
	       	$systemIds = implode(',', $systemIds);
	       	//end 

			$sql = " 
				SELECT s.`id` AS `system_id` , s.`name` AS `system_name`
					FROM `t0122_game_system` s
						WHERE s.`id` IN ({$systemIds})
	                                    GROUP BY s.`id`
										ORDER BY s.`sequence` ASC
			";

			$result = DB::SELECT($sql);

			$answers = [];
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];
				array_push($answers, [
					'id' => $r->system_id,
					'system_name' => $r->system_name,
					'played' => '1',
				]);
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

	public function onlyPlanet(){
		$userId = Request::input('user_id');

		$gameCode = Request::input('game_code');
		$profileId = Request::input('game_code_profile_id');

		$systmeId = Request::input('system_id');
		$profileId = Request::input('profile_id');

		$page = Request::input("page", '1');
		$pageSize = Request::input("page_size", '30');

		try{

			if(!$profileId){
				return ResponseHelper::OutputJSON('fail', 'missing profile id');
			}
			if(!$systmeId){
				return ResponseHelper::OutputJSON('fail', 'missing parametter');
			}

			$profile = GameProfile::find($profileId);
			if($userId != $profile->user_id){
				return ResponseHelper::OutputJSON('fail', 'invalid profile');
			}

			if(!$gameCode){
				$gameCode = GameCode::where('profile_id', $profileId)->select('code')->first();
				$gameCode = $gameCode->code;
			}

			$system = GameSystem::find($systmeId);

			$startIndex = $pageSize*($page - 1);
			$total = GameSystem::where('enable' , 1)->count();

			$sql = " 
				SELECT p.`id` AS `planet_id`, p.`description` AS `subtitle`, COUNT(gp.`id`) AS `play_count` ,IFNULL(MAX(gp.`score`), 0) AS `max_score` , IFNULL(um.`star`, 0) AS `star`
					FROM (`t0122_game_system` s, `t0123_game_planet` p, `t0124_game_system_planet` sp)
		            
						LEFT JOIN `t0400_game_play` gp ON( p.`id` = gp.`planet_id` AND gp.`code` = :game_code )
		                LEFT JOIN `t0501_game_user_map` um ON( um.`profile_id` = :profileId AND um.`planet_id` = p.`id`)
		                
							WHERE s.`id` = {$systmeId}
								AND sp.`planet_id` = p.`id`
								AND sp.`system_id` = s.`id` 
								AND sp.`enable` = 1
		                                GROUP BY s.`id`, p.`id`
										ORDER BY p.`id` ASC
			";

			$result = DB::SELECT($sql ,['game_code'=>$gameCode , 'profileId'=>$profileId ]);

			$answers = [];
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];
				array_push($answers, [
					'id' => $r->planet_id,
					'subtitle' => $r->subtitle,
					'play_count' => $r->play_count,
					'star' => $r->star,
					'max_score' => $r->max_score,
					'played' => '1',
				]);
			}

			return ResponseHelper::OutputJSON('success', '' , [
				'planet' =>$answers,
				'breakcrumb' => [
					'system_id' => $systmeId,
					'system_name' => $system->name,
				],
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

	public function onlyPlay(){
		$userId = Request::input('user_id');

		$gameCode = Request::input('game_code');
		$profileId = Request::input('game_code_profile_id');

		$planetId = Request::input('planet_id');
		$profileId = Request::input('profile_id');

		$page = Request::input("page", '1');
		$pageSize = Request::input("page_size", '30');

		try{	
			if(!$profileId){
				return ResponseHelper::OutputJSON('fail', 'missing profile id');
			}
			if(!$planetId){
				return ResponseHelper::OutputJSON('fail', 'missing parametter');
			}

			$profile = GameProfile::find($profileId);
			if($userId != $profile->user_id){
				return ResponseHelper::OutputJSON('fail', 'invalid profile');
			}

			if(!$gameCode){
				$gameCode = GameCode::where('profile_id', $profileId)->select('code')->first();
				$gameCode = $gameCode->code;
			}

			$breakcrumbSql = "
				SELECT sp.`system_id`, s.`name` , sp.`planet_id` , p.`description` 
					FROM `t0124_game_system_planet` sp , `t0123_game_planet` p , `t0122_game_system` s
						WHERE s.`id` = sp.`system_id`
						AND p.`id` = sp.`planet_id`
						AND sp.`planet_id` = {$planetId}

			";

			$breakcrumb = DB::select($breakcrumbSql);
			$breakcrumb = $breakcrumb[0];

			$startIndex = $pageSize*($page - 1);
			$total = GameSystem::where('enable' , 1)->count();


			$sql = " 
				SELECT *
					FROM `t0400_game_play` 
						WHERE `planet_id` = {$planetId}
						AND `code` = '{$gameCode}'
						ORDER BY `created_at` DESC
			";

			$result = DB::SELECT($sql);

			$answers = [];
			for($i=0; $i<count($result); $i++){
				$r = $result[$i];
				array_push($answers, [
					'id' => $r->id,
					'planet_id'=>$r->planet_id,
					'score'=>$r->score,
					'status'=>$r->status,
					'target_type'=>$r->target_type,
					'played' => '1',
					'play_time' => $r->created_at,
				]);
			}

			return ResponseHelper::OutputJSON('success', '' , [
				'play' =>$answers,
				'breakcrumb' => [
					'system_id' => $breakcrumb->system_id,
					'system_name' => $breakcrumb->name,
					'planet_id' => $planetId,
					'planet_subtitle' => $breakcrumb->description

				],
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

	public function onlyQuestions(){
		$userId = Request::input('user_id');

		$gameCode = Request::input('game_code');

		$playId = Request::input('play_id');
		$profileId = Request::input('profile_id');

		$page = Request::input("page", '1');
		$pageSize = Request::input("page_size", '30');

		try{
			if(!$profileId){
				return ResponseHelper::OutputJSON('fail', 'missing parametter');
			}
			if(!$playId){
				return ResponseHelper::OutputJSON('fail', 'missing parametter');
			}

			$profile = GameProfile::find($profileId);
			if($userId != $profile->user_id){
				return ResponseHelper::OutputJSON('fail', 'invalid profile');
			}

			if(!$gameCode){
				$gameCode = GameCode::where('profile_id', $profileId)->select('code')->first();
				$gameCode = $gameCode->code;
			}

			$breakcrumbSql = "
				SELECT sp.`system_id`, s.`name` , sp.`planet_id` , p.`description` 
					FROM `t0124_game_system_planet` sp , `t0123_game_planet` p , `t0122_game_system` s , `t0400_game_play` pl
						WHERE pl.`id` = {$playId}
							AND pl.`planet_id` = sp.`planet_id`
							AND pl.`planet_id` = p.`id`
							AND sp.`system_id` = s.`id`

			";

			$breakcrumb = DB::select($breakcrumbSql);
			$breakcrumb = $breakcrumb[0];

			$startIndex = $pageSize*($page - 1);
			$total = GameSystem::where('enable' , 1)->count();

			$sqlGameType = " 
				SELECT  `target_type`
					FROM  `t0300_game_result` 
						WHERE `play_id` = {$playId}
						ORDER BY `id`
			";

			$targetType = DB::SELECT($sqlGameType);

			switch($targetType[0]->target_type){
				case 'p01':$answers = ResultHelper::ResultQuestionP01($playId); break;
				case 'p02':$answers = ResultHelper::ResultQuestionP02($playId); break;
				case 'p03':$answers = ResultHelper::ResultQuestionP03($playId); break;
				case 'p06':$answers = ResultHelper::ResultQuestionP06($playId); break;
				case 'p07':$answers = ResultHelper::ResultQuestionP07($playId); break;
				case 'p10':$answers = ResultHelper::ResultQuestionP10($playId); break;

			}	


			return ResponseHelper::OutputJSON('success', '' , [
				'questions' =>$answers,
				'breakcrumb' => [
					'system_id' => $breakcrumb->system_id,
					'system_name' => $breakcrumb->name,
					'planet_id' => $breakcrumb->planet_id,
					'planet_subtitle' => $breakcrumb->description,
					'play_id' => $playId
				],
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
}



