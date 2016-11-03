<?php

namespace App\Models\Voucher;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    public $table = 't9415_2016-nov-conf';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'class_id', 'status'];
    public $timestamps = true;

}
