<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserRelation extends Eloquent {

    protected $table = 't0103_user_relation';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

}
