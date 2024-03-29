<?php

namespace App\Http\Controllers;

use DB;

class CronController extends Controller {

    public function s1001_leaderboard_clean() {
        $stmt = DB::connection()->getPdo()->prepare('CALL s1001_leaderboard_clean()');
        $execute_result = $stmt->execute();
        if (!$execute_result) {
            die('fail s1001_leaderboard_clean');
        }
    }

    public function s1001_planet_available() {
        $stmt = DB::connection()->getPdo()->prepare('CALL s1001_planet_available()');
        $execute_result = $stmt->execute();
        if (!$execute_result) {
            die('fail s1001_planet_available');
        }
    }

    public function s1002_question_cache() {
        $stmt = DB::connection()->getPdo()->prepare('CALL s1002_question_cache()');
        $execute_result = $stmt->execute();
        if (!$execute_result) {
            die('fail s1002_question_cache');
        }
    }

}
