<?php
// =======================================================================//
// ! Game Profile(Kid)										 			      //
// =======================================================================//
Route::group(['prefix' => 'game'], function () {
	Route::get('/create-package', 'ApiGameController@createPackage');

	Route::post('/sign-up', 'AuthUserController@signUpApp');

	Route::get('/profile/{profile_id}/result/system-planet/progress', 'ApiGameController@systemPlanetProgress');
	Route::get('/profile/{profile_id}/result/system-planet/planet/{planet_id}', 'ApiGameController@systemPlanetPlay');


	Route::get('/leaderboard/world' , 'ApiGameController@leaderBoardWorld');
	Route::get('/leaderboard/system/{id}', 'ApiGameController@leaderBoardSystem');
	Route::get('/leaderboard/planet/{id}', 'ApiGameController@leaderBoardPlanet');

	Route::get('/top-score', 'ApiGameController@GameScreenTopScore');
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
		// Route::get('/play/{id}/result', 'ApiGameController@winScreen');
		Route::get('/result/log', 'ApiGameController@resultLog');

		Route::get('/result/system-planet/progress', 'ApiGameController@systemPlanetProgress');
		Route::get('/result/system-planet/play/planet/{planet_id}', 'ApiGameController@systemPlanetPlay');

		Route::get('/user-map', 'ApiGameController@getUserMapV1_3');

		Route::get('/result/only-system', 'ResultController@onlySystemV1_1');
		Route::get('/result/only-planet', 'ResultController@onlyPlanetV1_1');
		Route::get('/result/only-questions', 'ResultController@onlyQuestions');

		Route::get('/spaceship', 'ApiGameController@getSpaceship');
		Route::post('/spaceship/unlock/floor', 'ApiGameController@unlockFloor');
		Route::post('/spaceship/unlock/item', 'ApiGameController@unlockItem');
		Route::put('/spaceship/floor/{floor_id}/items', 'ApiGameController@spaceshipItemSelected');

	});
});

Route::group(['middleware' => ['auth.student']], function () {
	Route::post('subscription/validation/apple' , 'ApiController@appleValidateSubscription');
});
	Route::post('subscription/profile' , 'ApiController@appleGetStudentIdByReceipt');

Route::get('set/nick', 'ApiProfileController@getNick');
Route::get('test/mission', 'ApiGameController@test');

Route::any('/{endpoint}', ['as' => 'try_prev_version', function(){die('NEED TO HANDLE1.3');}])->where('endpoint', '.*');

