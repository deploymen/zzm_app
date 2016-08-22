<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class GameCoinTransaction extends Eloquent {

	public $table = 't0114_game_coin_transaction';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = ['profile_id', 'description', 'coin_amount', 'coin_balance'];
	protected $hidden = [];

	public static function DoTransaction($profileId, $coin, $description){
		$profile = GameProfile::find($profileId);
		if(!$profile){ return false; }

		$profile->coin += $coin;
		$profile->save();

		self::create([
			'profile_id' => $profileId, 
			'description' => $profileId, 
			'coin_amount' => $coin,  
			'coin_balance' => $profile->coin, 
		]);

	}

	public static function GetDescription($template, $params){
		$templates = [
			'sign-up' => 'sign-up',
			'play-basic' => 'play-basic.planet-{planetId}.difficulty-{difficulty}',
			'play-hot' => 'play-hot.planet-{planetId}.difficulty-{difficulty}',
			'play-repeat' => 'play-repeat.planet-{planetId}.difficulty-{difficulty}',
			'play-daily' => 'play-daily.planet-{planetId}.difficulty-{difficulty}',
			'watch-tutorial' => 'watch-tutorial',
			'watch-video' => 'watch-video',
			'elf-mission' => 'elf-mission',
		];


		$template = $templates['$template'];
		foreach ($params as $key => $value) {
			$template = str_replace('{'.$key.'}', $value, $template);
		}

		return $template;
	}

}