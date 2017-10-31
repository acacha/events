<?php

Route::group(['namespace' => "Acacha\Events\Http\Controllers", 'middleware' => 'web'], function () {
//https://laravel.com/docs/5.5/routing
    Route::get('/events','EventController@index');
    Route::get('/events/create','EventController@create');
    Route::get('/events/{event}','EventController@show');  // 2 Retrieve -> 1 recurs concret
    Route::get('/events_alt/{id}','EventController@show1');  // 2 Retrieve -> 1 recurs concret
//Route::get('/events/{event}','EventController@show');  // 2 Retrieve -> 1 recurs concret
    Route::delete('/events/{event}','EventController@destroy');  // 2 Retrieve -> 1 recurs concret
});

Route::group(['namespace' => "Acacha\Events\Http\Controllers",'middleware' => 'api','prefix' => 'api/v1', 'middleware' => ['throttle','bindings']], function () {
    Route::group(['middleware' => 'auth:api'], function() {

    });
//    Route::get('/events', 'APIEventsController@index');
//    Route::get('/events/{event}', 'APIEventsController@show');
});

//https://laravel.com/docs/5.5/routing
//Route::get('/events','Acacha\Events\Http\Controllers\Eventscontroller@index'); // 1 Retrieve -> Llista completa -> Paginació
//Route::get('/events/{event}','Acacha\Events\Http\Controllers\Eventscontroller@show');  // 2 Retrieve -> 1 recurs concret
//Route::get('/events_alt/{id}','Acacha\Events\Http\Controllers\Eventscontroller@show1');  // 2 Retrieve -> 1 recurs concret
////Route::get('/events/{event}','Acacha\Events\Http\Controllers\Eventscontroller@show');  // 2 Retrieve -> 1 recurs concret
//Route::delete('/events/{event}','Acacha\Events\Http\Controllers\Eventscontroller@destroy');  // 2 Retrieve -> 1 recurs concret