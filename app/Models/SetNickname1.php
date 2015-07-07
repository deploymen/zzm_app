<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SetNickname1 extends Eloquent{

	public $table = 't8901_set_nickname1';
	protected $primaryKey = 'id';
	public $timestamps = true;

	protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}