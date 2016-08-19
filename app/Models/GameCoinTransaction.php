<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class GameCoinTransaction extends Eloquent {

	public $table = 't0114_game_coin_transaction';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];

}