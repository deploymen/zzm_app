<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class AdminAccess extends Eloquent {

    public $table = 't8882_user_admin_access';
    protected $primaryKey = 'user_id';
    public $timestamps = true;
    protected $hidden = [];

    public function profile() {
        return $this->belongsTo('Admin', 'user_id', 'id');
    }

}
