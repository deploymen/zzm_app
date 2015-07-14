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
use App\Models\LogGetQuestions;


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
}