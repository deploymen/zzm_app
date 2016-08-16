<?php namespace App\Libraries;

use App;
use Exception;
use Config;
use Request;
use DB;
use App\Libraries;

use App\Models;
use App\Models\LogGetQuestions;
use App\Models\LogPostResult;
use App\Models\LogGameCoin;


class LogHelper{

	public static function LogToDatabase($message, $context)
	{
		$pdo = DB::connection('mysql')->getPdo();
		$mySQLHandler = new MonologMySQLHandler($pdo);
		$logger = new \Monolog\Logger($context);
		$logger->pushHandler($mySQLHandler);
		$logger->addError($message, $context);
	}

	public static function LogGetQuestions($planetId,$gameCode){
		$logGetQuestions = new LogGetQuestions;
		$logGetQuestions->planet_id = $planetId;
		$logGetQuestions->game_code = $gameCode;
		$logGetQuestions->created_ip = Request::ip();
		$logGetQuestions->save();
	}

	public static function LogPostResult($planetId , $jsonGameResult,$gameCode){
		$logPostResult = new LogPostResult;
		$logPostResult->result = $jsonGameResult;
		$logPostResult->planet_id = $planetId;
		$logPostResult->game_code = $gameCode;
		$logPostResult->created_ip = Request::ip();
		$logPostResult->save();
	}

	public static function LogGameCoin($userId , $profileId,$planetId , $difficulty , $coin){
		$logGameCoin = new LogGameCoin;
		$logGameCoin->user_id = $userId;
		$logGameCoin->profile_id = $profileId;
		$logGameCoin->planet_id = $planetId;
		$logGameCoin->difficulty = $difficulty;
		$logGameCoin->coin = $coin;
		$logGameCoin->save();
	}
}