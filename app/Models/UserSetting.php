<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSetting extends Eloquent {

    use SoftDeletes;

    public $table = 't0104_user_setting';
    protected $primaryKey = 'user_id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

}
