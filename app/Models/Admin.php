<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Eloquent {

    use SoftDeletes;

    public $table = 't8881_user_admin';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

    public function access() {

        return $this->hasMany('AdminAccess', 'user_id');
    }

}
