<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class AppVersion extends Eloquent {

    public $table = 't0101_apps_version';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

}
