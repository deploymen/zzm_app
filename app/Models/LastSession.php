<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LastSession extends Eloquent {

	public $table = 't0601_last_session';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $hidden = [];

}