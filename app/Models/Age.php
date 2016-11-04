<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Age extends Eloquent {

    public $table = 't8905_age';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

}
