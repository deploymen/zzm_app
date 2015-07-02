<?php
 
// =======================================================================//
// ! Parent | Teacher												      //
// =======================================================================//

Route::group(['middleware' => 'auth.user'], function () {
	Route::group(['middleware' => 'auth.parent'], function () {
		Route::group(['prefix' => 'api/profiles'], function () {
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
		Route::group(['prefix' => 'api/class'], function () {
			Route::get('/', 'ApiClassController@get');
			Route::post('/', 'ApiClassController@create');
			Route::put('/{id}', 'ApiClassController@update');
			Route::delete('/{id}', 'ApiClassController@delete');

			Route::post('/{id}/profile', 'ApiClassController@addProfile');
			Route::put('/{id}/profile', 'ApiClassController@removeProfile');
		});
	});
});

Route::group(['middleware' => 'auth.user'], function () {
	Route::group(['middleware' => 'auth.parent'], function () {
		Route::group(['prefix' => 'api/user'], function () {
			Route::put('/{id}/edit', 'AuthUserController@update');
		});
	});
});



Route::post('api/game-code/anonymous', 'ApiProfileController@GenerateAnonymousGameCode');