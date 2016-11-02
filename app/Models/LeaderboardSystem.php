<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LeaderboardSystem extends Eloquent {

    public $table = 't0602_leaderboard_system';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

}
