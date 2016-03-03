<?php
Route::get('/', function () {return die('zzm-api');});
Route::get('/version', 'ApiController@getVersion');

Route::pattern('role', '(parent)|(teacher)|(admin)|(content)|(investor)');

// =======================================================================//
// ! Auth Related												          //
// =======================================================================//
Route::group(['prefix' => '1.0/auth'], function () {
	Route::post('/sign-up', 'AuthUserController@signUp'); //only for parent|teacher
	Route::post('/sign-in', 'AuthUserController@signIn');
	Route::post('/sign-out', 'AuthUserController@signOut');

	Route::post('/connect/facebook', 'AuthUserController@connectFacebook');
	Route::post('/connect/google', 'AuthUserController@connectGoogle');

	Route::get('/activate/{secret_key}', 'AuthUserController@activate');
	Route::post('/activate-code', 'AuthUserController@ResendACtivateCode');
	Route::put('/forgot-password', 'AuthUserController@forgotPassword');
	Route::put('/reset-password', 'AuthUserController@resetPassword');

	Route::post('/invite-parent', 'AuthUserController@invite');

	Route::group(['middleware' => 'auth.user'], function () {
		Route::post('/check', 'AuthUserController@check');
		Route::post('/change-password', 'AuthUserController@changePassword');
	});
});

// =======================================================================//
// ! Content											          //
// =======================================================================//

Route::post('/1.0/worksheets', 'ApiQuestionBankController@createGameWorksheet');

Route::get('/1.0/flag', 'ApiCmsController@getFlag');

Route::group(['prefix' => '1.0/pre-launch'], function () {
	Route::post('/subscribe', 'ApiController@subscribe');
	Route::post('/contact-us', 'ApiController@contactUs');
	Route::get('/subscribe-external', 'ApiController@subscribeExternal');

});

Route::post('1.0/launch-notification', 'ApiController@launchNotification');

Route::get('1.0/status', 'ApiCheckingController@CheckGameStatus');

Route::get('1.0/check-ip-details', 'ApiCheckingController@CheckIpDetails');

Route::get('saml/acs', 'schoologyController@schoology');