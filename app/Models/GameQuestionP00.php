<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameQuestionP00 extends Eloquent {

	public $table = 't0200_game_question_p00';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

}