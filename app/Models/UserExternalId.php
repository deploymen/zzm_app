<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserExternalId extends Eloquent{

	public $table = 't0103_user_external_id';
	protected $primaryKey = 'user_id';
	public $timestamps = true;

	protected $hidden = [];
}