<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogSignInUser extends Eloquent {

    public $table = 't9406_log_signin_user';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $hidden = [];

}
