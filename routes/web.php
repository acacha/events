<?php

Route::group(['namespace' => "Acacha\Events\Http\Controllers", 'middleware' => 'web'], function () {

      Route::group( ['middleware' => 'auth'] , function () {
          // Events Web without API only Laravel PHP
          Route::get('/events_php',                 'EventsController@index');
          Route::get('/events_php/create',          'EventsController@create');
          Route::get('/events_php/edit/{event}',    'EventsController@edit');
          Route::get('/events_php/{event}',         'EventsController@show');
          Route::post('/events_php',                'EventsController@store');
          Route::put('/events_php/{event}',         'EventsController@update');
          Route::delete('/events_php/{event}',      'EventsController@destroy');

          // Events API
          Route::get('/api/v1/events',              'APIEventsController@index');
          Route::get('/api/v1/events/{event}',      'APIEventsController@show');
          Route::post('/api/v1/events',             'APIEventsController@store');
          Route::put('/api/v1/events/{event}',      'APIEventsController@update');
          Route::delete('/api/v1/events/{event}',   'APIEventsController@destroy');

          //Events vue
          Route::view('/events','events');
    });

});
