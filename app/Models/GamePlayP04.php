<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class GamePlayP04 extends Eloquent {

    public $table = 't0404_game_play_p04';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

}
