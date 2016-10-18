<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogGameCoin extends Eloquent {

	public $table = 't9207_log_game_coin';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];

}