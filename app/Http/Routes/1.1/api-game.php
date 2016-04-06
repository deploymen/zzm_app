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
	
	//Route::post('/check-game-code' , 'ApiGameController@checkGameCode');

	Route::post('/game-code', 'ApiGameController@getGameCodeInfo');

	Route::group(['middleware' => 'auth.game'], function () {
		Route::put('/profiles', 'ApiProfileController@gameUpdate');

		Route::post('/verify-transfer', 'ApiProfileController@verifyCode');
		Route::post('/profile-transfer', 'ApiProfileController@profileTransfer');


		Route::post('/play/{id}/result', 'ApiGameController@resultV1_1');
		Route::get('/play/{id}/request/'  , 'ApiGameController@request');

		Route::post('/play/push-result/'  , 'ApiGameController@offlinePost');

		Route::get('/play/{id}/request/{language}', 'ApiGameController@request');
		// Route::get('/play/{id}/result', 'ApiGameController@winScreen');
		Route::get('/result/log', 'ApiGameController@resultLog');

		Route::get('/result/system-planet/progress', 'ApiGameController@systemPlanetProgress');
		Route::get('/result/system-planet/play/planet/{planet_id}', 'ApiGameController@systemPlanetPlay');

		Route::get('/user-map', 'ApiGameController@getUserMapV1_1');

		Route::get('/result/only-system', 'ResultController@onlySystem');
		Route::get('/result/only-planet', 'ResultController@onlyPlanet');
		Route::get('/result/only-play', 'ResultController@onlyPlay');
		Route::get('/result/only-questions', 'ResultController@onlyQuestions');
	});
});
 
Route::get('set/nick', 'ApiProfileController@getNick');
Route::post('game-code/anonymous', 'ApiProfileController@GenerateAnonymousGameCode');

Route::any('/{endpoint}', ['as' => 'try_prev_version', function(){die('NEED TO HANDLE1.2');}])->where('endpoint', '.*');