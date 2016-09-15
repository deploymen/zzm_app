<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameResultP13 extends Eloquent {

	public $table = 't0313_game_result_p13';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

}