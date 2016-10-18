<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\CampaignReferralSubscribe;
class CampaignReferralHit extends Eloquent{
use SoftDeletes;

	protected $table = 't1103_campaign_referral_hit';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $hidden = ['created_at' , 'updated_at' , 'deleted_at'];

	protected $fillable = ['user_id', 'campaign_id' , 'hit_user_id'];

	public static function insert($userId , $param){
		if(!$param){
			return true;
		}

		$ids = explode('/', $param);

		self::create([
			'campaign_id' => $ids[0],
			'user_id' => $ids[1],
			'hit_user_id' => $userId,
			]);

		CampaignReferralSubscribe::where('user_id' , $ids[1])->where('campaign_id' , $ids[0])->update([
			'hit' => DB::raw('hit + 1')
			]);

	}
}