<?php

// Rating routes
Route::get('/', ['as' => 'showRandomData', 'uses' => 'RateController@serveData']);
Route::get('data/{id}', ['as' => 'showRandomDataWithPrevious', 'uses' => 'RateController@serveData']);
Route::post('/', ['as' => 'rateData', 'uses' => 'RateController@postRatingData']);

// Overview routes
Route::get('overview', ['as' => 'overview', 'uses' => 'OverviewController@serveOverview']);
Route::get('overview/{id}', ['as' => 'overviewData', 'uses' => 'OverviewController@serveOverviewData']);

// Limit route
Route::get('setlimit/{limit}', ['as' => 'setLimit', 'uses' => 'LimitController@setLimit']);