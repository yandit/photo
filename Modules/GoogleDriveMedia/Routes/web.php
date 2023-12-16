<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web'], 'prefix' => config('usermanagement.admin_prefix')], function () {
    Route::group(['prefix'=> 'google-drive', 'middleware'=> config('usermanagement.middleware')],function(){
        Route::get('/gallery', 'GoogleDriveMediaController@index')->name('googledrivegallery.index');
    });
});
