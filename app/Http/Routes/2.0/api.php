<?php
Route::get('/', function () {return die('zzm-api');});
Route::get('/version', 'ApiController@getVersion');

Route::pattern('role', '(parent)|(teacher)|(admin)|(content)|(investor)');


Route::group(['prefix' => '2.0'], function () {

	// =======================================================================//
	// ! Auth Related												          //
	// =======================================================================//
	Route::group(['prefix' => '/auth'], function () {
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

	Route::post('/worksheets', 'ApiQuestionBankController@createGameWorksheet');

	Route::get('/flag', 'ApiCmsController@getFlag');

	Route::group(['prefix' => '/pre-launch'], function () {
		Route::post('/subscribe', 'ApiController@subscribe');
		Route::post('/contact-us', 'ApiController@contactUs');
		Route::get('/subscribe-external', 'ApiController@subscribeExternal');

	});

	Route::post('/launch-notification', 'ApiController@launchNotification');

	Route::get('/status', 'ApiCheckingController@CheckGameStatus');

	Route::get('/check-ip-details', 'ApiCheckingController@CheckIpDetails');

	Route::get('send/email', 'ApiController@sendEmail');

});
