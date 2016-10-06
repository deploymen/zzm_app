<?php
// =======================================================================//
// ! Game Profile(Kid)										 			      //
// =======================================================================//
Route::group(['prefix' => 'game'], function () {
	Route::get('/create-package', 'ApiGameController@createPackage');

	Route::post('/sign-up', 'AuthUserController@signUpApp');

	Route::get('/leaderboard/planet/{id}', 'ApiGameController@leaderBoardPlanet');

	Route::post('student-id/anonymous', 'ApiProfileController@GenerateAnonymousStudentId');

	Route::group(['middleware' => ['auth.student' , 'auth.cmd']], function () {
		Route::post('/student-id', 'ApiGameController@getStudentIdInfo');
		Route::post('/check-student-id' , 'ApiGameController@checkStudentIdV1_3');

		Route::put('/profiles', 'ApiProfileController@gameUpdateV1_3');

		Route::post('/verify-transfer', 'ApiProfileController@verifyCodeV1_3');
		Route::post('/profile-transfer', 'ApiProfileController@profileTransferV1_3');
		Route::post('/profile-transfer-loose', 'ApiProfileController@profileTransferLooseV1_3');

		Route::post('/play/{id}/result', 'ApiGameController@resultV1_3');
		Route::get('/play/{id}/request'  , 'ApiGameController@requestV1_3');

		Route::post('/play/push-result'  , 'ApiGameController@offlinePostV1_3');

		Route::get('/play/{id}/request/{language}', 'ApiGameController@request');

		Route::get('/user-map', 'ApiGameController@getUserMapV1_3');

		Route::get('/spaceship', 'ApiGameController@getSpaceship');
		Route::post('/spaceship/unlock/spaceship', 'ApiGameController@unlockSpaceship');
		Route::post('/spaceship/unlock/floor', 'ApiGameController@unlockFloor');
		Route::post('/spaceship/unlock/item', 'ApiGameController@unlockItem');
		Route::put('/spaceship/floor/{floor_id}/items', 'ApiGameController@spaceshipItemSelected');

		Route::put('add/coin' , 'ApiGameController@addCoin');
	});
});


Route::any('/{endpoint}', ['as' => 'try_prev_version', function(){die('NEED TO HANDLE1.3');}])->where('endpoint', '.*');

