<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogSignInAdmin extends Eloquent {

    public $table = 't9407_log_signin_admin';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $hidden = [];

}
