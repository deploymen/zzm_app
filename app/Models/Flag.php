<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Flag extends Eloquent {

    public $table = 't8905_flag';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $dates = [];
    protected $hidden = ['deleted_at'];

}
