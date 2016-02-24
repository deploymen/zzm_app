<?php

// =======================================================================//
// ! Admin | Content | Investor											  //
// =======================================================================//
Route::group(['prefix' => '/2.0'], function () {

	Route::group(['middleware' => 'auth.user'], function () {
		Route::group(['middleware' => 'auth.content'], function () {

			Route::group(['prefix' => '/system'], function () {
				Route::get('/', 'ApiGameMapController@getSystem');
				Route::post('/', 'ApiGameMapController@createSystem');
				Route::put('/{id}', 'ApiGameMapController@updateSystem');
				Route::delete('/{id}', 'ApiGameMapController@deleteSystem');
			});


			Route::group(['prefix' => '/planet/'], function () {
				Route::get('/{id}', 'ApiGameMapController@getPlanet');
				Route::post('/', 'ApiGameMapController@createPlanet');
				Route::put('/{id}', 'ApiGameMapController@updatePlanet');
				Route::delete('/{id}', 'ApiGameMapController@deletePlanet');
			});

			Route::group(['prefix' => '/system-planet/'], function () {
				Route::post('/', 'ApiGameMapController@addToSystem');
			});

			Route::group(['prefix' => '/question-bank'], function () {
				Route::get('/', 'ApiQuestionBankController@get');
				Route::post('/', 'ApiQuestionBankController@create');
				Route::put('/{id}', 'ApiQuestionBankController@update');
				Route::delete('/{id}', 'ApiQuestionBankController@delete');
			});
		});
	});
});
