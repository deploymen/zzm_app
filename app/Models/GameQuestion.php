<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Questions\AbstractGameQuestion;

class GameQuestion extends AbstractGameQuestion {
	use SoftDeletes;

	public $table = 't0200_game_question';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

}
