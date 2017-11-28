<?php

Route::group(['namespace' => "Acacha\Events\Http\Controllers",'middleware' => 'api','prefix' => 'api/v1', 'middleware' => ['throttle','bindings']], function () {

    //HERE API PUBLIC ROUTES


    Route::group(['middleware' => 'auth:api'], function() {
          //HERE API PRIVATE ROUTES
          Route::get('/events',                     'APIEventsController@index');
          Route::get('/events/{event}',             'APIEventsController@show');
          Route::post('/events',                    'APIEventsController@store');
          Route::put('/events/{event}',             'APIEventsController@update');
          Route::delete('/events/{event}',          'APIEventsController@destroy');

          Route::get('/users',                      'APIUsersController@index');
          Route::post('/users',                     'APIUsersController@store');
          Route::get('/users/{user}',               'APIUsersController@show');
          Route::put('/users/{user}',               'APIUsersController@update');
          Route::delete('/users/{user}',            'APIUsersController@destroy');

          Route::get('/user/events',                'APIUserEventsController@index');
          Route::post('/user/events',               'APIUserEventsController@store');
    });
});