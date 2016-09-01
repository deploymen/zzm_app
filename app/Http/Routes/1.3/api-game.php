<?php
// =======================================================================//
// ! Game Profile(Kid)										 			      //
// =======================================================================//
Route::group(['prefix' => 'game'], function () {
	Route::get('/create-package', 'ApiGameController@createPackage');

	Route::post('/sign-up', 'AuthUserController@signUpApp');
	
	Route::post('/map/system', 'ApiGameController@mapSystem');
	Route::post('/map/system/{id}/planet', 'ApiGameController@mapPlanet');

	Route::get('/profile/{profile_id}/result/system-planet/progress', 'ApiGameController@systemPlanetProgress');
	Route::get('/profile/{profile_id}/result/system-planet/planet/{planet_id}', 'ApiGameController@systemPlanetPlay');


	Route::get('/leaderboard/world' , 'ApiGameController@leaderBoardWorld');
	Route::get('/leaderboard/system/{id}', 'ApiGameController@leaderBoardSystem');
	Route::get('/leaderboard/planet/{id}', 'ApiGameController@leaderBoardPlanet');

	Route::get('/top-score', 'ApiGameController@GameScreenTopScore');
	
	Route::post('/check-game-code' , 'ApiGameController@checkGameCodeV1_3');

	Route::post('/game-code', 'ApiGameController@getGameCodeInfoV1_3');

	Route::group(['middleware' => 'auth.student'], function () {
		Route::put('/profiles', 'ApiProfileController@gameUpdate');

		Route::post('/verify-transfer', 'ApiProfileController@verifyCode');
		Route::post('/profile-transfer', 'ApiProfileController@profileTransfer');
		Route::post('/profile-transfer-loose', 'ApiProfileController@profileTransferLoose');


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
	});
});
 

Route::get('set/nick', 'ApiProfileController@getNick');
Route::post('game-code/anonymous', 'ApiProfileController@GenerateAnonymousGameCodeV1_3');
Route::post('elf/test-function' , 'ApiGameController@testGetELFPlanet' );

Route::any('/{endpoint}', ['as' => 'try_prev_version', function(){die('NEED TO HANDLE1.3');}])->where('endpoint', '.*');

