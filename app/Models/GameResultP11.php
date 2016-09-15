<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameResultP11 extends Eloquent {

	public $table = 't0311_game_result_p11';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

}