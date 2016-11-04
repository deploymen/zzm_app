<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class AvatarSet extends Eloquent {

    public $table = 't8903_set_avatar';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

}
