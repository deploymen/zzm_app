<?php

/*Route::get('/', function(){ return Redirect::to('/pre-launch'); });*/

Route::group(['prefix' => 'edm'], function(){

	Route::get('/', function(){ return view('emails.edm-index'); });
	Route::get('/subscribe-responder', function(){ return view('emails.prelaunch-thank-you'); });
	Route::get('/forgot-password', function(){ return view('emails.forgot-password'); });
	Route::get('/account-activation', function(){ return view('emails.account-activation'); });
	Route::get('/invitation', function(){ return view('emails.invitation'); });
});
