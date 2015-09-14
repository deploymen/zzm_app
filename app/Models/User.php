<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Eloquent {
	use SoftDeletes;

	public $table = 't0101_user';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

	public function Access() {

		return $this->belongsTo('UserAccess', 'user_id', 'id');
	}

}
