<?php namespace App\Libraries;

use Config;

class AuthHelper{

	public static function GenerateAccessToken($userId)
	{
		return $userId.'|'.sha1(time().Config::get('app.auth_salt'));	
	}
}