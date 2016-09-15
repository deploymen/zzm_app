<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameResultP08 extends Eloquent {

	public $table = 't0308_game_result_p08';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

}