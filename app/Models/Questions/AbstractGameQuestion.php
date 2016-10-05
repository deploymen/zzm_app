<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Questions\GameQuestionP03;
use Exception;

use App\Libraries\LogHelper;

class AbstractGameQuestion extends Eloquent {

	public static function GetTypeQuestions($typeName, $params){
		try{
			
			$questions = self::GetQuestionsFromChild($typeName, $params);

			return $questions;

		}catch(Exception $ex){

			throw $ex;

			LogHelper::LogToDatabase('AbstractGameQuestion@GetQuestions', [
				'environment' => json_encode([
					'message' => $ex->getMessage(),
					'typeName' => $typeName,
					'params' => $params,
				]),
			]);		
			return null;
		}

	}

	private static function GetQuestionsFromChild($typeName, $params){
		switch ($typeName) {
			case 'p01':return GameQuestionP01::GetQuestions($params); break;
			case 'p02':return GameQuestionP02::GetQuestions($params); break;
			case 'p03':return GameQuestionP03::GetQuestions($params); break;
			case 'p04':return GameQuestionP04::GetQuestions($params); break;
			case 'p05':return GameQuestionP05::GetQuestions($params); break;
			case 'p06':return GameQuestionP06::GetQuestions($params); break;
			case 'p07':return GameQuestionP07::GetQuestions($params); break;
			case 'p08':return GameQuestionP08::GetQuestions($params); break;
			case 'p09':return GameQuestionP09::GetQuestions($params); break;
			case 'p10':return GameQuestionP10::GetQuestions($params); break;
			case 'p11':return GameQuestionP11::GetQuestions($params); break;
			case 'p12':return GameQuestionP12::GetQuestions($params); break;
			case 'p13':return GameQuestionP13::GetQuestions($params); break;
			case 'p14':return GameQuestionP14::GetQuestions($params); break;
			case 'p15':return GameQuestionP15::GetQuestions($params); break;
			case 'p16':return GameQuestionP16::GetQuestions($params); break;
			case 'p17':return GameQuestionP17::GetQuestions($params); break;
			case 'p18':return GameQuestionP18::GetQuestions($params); break;
			case 'p19':return GameQuestionP19::GetQuestions($params); break;
			case 'p20':return GameQuestionP20::GetQuestions($params); break;
			case 'p21':return GameQuestionP21::GetQuestions($params); break;
			case 'p22':return GameQuestionP22::GetQuestions($params); break;
			case 'p23':return GameQuestionP23::GetQuestions($params); break;
			case 'p24':return GameQuestionP24::GetQuestions($params); break;
			case 'p25':return GameQuestionP25::GetQuestions($params); break;
			case 'p26':return GameQuestionP26::GetQuestions($params); break;
			case 'p27':return GameQuestionP27::GetQuestions($params); break;
			case 'p28':return GameQuestionP28::GetQuestions($params); break;
			case 'p29':return GameQuestionP29::GetQuestions($params); break;
			case 'p30':return GameQuestionP30::GetQuestions($params); break;
			case 'p31':return GameQuestionP31::GetQuestions($params); break;
			case 'p32':return GameQuestionP32::GetQuestions($params); break;
			case 'p33':return GameQuestionP33::GetQuestions($params); break;
			case 'p34':return GameQuestionP34::GetQuestions($params); break;
			case 'p35':return GameQuestionP35::GetQuestions($params); break;
			case 'p36':return GameQuestionP36::GetQuestions($params); break;
			case 'p37':return GameQuestionP37::GetQuestions($params); break;
			case 'p38':return GameQuestionP38::GetQuestions($params); break;
			case 'p39':return GameQuestionP39::GetQuestions($params); break;
			case 'p40':return GameQuestionP40::GetQuestions($params); break;
			case 'p41':return GameQuestionP41::GetQuestions($params); break;
			case 'p42':return GameQuestionP42::GetQuestions($params); break;
			case 'p43':return GameQuestionP43::GetQuestions($params); break;
			case 'p44':return GameQuestionP44::GetQuestions($params); break;
			case 'p45':return GameQuestionP45::GetQuestions($params); break;
			case 'p46':return GameQuestionP46::GetQuestions($params); break;
			case 'p47':return GameQuestionP47::GetQuestions($params); break;
			case 'p48':return GameQuestionP48::GetQuestions($params); break;
			case 'p49':return GameQuestionP49::GetQuestions($params); break;
			case 'p50':return GameQuestionP50::GetQuestions($params); break;
			case 'p51':return GameQuestionP51::GetQuestions($params); break;
			case 'p52':return GameQuestionP52::GetQuestions($params); break;
			case 'p53':return GameQuestionP53::GetQuestions($params); break;
			case 'p54':return GameQuestionP54::GetQuestions($params); break;
			case 'p55':return GameQuestionP55::GetQuestions($params); break;
			case 'p56':return GameQuestionP56::GetQuestions($params); break;
			
			default:break;
		}
	}

}