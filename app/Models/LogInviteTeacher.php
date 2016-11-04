<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class LogInviteTeacher extends Eloquent {

    public $table = 't9203_log_invite_teacher';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $hidden = [];

}
