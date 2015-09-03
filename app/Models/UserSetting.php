<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserSetting extends Eloquent{

	public $table = 't0104_user_setting';
	protected $primaryKey = 'user_id';
	public $timestamps = true;

	protected $hidden = [];
}