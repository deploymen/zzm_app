<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class EmailPending extends Eloquent {

    public $table = 't0107_email_pending';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $dates = [];
    protected $hidden = ['deleted_at'];

}
