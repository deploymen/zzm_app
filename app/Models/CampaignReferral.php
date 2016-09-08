<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class CampaignReferral extends Eloquent{
use SoftDeletes;

	protected $table = 't1101_campaign_referral';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $hidden = ['created_at' , 'updated_at' , 'deleted_at'];
	

}