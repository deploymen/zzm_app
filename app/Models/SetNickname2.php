<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SetNickname2 extends Eloquent{

	public $table = 't8902_set_nickname2';
	protected $primaryKey = 'id';
	public $timestamps = true;

	protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}