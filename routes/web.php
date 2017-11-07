<?php

Route::group(['namespace' => "Acacha\Events\Http\Controllers", 'middleware' => 'web'], function () {
//https://laravel.com/docs/5.5/routing
    Route::get('/events','EventController@index');
    Route::post('/events','EventController@store');
    Route::put('/events/{event}','EventController@update');
    Route::get('/events/create','EventController@create');
    Route::get('/events/edit/{event}','EventController@edit');
    Route::get('/events/{event}','EventController@show');  // 2 Retrieve -> 1 recurs concret
    Route::get('/events_alt/{id}','EventController@show1');  // 2 Retrieve -> 1 recurs concret
//Route::get('/events/{event}','EventController@show');  // 2 Retrieve -> 1 recurs concret
    Route::delete('/events/{event}','EventController@destroy');  // 2 Retrieve -> 1 recurs concret
});
