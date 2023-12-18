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
        Route::group(['prefix'=> 'credential'],function(){
            Route::get('/', 'CredentialController@index')->name('googledrivecredential.index');
            Route::get('create','CredentialController@create')->name('googledrivecredential.create');
            Route::get('edit/{customer}','CredentialController@edit')->name('googledrivecredential.edit');
            Route::post('list','CredentialController@list')->name('googledrivecredential.list');
            Route::post('/','CredentialController@store')->name('googledrivecredential.store');
            Route::put('{customer}','CredentialController@update')->name('googledrivecredential.update');
            Route::delete('delete/{customer}','CredentialController@delete')->name('googledrivecredential.delete');	
        });
        Route::get('/gallery', 'GoogleDriveMediaController@index')->name('googledrivegallery.index');
    });
});
