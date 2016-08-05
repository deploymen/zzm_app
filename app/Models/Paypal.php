<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Paypal extends Eloquent{

	public $table = 'try_pay_pal';
	protected $primaryKey = 'id';
	public $timestamps = true;

	protected $hidden = [];
}