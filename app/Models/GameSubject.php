<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameSubject extends Eloquent {
	use SoftDeletes;

	public $table = 't0131_game_subject';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

	public static function GetNextPlanets($order , $planetId){
		switch ($order){
			case 'next' : $nxtPlanet = GameSubject::where('planet_from', $planetId)->select('planet_to')->get()->shuffle();
			case 'prev' : $nxtPlanet = GameSubject::where('planet_to' , $planetId)->select('planet_from')->get()->shuffle();
		}

		return $nxtPlanet;
	}
}
