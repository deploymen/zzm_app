<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubsTransaction extends Eloquent {

    use SoftDeletes;

    public $table = 't0105_user_subs_transaction';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $hidden = [];
    protected $fillable = ['user_id', 'package_id', 'target_type', 'target_id', 'expired_at'];

}
