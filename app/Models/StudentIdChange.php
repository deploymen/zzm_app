<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class StudentIdChange extends Eloquent {

    public $table = 't9103_student_id_change';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'profile_id', 'student_id'];
    protected $hidden = [];

    public function profile() {
        return $this->hasOne('App\Models\GameProfile', 'id', 'profile_id');
    }

}
