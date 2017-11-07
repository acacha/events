<?php

Route::group(['namespace' => "Acacha\Events\Http\Controllers", 'middleware' => 'web'], function () {

//    Route::get('/events','EventController@index');
//    Route::post('/events','EventController@store');
//    Route::put('/events/{event}','EventController@update');
//    Route::get('/events/create','EventController@create');
//    Route::get('/events/edit/{event}','EventController@edit');
//    Route::get('/events/{event}','EventController@show');
//    Route::get('/events_alt/{id}','EventController@show1');
//    Route::delete('/events/{event}','EventController@destroy');

    Route::group( ['middleware' => 'auth'] , function () {
        // Events Web

        // Events API
        Route::get('/api/v1/events','APIEventsController@index');
        Route::get('/api/v1/events/{event}','APIEventsController@show');
        Route::post('/api/v1/events','APIEventsController@store');
        Route::put('/api/v1/events/{event}','APIEventsController@update');
        Route::delete('/api/v1/events/{event}','APIEventsController@destroy');
    });

});
