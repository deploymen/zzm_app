<?php

// use Config;
App::setLocale('en'); 

require __DIR__.'/Routes/page-docs.php';
require __DIR__.'/Routes/api-cron.php';

Route::any('saml/acs', 'AuthSchoologyController@schoology');
Route::get('version' , function(){ 
	return response()->json([
		'servername' => Config::get('app.zzm_server'),
	]);
});

Route::group(['middleware' => 'version'], function () {


	Route::group(['prefix' => '/1.0'], function () {
		require __DIR__.'/Routes/1.0/api.php';
		require __DIR__.'/Routes/1.0/api-user.php';
		require __DIR__.'/Routes/1.0/api-game.php';
	});

	Route::group(['prefix' => '/1.1'], function () {
		require __DIR__.'/Routes/1.1/api.php';
		require __DIR__.'/Routes/1.1/api-user.php';
		require __DIR__.'/Routes/1.1/api-game.php';
	});

	Route::group(['prefix' => '/1.2'], function () {
		require __DIR__.'/Routes/1.2/api.php';
		require __DIR__.'/Routes/1.2/api-user.php';
		require __DIR__.'/Routes/1.2/api-game.php';
	});


	Route::group(['prefix' => '/1.3'], function () {
		require __DIR__.'/Routes/1.3/api.php';
		require __DIR__.'/Routes/1.3/api-user.php';
		require __DIR__.'/Routes/1.3/api-game.php';
	});
});
