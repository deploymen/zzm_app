<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Grade extends Eloquent {

    public $table = 't8904_grade';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

}
