<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAccess extends Eloquent{
	use SoftDeletes;

	public $table = 't0102_user_access';
	protected $primaryKey = 'user_id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];
}