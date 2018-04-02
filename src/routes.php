<?php

Route::group(['prefix' => 'admin'], function () {
    Route::get('/search', [
        'as' => 'admin.search', 'uses' => 'Larrock\ComponentSearch\AdminSearchController@index',
    ]);
    Route::get('/initSearchModule', [
        'as' => 'admin.initSearchModule', 'uses' => 'Larrock\ComponentSearch\AdminSearchController@initSearchModule',
    ]);
});
