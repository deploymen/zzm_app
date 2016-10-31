<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LeaderBoardPlanet extends Eloquent {

    public $table = 't0603_leaderboard_planet';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

}
