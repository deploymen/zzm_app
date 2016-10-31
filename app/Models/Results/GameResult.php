<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\SoftDeletes;

class GameResult extends AbstractGameResult {

    public $table = 't0300_game_result';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['play_id', 'question_id', 'target_type', 'target_id', 'game_type_id', 'correct'];
    protected $hidden = [];

}
