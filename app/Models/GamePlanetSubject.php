<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class GamePlanetSubject extends Eloquent {

    public $table = 't0132_game_planet_subject';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

    public function schedule() {
        return $this->hasOne('App\Models\GameSubjectSchedule', 'subject_id', 'subject_id');
    }

}
