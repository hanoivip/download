<?php

use Illuminate\Support\Facades\Route;

Route::get('/download', '\Hanoivip\Download\DownloadController@general')->name('download');

Route::get('/download/android/store', function () {
    return view('hanoivip::android-store');
})->name('android.store');

Route::get('/download/android/apk', function () {
    return view('hanoivip::android-apk');
})->name('android.apk');

Route::get('/download/ios/store', function () {
    return view('hanoivip::ios-store');
})->name('ios.store');

Route::get('/download/ios/inhouse', function () {
    return view('hanoivip::ios-inhouse');
})->name('ios.inhouse');