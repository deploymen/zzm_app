<?php

Route::group(['prefix' => '0/admin'], function(){
	Route::get('/home', function(){ return view('contents.admin.index-admin'); });
});

Route::group(['prefix' => '0/admin'], function(){
	Route::get('/admin-account', function(){ return view('contents.admin.admin-account'); });
});

Route::group(['prefix' => '0/admin'], function(){
	Route::get('/admin-change-password', function(){ return view('contents.admin.admin-change-password'); });
});

Route::group(['prefix' => '0/admin'], function(){
	Route::get('/reports', function(){ return view('contents.admin.admin-reports'); });
});

