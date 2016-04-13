<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameResultP19 extends Eloquent {

	public $table = 't0319_game_result_p19';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

}