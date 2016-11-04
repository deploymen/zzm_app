<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GamePlanetSubject;

class GameSubject extends Eloquent {

    use SoftDeletes;

    public $table = 't0131_game_subject';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

    public function planets() {
        return $this->belongsToMany('App\Models\GamePlanet', with(new GamePlanetSubject)->getTable(), 'subject_id', 'planet_id');
    }

}
