<?php
use Illuminate\Support\Facades\Route;

Route::namespace('\Hanoivip\Download\Controllers')->group(function () {
    Route::get('/download', 'DownloadController@general')->name('download');
    Route::get('/download/android/store', 'DownloadController@androidStore')->name('android.store');
    Route::get('/download/android/apk', 'DownloadController@androidDirect')->name('android.apk');
});

Route::middleware([
    'web',
    'auth:web'
])->namespace('\Hanoivip\Download\Controllers')->group(function () {
    Route::get('/download/ios/store', 'DownloadController@iosStore')->name('ios.store');
    Route::get('/download/ios/inhouse', 'DownloadController@iosInhouse')->name('ios.inhouse');
    Route::any('/download/ios/adhoc', 'IosController@index')->name('ios.adhoc');
    Route::post('/download/ios/buy', 'IosController@buy')->name('ios.buy');
});

Route::middleware([
    'web',
    'auth:web',
    'ios-bought'
])->namespace('\Hanoivip\Download\Controllers')->group(function () {
    Route::get('/download/ios/buy-success', 'IosController@buySuccess');
    Route::get('/download/ios/udid', 'IosController@askUdid')->name('ios.udid');
    Route::post('/download/ios/udid', 'IosController@udid')->name('ios.udid.do');
    Route::get('/download/ios/udid-success', 'IosController@success');
    Route::post('download/ios/renew', 'IosController@renew')->name('ios.renew');
    Route::get('/download/ios/history', 'IosController@history')->name('ios.history');
});

Route::middleware([
    'web',
    'admin'
])->namespace('\Hanoivip\Download\Controllers')
    ->prefix('ecmin')
    ->group(function () {
    Route::get('/ios', 'Admin@index')->name('ecmin.ios');
    // list all ready device?
    Route::get('/ios/pending', 'Admin@listPending');
    Route::post('/ios/pending-invalid', 'Admin@invalidPending')->name('ecmin.ios.invalid');
    Route::any('/ios/pending-success', 'Admin@finishPending')->name('ecmin.ios.finish');
    // add new account?
    // move to new account?
    // statistics?
    Route::get('/ios/device/download', 'Admin@downloadDevices');
});