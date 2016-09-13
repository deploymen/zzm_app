<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GameQuestion;
class StudentIdChange extends Eloquent {

	public $table = 't0111_student_id_change';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $fillable = ['user_id', 'profile_id', 'student_id' ];
	protected $hidden = [];

}