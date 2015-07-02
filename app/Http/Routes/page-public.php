<?php
  
Route::get('/', function(){ return Redirect::to('/home'); });

Route::get('/home', function(){ return view('contents.website.index',['navSelPrimary'=>'home']); });

Route::group(['prefix' => 'about'], function(){
	Route::get('/company-profile', function(){ return view('contents.website.about.company-profile',['navSelPrimary'=>'about']); });
	Route::get('/legal-documents', function(){ return view('contents.website.about.legal-documents',['navSelPrimary'=>'about']); });
	Route::get('/company-policy', function(){ return view('contents.website.about.company-policy',['navSelPrimary'=>'about']); });
	Route::get('/career', function(){ return view('contents.website.about.career',['navSelPrimary'=>'about']); });
});

Route::group(['prefix' => 'products'], function(){
	Route::get('/open-an-account', function(){ return view('contents.website.products.open-an-account',['navSelPrimary'=>'products']); });
	Route::get('/account-types', function(){ return view('contents.website.products.account-types',['navSelPrimary'=>'products']); });
	Route::get('/forex', function(){ return view('contents.website.products.forex',['navSelPrimary'=>'products']); });
	Route::get('/binary-options', function(){ return view('contents.website.products.binary-options',['navSelPrimary'=>'products']); });
	Route::get('/cfd', function(){ return view('contents.website.products.cfd',['navSelPrimary'=>'products']); });
	Route::get('/precious-metals', function(){ return view('contents.website.products.precious-metals',['navSelPrimary'=>'products']); });
});

Route::group(['prefix' => 'resources/forex-basics'], function(){
	Route::get('/what-is-forex', function(){ return view('contents.website.resources.what-is-forex',['navSelPrimary'=>'resources']); });
	Route::get('/making-money-with-forex', function(){ return view('contents.website.resources.making-money-with-forex',['navSelPrimary'=>'resources']); });
	Route::get('/all-about-currency', function(){ return view('contents.website.resources.all-about-currency',['navSelPrimary'=>'resources']); });
	Route::get('/forex-jargons', function(){ return view('contents.website.resources.forex-jargons',['navSelPrimary'=>'resources']); });
	Route::get('/utilizing-leverage', function(){ return view('contents.website.resources.utilizing-leverage',['navSelPrimary'=>'resources']); });
});

Route::group(['prefix' => 'resources/binary-options'], function(){
	Route::get('/what-is-binary-options', function(){ return view('contents.website.resources.what-is-binary-options',['navSelPrimary'=>'resources']); });
	Route::get('/understanding-binary-options', function(){ return view('contents.website.resources.understanding-binary-options',['navSelPrimary'=>'resources']); });
	Route::get('/asset-classes-of-binary-options', function(){ return view('contents.website.resources.asset-classes-of-binary-options',['navSelPrimary'=>'resources']); });
});

Route::group(['prefix' => 'resources/contract-for-difference'], function(){
	Route::get('/what-is-cfd', function(){ return view('contents.website.resources.what-is-cfd',['navSelPrimary'=>'resources']); });
	Route::get('/trading-basics', function(){ return view('contents.website.resources.trading-basics',['navSelPrimary'=>'resources']); });
	Route::get('/understanding-different-cfds', function(){ return view('contents.website.resources.understanding-different-cfds',['navSelPrimary'=>'resources']); });
	Route::get('/order-types', function(){ return view('contents.website.resources.order-types',['navSelPrimary'=>'resources']); });
});

Route::group(['prefix' => 'resources/precious-metals'], function(){
	Route::get('/what-are-precious-metals', function(){ return view('contents.website.resources.what-are-precious-metals',['navSelPrimary'=>'resources']); });
	Route::get('/why-invest-in-precious-metals', function(){ return view('contents.website.resources.why-invest-in-precious-metals',['navSelPrimary'=>'resources']); });
	Route::get('/types-of-investments', function(){ return view('contents.website.resources.types-of-investments',['navSelPrimary'=>'resources']); });
	Route::get('/making-your-first-trade', function(){ return view('contents.website.resources.making-your-first-trade',['navSelPrimary'=>'resources']); });
});

Route::group(['prefix' => 'trading-platform'], function(){	
	Route::get('/meta-trader-4', function(){ return view('contents.website.trading-platform.meta-trader-4',['navSelPrimary'=>'trading-platform']); });
	Route::get('/binary-option-mt4', function(){ return view('contents.website.trading-platform.binary-option-mt4',['navSelPrimary'=>'trading-platform']); });
	Route::get('/multi-account-manager', function(){ return view('contents.website.trading-platform.multi-account-manager',['navSelPrimary'=>'trading-platform']); });
});

Route::group(['prefix' => 'partnership'], function(){	
	Route::get('/introducing-broker', function(){ return view('contents.website.partnership.introducing-broker',['navSelPrimary'=>'partnership']); });
	Route::get('/money-manager', function(){ return view('contents.website.partnership.money-manager',['navSelPrimary'=>'partnership']); });
	Route::get('/white-label', function(){ return view('contents.website.partnership.white-label',['navSelPrimary'=>'partnership']); });
});

Route::group(['prefix' => 'support'], function(){	
	Route::get('/contact-us', function(){ return view('contents.website.support.contact-us',['navSelPrimary'=>'support']); });
	Route::get('/faq', function(){ return view('contents.website.support.faq',['navSelPrimary'=>'support']); });
	Route::get('/downloads', function(){ return view('contents.website.support.downloads',['navSelPrimary'=>'support']); });
});


//Template
Route::group(['prefix' => 'templates'], function(){
	Route::group(['prefix' => 'admin'], function(){
	    Route::get('/header', function(){ return view('components.admin-header'); });
	    Route::get('/breadcrumb', function(){ return view('components.admin-breadcrumb'); });
	    Route::get('/sidebar', function(){ return view('components.admin-sidebar'); });
	});
});

Route::group(['prefix' => 'zh'], function(){	
	Route::get('/sales-letter', function(){ return view('sales-letter'); });
});