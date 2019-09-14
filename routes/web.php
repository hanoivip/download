<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\Hanoivip\Download\Controllers')->group(function () {
    
    Route::get('/download', 'DownloadController@general')->name('download');
    Route::get('/download/android/store', 'DownloadController@androidStore')->name('android.store');
    Route::get('/download/android/apk', 'DownloadController@androidDirect')->name('android.apk');
    Route::get('/download/ios/store', 'DownloadController@iosStore')->name('ios.store');
    Route::get('/download/ios/inhouse', 'DownloadController@iosInhouse')->name('ios.inhouse');

});