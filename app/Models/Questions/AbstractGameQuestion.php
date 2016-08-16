<?php namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Questions\GameQuestionP03;
use Exception;

class AbstractGameQuestion extends Eloquent {

	public static function GetQuestions($typeName, $params){
		try{
			$questions = self::GetQuestionsFromChild($typeName, $params);

			shuffle($questions);//why need to random again?

			return $questions;

		}catch(Exception $ex){
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
			case 'p03':return GameQuestionP03::GetQuestions($params); break;
			
			default:break;
		}
	}

}