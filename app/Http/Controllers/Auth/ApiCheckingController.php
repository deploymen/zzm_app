<?php namespace App\Http\Controllers;
use DB;
use Models;
use Request;

use Libraries;
use App\Libraries\ResponseHelper;
use App\Libraries\ZapZapQuestionHelper;

use App\Models\GameSystem;

class ApiCheckingController extends Controller {

	public function CheckGameStatus(){
		$status['planet'] = [];

		$status['system_count'] = GameSystem::where('enable' , 1)->count();

		$sqlPlanet = "
			SELECT  p.`id` , p.`name` , t.`name` AS `game_type`
				FROM `t0123_game_planet` p, `t0121_game_type` t
					WHERE p.`available` = 1 
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
				case 'p14':$questions = ZapZapQuestionHelper::GetQuestionP14($p->id , 1 , 10); break;
				case 'p15':$questions = ZapZapQuestionHelper::GetQuestionP15($p->id , 1 , 10); break;
				case 'p16':$questions = ZapZapQuestionHelper::GetQuestionP16($p->id , 1 , 10); break;
				case 'p18':$questions = ZapZapQuestionHelper::GetQuestionP18($p->id , 1 , 10); break;
				case 'p23':$questions = ZapZapQuestionHelper::GetQuestionP23($p->id , 1 , 10); break;
				case 'p32':$questions = ZapZapQuestionHelper::GetQuestionP32($p->id , 1 , 10); break;
				case 'p00':$questions = ZapZapQuestionHelper::GetQuestionP00($p->id , 2 , 1 , 1); break;

				default: $question = 'question not found';
			}
		
			if($questions == 'question not found' || !$questions){
				$planetStatus = 0;
			}else{
				$planetStatus = 1;
			}

			array_push($status['planet'] , [
				'planet_name' => $p->name.'('.$p->id.')',
				'game_type' => $p->game_type,
				'status' => $planetStatus,
				]);
		}

		return view('status-game', ['status'=>$status] );
	}

	public function CheckIpDetails(){
		$secret = 'SAKF3G83D83MEKX59Y9Z';
		$ip = Request::ip();

		$res = file_get_contents("http://api.apigurus.com/iplocation/v1.8/locateip?key={$secret}&ip={$ip}&format=json&compact=y");			
		$ipDetail = json_decode($res, true);

		if(isset($ipDetail['geolocation_data'])) { 
			$geolocationData = $ipDetail['geolocation_data'];

			var_export($geolocationData); die();
			$profile->city = $geolocationData['city'];
			$profile->country = $geolocationData['country_name'];
			$profile->save();
		}
	}

}