<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogPasswordReset extends Eloquent {

	public $table = 't9202_log_password_reset';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];

}