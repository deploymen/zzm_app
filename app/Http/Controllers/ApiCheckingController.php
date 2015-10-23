<?php namespace App\Http\Controllers;
use DB;
use Models;
use Libraries;
use App\Libraries\ResponseHelper;
use App\Libraries\ZapZapQuestionHelper;

use App\Models\GameSystem;

class ApiCheckingController extends Controller {

	public function CheckStatus(){

		$status['connection'] = [];
		$status['last_update'] = [];
		$status['system_planet'] = [];	
		$status['planet_type'] = [];
		$status['number_of_quesitons'] = [];
		$status['user'] = [];
		$status['log_general'] = [];

		/* check last update */	
		$lastDataUpdate = "
			SELECT `created_at` , date_add(`created_at` ,INTERVAL  1 HOUR) > now() AS `status`
				FROM `t0400_game_play`

				ORDER BY `created_at`  DESC
				LIMIT 1;
		";


		$lastUpdate = DB::SELECT($lastDataUpdate);
		if($lastUpdate){
			$lastUpdate = head($lastUpdate);
			array_push($status['last_update'], [
				'status' => $lastUpdate->status,
				'last_update' =>  $lastUpdate->created_at,
			]);
		}else{
			array_push($status['last_update'], [
				'status' => '0',
				'last_update' =>  'no data',
			]);
		}
		/* check end */

		/* check systemplanet */
		$systemPlanetCount = "
			SELECT count(sp.`id`) AS 'system_planet_enable'
				FROM `t0122_game_system` s, `t0123_game_planet` p, `t0124_game_system_planet` sp
					WHERE s.`enable` = 1
					AND p.`enable` = 1
					AND sp.`enable`= 1
					AND sp.`system_id` = s.`id`
					AND sp.`planet_id` = p.`id`
		";

		$systemPlanet = DB::SELECT($systemPlanetCount);
		$systemPlanet = $systemPlanet[0];
		array_push($status['system_planet'] , ['system_planet_enable'=> $systemPlanet->system_planet_enable]);
		/* check end */

		/* check systemplanet */
		$gameTypeCount = "
			SELECT `game_type_id` , count(*) AS `planet_total`
				FROM `t0123_game_planet` 
					WHERE game_type_id != 0 
					GROUP BY `game_type_id`

		";

		$gameType = DB::SELECT($gameTypeCount);
		for($i=0; $i<count($gameType); $i++){
			$gt = $gameType[$i];
			array_push($status['planet_type'], [
					'game_type_id' =>$gt->game_type_id,
					'planet_total' =>$gt->planet_total
				]);
		}
		/* check end */

		/* check enable planet */
		$p01 = "
			SELECT count(`id`) AS `p01`
				FROM `t0201_game_question_p01`
					WHERE `enable` = 1
		";
		$p01Total = DB::SELECT($p01);
		$p01Total = $p01Total[0];

		$p02 = "
			SELECT count(`id`) AS `p02`
				FROM `t0202_game_question_p02`
					WHERE `enable` = 1
		";

		$p02Total = DB::SELECT($p02);
		$p02Total = $p02Total[0];

		$p03 = "
			SELECT count(`id`) AS `p03`
				FROM `t0203_game_question_p03`
					WHERE `enable` = 1
		";

		$p03Total = DB::SELECT($p03);
		$p03Total = $p03Total[0];

		$p06 = "
			SELECT count(`id`) AS `p06`
				FROM `t0206_game_question_p06`
					WHERE `enable` = 1
		";

		$p06Total = DB::SELECT($p06);
		$p06Total = $p06Total[0];

		$p07 = "
			SELECT count(`id`) AS `p07`
				FROM `t0207_game_question_p07`
					WHERE `enable` = 1
		";

		$p07Total = DB::SELECT($p07);
		$p07Total = $p07Total[0];
		
		array_push($status['number_of_quesitons'] , [
			'p01' => $p01Total->p01,
			'p02' => $p02Total->p02,
			'p03' => $p03Total->p03,
			'p06' => $p06Total->p06,
			'p07' => $p07Total->p07,
			]);
		/* check end */

		/* check user */
		$user = "
			SELECT `role`, COUNT(*) AS `total`, MAX(`created_at`)AS`last_update`
				FROM `t0101_user` 
				GROUP BY `role` 
				ORDER BY `created_at` DESC
		";
		$userTotal = DB::SELECT($user);

		for($i=0; $i<count($userTotal); $i++){
			$ut = $userTotal[$i];
			array_push($status['user'],[
				'role' => $ut->role,
				'total' => $ut->total,
				'last_update' => $ut->last_update,
				]);
		}
		$log = " 
			SELECT * 
				FROM `t9401_log_general`
					ORDER BY `created_at` DESC 
					LIMIT 10;
		";

		$logTotal = DB::SELECT($log);

		for($i=0; $i<count($logTotal); $i++){
			$lt = $logTotal[$i];
			array_push($status['log_general'], [
				'id' => $lt->id,
				'level_name' => $lt->level_name,
				'message' => $lt->message,
				'environment' => $lt->environment,
				'created_at' => $lt->created_at,
				'created_ip' => $lt->created_ip,
				]);
		}

			return view('status-game', ['status'=>$status] );
	}

	public function CheckGameStatus(){
		$status['planet'] = [];

		$status['system_count'] = GameSystem::where('enable' , 1)->count();

		$sqlPlanet = "
			SELECT  p.`id` , p.`name` , t.`name` AS `game_type`
				FROM `t0123_game_planet` p, `t0121_game_type` t
					WHERE p.`enable` = 1 
					AND t.`id` = p.`game_type_id`
					ORDER BY p.`id`

		";

		$planet = DB::SELECT($sqlPlanet);
		$status['planet_count'] = count($planet);

		for($i=0; $i<count($planet); $i++){
			$p = $planet[$i];

			switch($p->game_type){
				case 'p01':$questions = ZapZapQuestionHelper::GetQuestionP01($p->id , 1 , 10); break;
				case 'p02':$questions = ZapZapQuestionHelper::GetQuestionP02($p->id , 1 , 10); break;
				case 'p03':$questions = ZapZapQuestionHelper::GetQuestionP03($p->id , 1 , 10); break;
				case 'p06':$questions = ZapZapQuestionHelper::GetQuestionP06($p->id , 1 , 10); break;
				case 'p07':$questions = ZapZapQuestionHelper::GetQuestionP07($p->id , 1 , 10); break;
				case 'p08':$questions = ZapZapQuestionHelper::GetQuestionP08($p->id , 1 , 10); break;
				case 'p09':$questions = ZapZapQuestionHelper::GetQuestionP09($p->id , 1 , 10); break;
				case 'p10':$questions = ZapZapQuestionHelper::GetQuestionP10($p->id , 1 , 10); break;
				case 'p11':$questions = ZapZapQuestionHelper::GetQuestionP11($p->id , 1 , 10); break;
				case 'p12':$questions = ZapZapQuestionHelper::GetQuestionP12($p->id , 1 , 10); break;
				case 'p13':$questions = ZapZapQuestionHelper::GetQuestionP13($p->id , 1 , 10); break;
				case 'p18':$questions = ZapZapQuestionHelper::GetQuestionP18($p->id , 1 , 10); break;
				case 'p23':$questions = ZapZapQuestionHelper::GetQuestionP23($p->id , 1 , 10); break;
				case 'p32':$questions = ZapZapQuestionHelper::GetQuestionP32($p->id , 1 , 10); break;
				case 'p00':$questions = ZapZapQuestionHelper::GetQuestionP00($p->id , 2 , 1 , 1); break;

				default: return ResponseHelper::OutputJSON('fail', 'question not found');
			}
			
			if($questions){
				$planetStatus = 1;
			}else{
				$planetStatus = 0;
			}

			array_push($status['planet'] , [
				'planet_name' => $p->name.'('.$p->id.')',
				'status' => $planetStatus,
				]);
		}

		return view('status-game', ['status'=>$status] );
		
	}

}