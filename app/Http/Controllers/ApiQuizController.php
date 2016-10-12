<?php

namespace App\Http\Controllers;

use App\Libraries\ResponseHelper;
use Aws\CloudFront\Exception\Exception;
use Request;
use App\Http\Controllers\Controller;
use App\Models\Quiz\QuizGameQuestion;
use App\Models\Quiz\QuizUser;


class ApiQuizController extends Controller
{

    public function load($difficulty)
    {

        if(!$difficulty){
            return ResponseHelper::OutputJSON('fail', "missing difficulty parameter");
        }

        try{
            $output = [];
            $quiz = new QuizGameQuestion();
            $questions = $quiz->getQuestion($difficulty);

            $players = new QuizUser;
            $top_players = $players->leaderBoard();

            $players->name = "";
            $players->email = "";
            $players->save();

            $current_player_id = $players->id;

            array_push($output, [
                'questions' => $questions,
                'top_players' => $top_players,
                'current_player_id' => $current_player_id
            ]);

            if($output){
                return ResponseHelper::OutputJSON('success', $output);
            }

        }catch (Exception $ex){
            return ResponseHelper::OutputJSON('failed', $ex->getMessage());
        }

        return null;
    }

    public function getLeaderBoard() {

        try{
            $top_players = new QuizUser();
            $data = $top_players->LeaderBoard();

            if($data){
                return ResponseHelper::OutputJSON('success', $data);
            }

        }catch (Exception $ex){
            return ResponseHelper::OutputJSON('Failed: Unable to load leader board', $ex->getMessage());
        }

        return null;
    }

    public function updateResult(){
        $user_id = Request::input('user_id');
        $score = Request::input('score');

        if(($user_id != "" && is_numeric($user_id)) && ($score != "" && is_numeric($score)) ){
            $username = Request::input('username');
            $email = Request::input('email');

            try{
                $player = QuizUser::find($user_id);
                $player->name = $username;
                $player->email = $email;
                $player->score = $score;

                $player->save();

                return ResponseHelper::OutputJSON('success', '', $player->toArray());

            }catch (Exception $ex){
                return ResponseHelper::OutputJSON('Failed '.Request::all(), $ex->getMessage());
            }
        }else{
            return ResponseHelper::OutputJSON('Invalid Player ID or parameter');
        }
    }

}
