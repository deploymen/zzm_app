<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameQuestionp06 extends Eloquent {
	use SoftDeletes;

	public $table = 't0206_game_question_p06';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

}
