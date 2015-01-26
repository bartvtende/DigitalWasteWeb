<?php

/* Digital Waste */

Route::group(['prefix' => 'digitalwaste'], function() {
    // Home page
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@digitalwaste']);

    // Dropbox authentication
    Route::get('/auth', ['as' => 'auth-dropbox', 'uses' => 'AuthController@authenticate']);

    // Store Dropbox token into a session
    Route::get('/auth/store', ['as' => 'store-dropbox', 'uses' => 'AuthController@store']);

    // Crawl through a section of the users old files
    Route::get('/indexing', ['as' => 'indexing', 'uses' => 'CrawlerController@index']);

    // Item routes
    Route::get('/{id}', ['as' => 'show-dropbox', 'uses' => 'ItemController@showDropbox'])->where('id', '[0-9]+');
    Route::post('/{id}', ['as' => 'rate-dropbox', 'uses' => 'ItemController@rateDropbox'])->where('id', '[0-9]+');

    // Overview route
    Route::get('/results', ['as' => 'overview-dropbox', 'uses' => 'OverviewController@overviewDropbox']);
    Route::get('/results/{id}', ['as' => 'overview-dropbox-user', 'uses' => 'OverviewController@overviewDropbox'])->where('id', '[0-9]+');
});