<?php

Route::group(['namespace' => "Acacha\Events\Http\Controllers",'middleware' => 'api','prefix' => 'api/v1', 'middleware' => ['throttle','bindings']], function () {

    //HERE API PUBLIC ROUTES


    Route::group(['middleware' => 'auth:api'], function() {
            //HERE API PRIVATE ROUTES

    });
});