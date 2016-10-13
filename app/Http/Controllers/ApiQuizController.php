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
            $quiz = new QuizGameQuestion();
            $questions = $quiz->getQuestion($difficulty);

            QuizUser::deleteInactivePlayers();

            $players = new QuizUser;
            $top_players = $players->leaderBoard();

            $players->name = "";
            $players->email = "";
            $players->save();

            $current_player_id = $players->id;

            return ResponseHelper::OutputJSON('success', '', ['questions' => $questions,
                'top_players' => $top_players,
                'current_player_id' => $current_player_id
            ]);

        }catch (Exception $ex){
            return ResponseHelper::OutputJSON('failed', $ex->getMessage());
        }

    }

    public function getLeaderBoard() {

        try{
            $top_players = new QuizUser();
            $data = $top_players->leaderBoard();

            return ResponseHelper::OutputJSON('success', '', [
                'leader_board' => $data
            ]);

        }catch (Exception $ex){
            return ResponseHelper::OutputJSON('Failed: Unable to load leader board', $ex->getMessage());
        }
    }

    public function updateResult(){
        $user_id = Request::input('user_id');
        $score = Request::input('score');

        if(($user_id != "" && is_numeric($user_id)) && ($score != "" && is_numeric($score)) ){
            $username = Request::input('name');
            $email = Request::input('email');

            try{
                $player = QuizUser::find($user_id);
                $player->name = $username;
                $player->email = $email;
                $player->score = $score;
                $player->finished_game = 1;

                $player->save();

                return ResponseHelper::OutputJSON('success', '', [
                    'player_result' => $player->toArray()
                ]);

            }catch (Exception $ex){
                return ResponseHelper::OutputJSON('Failed '.Request::all(), $ex->getMessage());
            }
        }else{
            return ResponseHelper::OutputJSON('Invalid Player ID or parameter');
        }
    }

}
