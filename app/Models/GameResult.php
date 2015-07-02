<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameResult extends Eloquent {

	public $table = 't0300_game_result';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

	public function SubjectCode() {
		return $this->hasOne('Models\QuestionSubject', 'id', 'question_id');
	}
}