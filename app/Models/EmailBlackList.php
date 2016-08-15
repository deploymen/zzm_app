<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailBlackList extends Eloquent {
	
	public $table = 't0108_email_blacklist';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $dates = [];

	protected $hidden = ['deleted_at'];

}
	