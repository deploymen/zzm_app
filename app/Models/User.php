<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Eloquent {
	use SoftDeletes;

	public $table = 't0101_user';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $hidden = [];

	public function Access() {

		return $this->belongsTo('UserAccess', 'user_id', 'id');
	}

	public function campaigns_2016Refferal(){
		return $this->belongsToMany('App\Models\CampaignReferral', with(new CampaignReferralSubscribe)->getTable(), 'user_id', 'campaign_id');
	}

	public function subscriptions_2016Refferal(){
		return $this->hasMany('App\Models\CampaignReferralSubscribe' , 'user_id' , 'id');

	}	

}
