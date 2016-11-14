<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;

class QuizUserLog extends Model
{
    public $table = 't9999_quiz_user_log';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'school', 'state', 'hide', 'score'];

}
