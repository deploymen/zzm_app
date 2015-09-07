
<?php

Route::pattern('role', '(parent)|(teacher)|(admin)|(content)|(investor)');

// =======================================================================//
// ! Auth Related												          //
// =======================================================================//
Route::group(['prefix' => 'api/auth'], function () {
	Route::post('/sign-up', 'AuthUserController@signUp'); //only for parent|teacher
	Route::post('/sign-in', 'AuthUserController@signIn');
	Route::post('/sign-out', 'AuthUserController@signOut');

	Route::post('/connect/facebook', 'AuthUserController@connectFacebook');
	Route::post('/connect/google', 'AuthUserController@connectGoogle');

	Route::get('/activate/{secret_key}', 'AuthUserController@activate');
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

Route::post('/api/worksheets', 'ApiQuestionBankController@createGameWorksheet');


Route::get('/api/flag', 'ApiCmsController@getFlag');


Route::group(['prefix' => 'api/pre-launch'], function(){
	Route::post('/subscribe', 'ApiController@subscribe');
	Route::post('/contact-us', 'ApiController@contactUs');
	Route::get('/subscribe-external', 'ApiController@subscribeExternal');

});