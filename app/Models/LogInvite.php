<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogInvite extends Eloquent {

    public $table = 't9203_log_invite_parent';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $hidden = [];

}
