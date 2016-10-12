<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuizUser extends Model
{
    public $table = 't9999_quiz_users';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'score'];
    protected $limit = 10;


    public function leaderBoard(){

        $query = "SELECT * FROM {$this->table} WHERE score > :score ORDER BY score DESC LIMIT :limit";

        $users = DB::SELECT($query, [
            'score' => 0,
            "limit" => $this->limit
        ]);

        $output = [];

        if($users){
            foreach ($users as $user){
                array_push($output, [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'score' => $user->score
                ]);
            }
        }else{
            return "No user found";
        }

        return $output;
    }

}
