<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailWhiteList extends Eloquent {
	
	public $table = 't0106_email_whitelist';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $dates = [];

	protected $hidden = ['deleted_at'];

}
