<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogGetQuestions extends Eloquent {

    public $table = 't9204_log_get_question';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $hidden = [];

}
