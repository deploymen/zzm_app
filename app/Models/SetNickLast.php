<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SetNickLast extends Eloquent{

	public $table = 't8902_set_nick_lastname';
	protected $primaryKey = 'id';
	public $timestamps = true;

	protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}