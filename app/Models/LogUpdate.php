<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogUpdate extends Eloquent{

	public $table = 't9412_log_update';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];

}