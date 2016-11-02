<?php

namespace App\Libraries;

use Request;
use DB;
use App\Models\LogGetQuestions;
use App\Models\LogPostResult;

class LogHelper {

    public static function LogToDatabase($message, $context) {
        $pdo = DB::connection('mysql')->getPdo();
        $mySQLHandler = new MonologMySQLHandler($pdo);
        $logger = new \Monolog\Logger($context);
        $logger->pushHandler($mySQLHandler);
        $logger->addError($message, $context);
    }

    public static function LogGetQuestions($planetId, $gameCode) {
        $logGetQuestions = new LogGetQuestions;
        $logGetQuestions->planet_id = $planetId;
        $logGetQuestions->game_code = $gameCode;
        $logGetQuestions->created_ip = Request::ip();
        $logGetQuestions->save();
    }

    public static function LogPostResult($planetId, $jsonGameResult, $gameCode) {
        $logGetQuestions = new LogPostResult;
        $logGetQuestions->result = $jsonGameResult;
        $logGetQuestions->planet_id = $planetId;
        $logGetQuestions->game_code = $gameCode;
        $logGetQuestions->created_ip = Request::ip();
        $logGetQuestions->save();
    }

}
