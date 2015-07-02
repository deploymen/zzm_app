<?php

Route::group(['prefix' => 'member'], function(){

	Route::group(['middleware' => 'auth.member'], function(){
		Route::get('/', function(){ die('MEMBER HOME'); });

		Route::get('/withdrawal', function(){ return View::make('contents.member.withdrawal-list'); });
		Route::get('/withdrawal/request', function(){ return View::make('contents.member.withdrawal-request'); });

		Route::get('/deposit', function(){ return View::make('contents.member.deposit-list'); });
		Route::get('/deposit/request', function(){ return View::make('contents.member.deposit-request'); });

		Route::get('/accounts', function(){ return View::make('contents.member.accounts'); });
		Route::get('/accounts/{id}', function(){ return View::make('contents.member.accounts-profile'); });	
	});
});