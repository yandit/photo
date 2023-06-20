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
	

Route::group(['prefix'=> config('usermanagement.admin_prefix').'/frames', 'middleware'=> config('usermanagement.middleware')],function(){

	Route::group(['prefix'=> 'stickable'], function(){
		Route::get('/','StickableController@index')->name('stickableframe.index');
		Route::get('/create','StickableController@create')->name('stickableframe.create');
		Route::get('{stickable}/edit','StickableController@edit')->name('stickableframe.edit');
		Route::post('/list','StickableController@list')->name('stickableframe.list');
		Route::post('/','StickableController@store')->name('stickableframe.store');
		Route::put('/{stickable}','StickableController@update')->name('stickableframe.update');
		Route::delete('/delete/{stickable}','StickableController@delete')->name('stickableframe.delete');
	});

});
