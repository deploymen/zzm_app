<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFlag extends Eloquent{
	use SoftDeletes;

	public $table = 't0105_user_flag';
	protected $primaryKey = 'user_id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];
}