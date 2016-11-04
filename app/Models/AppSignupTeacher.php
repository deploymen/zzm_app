<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSignupTeacher extends Eloquent {

    use SoftDeletes;

    public $table = 't9104_app_signup_teacher';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $hidden = [];
    protected $fillable = ['user_id'];

}
