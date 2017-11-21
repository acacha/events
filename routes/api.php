<?php

Route::group(['namespace' => "Acacha\Events\Http\Controllers",'middleware' => 'api','prefix' => 'api/v1', 'middleware' => ['throttle','bindings']], function () {

    //HERE API PUBLIC ROUTES


    Route::group(['middleware' => 'auth:api'], function() {
          //HERE API PRIVATE ROUTES
          Route::get('/events',              'APIEventsController@index');
          Route::get('/events/{event}',      'APIEventsController@show');
          Route::post('/events',             'APIEventsController@store');
          Route::put('/events/{event}',      'APIEventsController@update');
          Route::delete('/events/{event}',   'APIEventsController@destroy');

          Route::get('/users',                'APIUsersController@index');
    });
});