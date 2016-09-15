<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\CampaignReferral;
use App\Models\GameClass;
use App\Models\GameProfile;

class CampaignReferralSubscribe extends Eloquent{
use SoftDeletes;

	protected $table = 't1102_campaign_referral_subscribe';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $fillable = ['user_id', 'campaign_id', 'hit', 'redeemed_at', 'redeemed_remark', 'expired_at'];
	protected $hidden = ['created_at' , 'updated_at' , 'deleted_at'];
	
	public function campaign(){
		return $this->hasOne('App\Models\CampaignReferral' , 'id' , 'campaign_id');
	}

	public function scopeExpired($query){
		return $query->where('expired_at' , '>' , DB::raw('now()'));
	}

	public static function CheckSubscribe2016RefferalCampaign($user){


		$cmpTeacher = [1,2];
		$cmpParent = [3,4];

		shuffle($cmpTeacher);
		shuffle($cmpParent);

		$subscription = $user->subscriptions_2016Refferal->first();

 		if(!$subscription){
 			switch($user->role){
 				case 'teacher' : $campaignId = head($cmpTeacher);
 				break;
 				case 'parent' :  $campaignId = head($cmpParent) ;
 				break;
 			}

 			$campaign = CampaignReferral::find($campaignId);

 			$subscription = self::create([
	 			'user_id' => $user->id,
	 			'campaign_id' => $campaignId,
	 			'expired_at' => DB::raw('DATE_ADD(NOW(), INTERVAL '.$campaign->challenge_length.' DAY)'),
			]);

			$subscription = self::find($subscription->id);
 		}
 		$subscription->campaign;

 		return $subscription;
	}

	public static function RedeemReward($referralCode){
		$ids = explode('/', $referralCode);
		$campaingId = $ids[0];
		$userId = $ids[1];

		$user = User::find($userId);

		$subscribe = self::where('user_id' , $userId)
						->expired()
						->first();

		$campaignReferral = CampaignReferral::where('id' , $campaingId)
						->expired()
						->first();
		
		if(!$subscribe || !$campaignReferral){
			return false;
		}

		if($subscribe->hit != 5  || !$campaignReferral->enable){
			return false;
		}
		
		switch($user->role){
			case 'teacher' : GameClass::where('user_id' , $userId)->whereNull('expired_at')->orderBy('created_at' , 'asc')->first()->update([ 
								'expired_at' => DB::Raw('DATE_ADD(NOW(), INTERVAL '.$campaignReferral->reward_item_length.' DAY)') 
							]); 
			break;
			case 'parent' : GameProfile::where('user_id' , $userId)->whereNull('expired_at')->orderBy('created_at' , 'asc')->first()->update([
								'expired_at' => DB::Raw('DATE_ADD(NOW(), INTERVAL '.$campaignReferral->reward_item_length.' DAY)')
							]); 
			break;
		}
	
		$subscribe->update([
			'expired_at' => DB::RAW('now()'),
			'redeemed_at' => DB::RAW('now()'),
			'redeemed_remark' => $campaignReferral->name,
			]);

		return true;
	}

	
}