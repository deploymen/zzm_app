<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class IdCounter extends Eloquent {

    public $table = 't9101_id_counter';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $hidden = [];

}
