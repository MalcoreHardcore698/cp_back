<?php

Route::name('api.')->namespace('Api')->group(function () {
    Route::middleware('token')->group(function () {
        Route::prefix('fines')->name('fines')->group(function () {
            Route::post('/', 'FineController@store')->name('store');
            Route::patch('{id}', 'FineController@show')->name('show');
        });
    });
});
