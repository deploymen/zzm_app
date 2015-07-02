<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogInsert extends Eloquent{

	public $table = 't9411_log_insert';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];

}