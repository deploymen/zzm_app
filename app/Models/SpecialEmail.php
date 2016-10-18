<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SpecialEmail extends Eloquent{

	public $table = 't8906_special_email';
	protected $primaryKey = 'id';
	public $timestamps = true;

	protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}