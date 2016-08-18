<?php namespace App\Models\Results;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use Exception;

use App\Libraries\LogHelper;

class AbstractGameResult extends Eloquent {

	public static function SubmitTypeResult($typeName, $params){
		try{

			$childResult = self::SubmitResultFromChild($typeName, $params);

			return true;

		}catch(Exception $ex){

			throw $ex;

			LogHelper::LogToDatabase('AbstractGameResult@SubmitTypeResult', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'typeName' => $typeName,
					'params' => $params,
				]),
			]);		

			return false;
		}

	}

	private static function SubmitResultFromChild($typeName, $params){
		switch ($typeName) {
			case 'p01':return GameResultP01::SubmitResult($params); break;
			case 'p02':return GameResultP02::SubmitResult($params); break;
			case 'p03':return GameResultP03::SubmitResult($params); break;
			case 'p04':return GameResultP04::SubmitResult($params); break;
			case 'p05':return GameResultP05::SubmitResult($params); break;
			case 'p06':return GameResultP06::SubmitResult($params); break;
			case 'p07':return GameResultP07::SubmitResult($params); break;
			case 'p08':return GameResultP08::SubmitResult($params); break;
			case 'p09':return GameResultP09::SubmitResult($params); break;
			case 'p10':return GameResultP10::SubmitResult($params); break;
			case 'p11':return GameResultP11::SubmitResult($params); break;
			case 'p12':return GameResultP12::SubmitResult($params); break;
			case 'p13':return GameResultP13::SubmitResult($params); break;
			case 'p14':return GameResultP14::SubmitResult($params); break;
			case 'p15':return GameResultP15::SubmitResult($params); break;
			case 'p16':return GameResultP16::SubmitResult($params); break;
			case 'p17':return GameResultP17::SubmitResult($params); break;
			case 'p18':return GameResultP18::SubmitResult($params); break;
			case 'p19':return GameResultP19::SubmitResult($params); break;
			case 'p20':return GameResultP20::SubmitResult($params); break;
			case 'p21':return GameResultP21::SubmitResult($params); break;
			case 'p22':return GameResultP22::SubmitResult($params); break;
			case 'p23':return GameResultP23::SubmitResult($params); break;
			case 'p24':return GameResultP24::SubmitResult($params); break;
			case 'p25':return GameResultP25::SubmitResult($params); break;
			case 'p26':return GameResultP26::SubmitResult($params); break;
			case 'p27':return GameResultP27::SubmitResult($params); break;
			case 'p28':return GameResultP28::SubmitResult($params); break;
			case 'p29':return GameResultP29::SubmitResult($params); break;
			case 'p30':return GameResultP30::SubmitResult($params); break;
			case 'p31':return GameResultP31::SubmitResult($params); break;
			case 'p32':return GameResultP32::SubmitResult($params); break;
			case 'p33':return GameResultP33::SubmitResult($params); break;
			case 'p34':return GameResultP34::SubmitResult($params); break;
			case 'p35':return GameResultP35::SubmitResult($params); break;
			case 'p36':return GameResultP36::SubmitResult($params); break;
			case 'p37':return GameResultP37::SubmitResult($params); break;
			case 'p38':return GameResultP38::SubmitResult($params); break;
			case 'p39':return GameResultP39::SubmitResult($params); break;
			case 'p40':return GameResultP40::SubmitResult($params); break;
			case 'p41':return GameResultP41::SubmitResult($params); break;
			case 'p42':return GameResultP42::SubmitResult($params); break;
			case 'p43':return GameResultP43::SubmitResult($params); break;
			case 'p44':return GameResultP44::SubmitResult($params); break;
			case 'p45':return GameResultP45::SubmitResult($params); break;
			case 'p46':return GameResultP46::SubmitResult($params); break;
			case 'p47':return GameResultP47::SubmitResult($params); break;
			case 'p48':return GameResultP48::SubmitResult($params); break;
			case 'p49':return GameResultP49::SubmitResult($params); break;
			
			default:break;
		}
	}

}