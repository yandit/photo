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
        Route::group(['prefix'=> 'disk'],function(){
            Route::get('/', 'DiskController@index')->name('googledrivedisk.index');
            Route::get('create','DiskController@create')->name('googledrivedisk.create');
            Route::get('edit/{disk}','DiskController@edit')->name('googledrivedisk.edit');
            Route::post('list','DiskController@list')->name('googledrivedisk.list');
            Route::post('/','DiskController@store')->name('googledrivedisk.store');
            Route::put('{disk}','DiskController@update')->name('googledrivedisk.update');
            Route::delete('delete/{disk}','DiskController@delete')->name('googledrivedisk.delete');	
        });

        Route::group(['prefix'=> 'credential'],function(){
            Route::get('/', 'CredentialController@index')->name('googledrivecredential.index');
            Route::get('create','CredentialController@create')->name('googledrivecredential.create');
            Route::get('edit/{customer}','CredentialController@edit')->name('googledrivecredential.edit');
            Route::post('list','CredentialController@list')->name('googledrivecredential.list');
            Route::post('/','CredentialController@store')->name('googledrivecredential.store');
            Route::put('{customer}','CredentialController@update')->name('googledrivecredential.update');
            Route::delete('delete/{customer}','CredentialController@delete')->name('googledrivecredential.delete');	
        });

        Route::group(['prefix'=> 'gallery'],function(){
            Route::get('/', 'GalleryController@index')->name('googledrivegallery.index');
            Route::get('create/{credential}','GalleryController@create')->name('googledrivegallery.create');
            Route::get('edit/{credential}','GalleryController@edit')->name('googledrivegallery.edit');
            Route::post('list','GalleryController@list')->name('googledrivegallery.list');
            Route::post('/{credential}','GalleryController@store')->name('googledrivegallery.store');
            Route::put('{credential}','GalleryController@update')->name('googledrivegallery.update');
            Route::match(['get', 'post'], 'delete/{credential}','GalleryController@delete')->name('googledrivegallery.delete');	
        });
        // Route::get('/gallery', 'GoogleDriveMediaController@index')->name('googledrivegallery.index');
    });
});
