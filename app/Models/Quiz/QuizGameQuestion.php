<?php

namespace App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use DB;

class QuizGameQuestion extends Model
{
    public $table = 't9999_quiz_question';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $limit = 10;

    public function getQuestion($difficulty) {

        $game_difficulty = $difficulty;

        $query = "SELECT * FROM {$this->table} WHERE difficulty = :difficulty
                   ORDER BY rand() LIMIT :limit";

        $questions = DB::SELECT($query, [
            'difficulty' => $game_difficulty,
            'limit' => $this->limit
        ]);

        $output = [];

        if(count($questions) > 0){
            foreach ($questions as $question) {
                array_push($output, [
                    'question_id' => $question->id,
                    'param_1'=> $question->param_1,
                    'param_2'=> $question->param_2,
                    'param_3'=> $question->param_3,
                    'param_4'=> $question->param_4,
                    'param_5'=> $question->param_5,
                    'param_6'=> $question->param_6,
                    'param_7'=> $question->param_7,
                    'hexagon_path'=> $question->hexagon_path,
                    'difficulty'=> $question->difficulty,
                ]);
            }
        }else{
            return "No record found";
        }

        return $output;
    }

}
