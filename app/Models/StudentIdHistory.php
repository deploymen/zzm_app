<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentIdHistory extends Eloquent {
	use SoftDeletes;
	
	public $table = 't9103_student_id_history';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = [];

	protected $hidden = [];
	protected $fillable = ['student_id' , 'created_at' , 'updated_at' , 'deleted_at'];

}
