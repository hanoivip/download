<?php
use Illuminate\Support\Facades\Route;

// Private APIs
Route::prefix('api')
    ->namespace('Hanoivip\Download\Controllers')
    ->group(function () {
    Route::any('/download/config', 'AppDownloadController@getConfig');
});

// Public APIs
Route::prefix('api')->namespace('Hanoivip\Download\Controllers')->group(function () {});

