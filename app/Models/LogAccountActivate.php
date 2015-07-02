<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogAccountActivate extends Eloquent {

	public $table = 't9201_log_account_activate';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];

	public function findUser() {
		return $this->hasOne('Models\User', 'id', 'user_id');
	}

}