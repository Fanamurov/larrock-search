<?php

Route::group(['prefix' => 'admin', 'middleware'=> ['web', 'level:2', 'LarrockAdminMenu']], function(){
    Route::get('/search', [
        'as' => 'admin.search', 'uses' => 'Larrock\ComponentSearch\AdminSearchController@index'
    ]);
});