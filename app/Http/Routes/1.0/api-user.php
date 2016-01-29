<?php

// =======================================================================//
// ! Parent | Teacher												      //
// =======================================================================//

Route::group(['middleware' => 'auth.user'], function () {
	Route::group(['middleware' => 'auth.parent'], function () {
		Route::group(['prefix' => '/1.0/profiles'], function () {
			Route::get('/', 'ApiProfileController@get');
			Route::post('/', 'ApiProfileController@create');
			Route::get('/{id}', 'ApiProfileController@getProfile');
			Route::put('/{id}/edit', 'ApiProfileController@update');
			Route::delete('/{id}', 'ApiProfileController@delete');

		});
	});
});

// =======================================================================//
// ! Teacher only 														  //
// =======================================================================//
Route::group(['middleware' => 'auth.user'], function () {
	Route::group(['middleware' => 'auth.teacher'], function () {
		Route::group(['prefix' => '1.0/class'], function () {
			Route::get('/', 'ApiClassController@get');
			Route::post('/', 'ApiClassController@create');
			Route::put('/{id}', 'ApiClassController@update');
			Route::delete('/{id}', 'ApiClassController@delete');

			Route::put('/add-to-class', 'ApiClassController@addProfile');
			Route::get('/{id}/profiles', 'ApiClassController@getProfile');

			Route::get('/{class_id}', 'ApiClassController@getGameClass');

		});
	});
});

Route::group(['middleware' => 'auth.user'], function () {
	Route::group(['middleware' => 'auth.parent'], function () {
		Route::group(['prefix' => '1.0/user'], function () {
			Route::put('/{id}/edit', 'AuthUserController@update');
		});
	});
});

Route::post('1.0/game-code/anonymous', 'ApiProfileController@GenerateAnonymousGameCode');

Route::group(['middleware' => 'auth.user'], function () {
	Route::group(['prefix' => '1.0/profiles'], function () {
/* fade domain name */
		Route::get('/result/only-system', 'ResultController@onlySystem');
		Route::get('/result/only-planet', 'ResultController@onlyPlanet');
		Route::get('/result/only-play', 'ResultController@onlyPlay');
		Route::get('/result/only-questions', 'ResultController@onlyQuestions');

		Route::get('/report/profile-details', 'ApiProfileController@profileDetails');

	});
});


//third party login
	Route::get('1.0/auth/facebook', 'AuthUserController@redirectToProvider');
	Route::get('1.0/auth/facebook/callback', 'AuthUserController@handleProviderCallback');
	
Route::group(['middleware' => 'auth.user'], function () {
	Route::delete('1.0/remove/account', 'AuthUserController@deleteAccount');
});
