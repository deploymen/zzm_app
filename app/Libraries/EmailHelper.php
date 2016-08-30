<?php namespace App\Libraries;

use Aws\Common\Aws;
use Aws\Common\Credentials\Credentials;
use Config;
use App\Models\PlayThresholdFail;
use App\Models\GameProfile;
use App\Models\UserMap;

class EmailHelper {

	public static function SendEmail($params) {
		$params = array_merge([
			'about' => '',
			'subject' => '',
			'body' => '',
			'bodyHtml' => '',
			'toAddresses' => [],
			'bccAddresses' => [],
			'replyToAddresses' => [Config::get('app.support_email')],
		], $params);

		$credentials = new Credentials(Config::get('app.ses_key'), Config::get('app.ses_secret'));
		$aws = Aws::factory([
			'credentials' => $credentials,
			'region' => 'us-west-2',
		]);
		$client = $aws->get('Ses');

		$result = $client->sendEmail([
			'Source' => 'Zap Zap Math<' . Config::get('app.support_email') . '>',
			'Destination' => [
				'ToAddresses' => $params['toAddresses'],
				'CcAddresses' => [],
				'BccAddresses' => $params['bccAddresses'],
			],
			'Message' => [
				'Subject' => [
					'Data' => "[" . $params['about'] . "] " . $params['subject'],
					'Charset' => 'utf8',
				],

				'Body' => [
					'Text' => [
						'Data' => $params['body'],
						'Charset' => 'utf8',
					],
					'Html' => [
						'Data' => $params['bodyHtml'],
						'Charset' => 'utf8',
					],
				],
			],
			'ReplyToAddresses' => $params['replyToAddresses'],
			'ReturnPath' => Config::get('app.support_email'),
		]);
	}

	public static function SendNotify($params){
		$profileId = $params['profile_id'];
		$planetId = $params['planet_id'];
		$difficulty = $params['difficulty'];

		$gameProgress = PlayThresholdFail::where('profile_id' , $profileId)
									->where('planet_id' , $planetId)
									->where('difficulty', $difficulty)
									->first();

		$count = ($gameProgress)?$gameProgress->fail_count:0;

		switch(true){
			case $count == 0 : self::SendGoodNews($profileId , $planetId); break;
			case $count > 0 : self::SendBadNews($profileId); break;
		}
	}

	static function SendGoodNews($profileId , $planetId){
		$userMap = UserMap::where('profile_id' , $profileId)->where('planet_id' , $planetId)->first();

		if($userMap->sent == 1 || $userMap->star != 5){
			return True;
		}

		$profile = GameProfile::find($profileId)->User;

		$edmHtml = (string) view('emails.news-good', [

			]);
		
		self::SendEmail([
			'about' => 'Welcome',
			'subject' => 'Your Zap Zap Account is now ready!',
			'body' => $edmHtml,
			'bodyHtml' => $edmHtml,
			'toAddresses' => [$profile->email],
		]);

		$userMap->sent = 1;
		$userMap->save();

	}

	static function SendBadNews($profileId){
		
		$profile = GameProfile::find($profileId)->User;

		$edmHtml = (string) view('emails.news-bad', [
			
			]);
		
		self::SendEmail([
			'about' => 'Welcome',
			'subject' => 'Your Zap Zap Account is now ready!',
			'body' => $edmHtml,
			'bodyHtml' => $edmHtml,
			'toAddresses' => [$profile->email],
		]);
	}
}
