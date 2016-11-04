<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CoinReward extends Eloquent {

    public $table = 't8911_coin_reward_rule';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function GetEntitleCoinReward($name, $description = '') {
        return intval(self::where('name', $name)->where('description', $description)->select('coin_reward')->first()['coin_reward']);
    }

}
