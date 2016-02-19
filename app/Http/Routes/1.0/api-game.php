<?php
use Illuminate\Support\Facades\Route;
// =======================================================================//
// ! Game Profile(Kid)										 			      //
// =======================================================================//

Route::group(['middleware' => 'auth.game'], function () {
	Route::group(['prefix' => '1.0/game/profiles'], function () {
			Route::put('/', 'ApiProfileController@gameUpdate');
	});
});



Route::group(['prefix' => '1.0/game'], function () {
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

	Route::post('/check-game-code' , 'ApiGameController@checkGameCode');

	Route::group(['middleware' => 'auth.game'], function () {
		Route::post('/verify-transfer', 'ApiProfileController@verifyCode');
		Route::post('/profile-transfer', 'ApiProfileController@profileTransfer');


		Route::post('/play/{id}/result', 'ApiGameController@result');
		Route::get('/play/{id}/request/'  , 'ApiGameController@request');

		Route::post('/play/push-result/'  , 'ApiGameController@offlinePost');

		Route::get('/play/{id}/request/{language}', 'ApiGameController@request');
		// Route::get('/play/{id}/result', 'ApiGameController@winScreen');
		Route::get('/result/log', 'ApiGameController@resultLog');

		Route::get('/result/system-planet/progress', 'ApiGameController@systemPlanetProgress');
		Route::get('/result/system-planet/play/planet/{planet_id}', 'ApiGameController@systemPlanetPlay');

		Route::get('/user-map', 'ApiGameController@getUserMap');

		Route::get('/result/only-system', 'ResultController@onlySystem');
		Route::get('/result/only-planet', 'ResultController@onlyPlanet');
		Route::get('/result/only-play', 'ResultController@onlyPlay');
		Route::get('/result/only-questions', 'ResultController@onlyQuestions');
	});
});


Route::get('1.0/set/nick', 'ApiProfileController@getNick');
