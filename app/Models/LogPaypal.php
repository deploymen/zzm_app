<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogPaypal extends Eloquent{

	public $table = 't9414_log_pay_pal';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];
}