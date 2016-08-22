<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Questions\AbstractGameQuestion;

class CoinReward extends Eloquent {
	use SoftDeletes;

	public $table = 't8911_coin_reward_rule';
	protected $primaryKey = 'id';
	public $timestamps = false;

	public static function GetEntitleCoinReward($name, $desciption=''){
		return intval(self::where('name', $name)->where('desciption', $desciption)->select('coin_reward')->first()['coin_reward']);
	}

}
