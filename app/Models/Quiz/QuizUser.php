<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuizUser extends Model
{
    public $table = 't9999_quiz_users';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'school', 'state', 'hide', 'score'];
    protected $limit = 10;

    /**
     * @return array [top ten players with their position]|string "Null"
     */
    public function leaderBoard(){

        $query = "SELECT * FROM {$this->table} WHERE score > :score AND hide = :hide ORDER BY score DESC LIMIT :limit";

        $users = DB::SELECT($query, [
            'score' => 0,
            'hide' => 0,
            "limit" => $this->limit
        ]);

        $output = [];

        if($users){
            $index = 1;

            $positions = array('th','st','nd','rd','th','th','th','th','th','th');

            foreach ($users as $user){
                array_push($output, [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'school' => $user->school,
                    'state' => $user->state,
                    'score' => $user->score,
                    'position' => $index.$positions[$index % 10]
                ]);

                $index++;
            }
        }else{
            return "No user found";
        }

        return $output;
    }

    /**
     * Delete Quiz users who didn't finish the game after 3 mins of launching the game and reset autoincrement ID
     */
    public static function deleteInactivePlayers() {

        $query = "DELETE FROM t9999_quiz_users WHERE email = :email AND `name` = :username AND finished_game = :finished_game
                        AND created_at < (NOW() - INTERVAL 5 MINUTE)";

        DB::DELETE($query, [
            'email' => 'anonymous',
            'username' => 'anonymous',
            'finished_game' => 0
        ]);

        $max = DB::SELECT("SELECT id FROM t9999_quiz_users ORDER BY id DESC LIMIT 1");

        foreach ($max as $maxId){
            $reset_id = "ALTER TABLE t9999_quiz_users AUTO_INCREMENT = {$maxId->id}";
        }

        DB::statement($reset_id);
    }

    /**
     * Delete Quiz users with ID greater than 10 and reset autoincrement ID to 11
     */
    public static function resetLeaderBoard() {

        $query = "DELETE FROM t9999_quiz_users WHERE id > :id";

         DB::DELETE($query, [
             'id' => 10
         ]);
    }

}
