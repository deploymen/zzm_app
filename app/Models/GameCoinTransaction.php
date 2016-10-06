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
			'description' => $description, 
			'coin_amount' => $coin,  
			'coin_balance' => $profile->coin, 
		]);

		return true;
	}

	public static function DoPaymentTransaction($profileId, $coin, $description){
		$profile = GameProfile::find($profileId);
		if(!$profile){ return false; }

		$profile->coin -= $coin;

		if($profile->coin < 0){
			return false;
		}
		
		$profile->save();

		self::create([
			'profile_id' => $profileId, 
			'description' => $description, 
			'coin_amount' => $coin,  
			'coin_balance' => $profile->coin, 
		]);

		return true;
	}

	public static function GetDescription($template, $params = []){
		$templates = [
			'sign-up' => 'sign-up',
			'play-basic' => join('.', ['play-basic' , 'play-{playId}', 'planet-{planetId}', 'difficulty-{difficulty}', ]),
			'play-hot' => join('.', ['play-hot' , 'play-{playId}', 'planet-{planetId}', 'difficulty-{difficulty}', ]),
			'play-repeat' => join('.', ['play-repeat' , 'play-{playId}', 'planet-{planetId}', 'difficulty-{difficulty}', ]),
			'play-daily' => join('.', ['play-daily' , 'play-{playId}', ]),
			'watch-tutorial' => join('.', ['watch-tutorial' , 'play-{playId}', ]),
			'watch-video' => 'watch-video',
			'elf-mission' => 'elf-mission',
		];


		$template = $templates[$template];
		foreach ($params as $key => $value) {
			$template = str_replace('{'.$key.'}', $value, $template);
		}

		return $template;
	}

}