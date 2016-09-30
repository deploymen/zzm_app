<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class SpaceshipUserFloor extends Eloquent {
	use SoftDeletes;
	
	protected $table = 't0140_spaceship_user_floor';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];
	protected $fillable = ['user_id', 'profile_id' , 'floor_id'];
} 
