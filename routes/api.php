<?php

Route::name('api.')->namespace('Api')->group(function () {
    Route::match(['get', 'post'], 'drivers', 'DriverController@store')->name('drivers.store');
    Route::middleware('token')->group(function () {
        // access_token required
    });
});