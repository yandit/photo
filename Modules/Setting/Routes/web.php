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

Route::group([
	'middleware' => config('usermanagement.middleware'), 
	'prefix' => config('usermanagement.admin_prefix').'/setting'
], function () {		
	
	Route::get('/list','SettingController@index')->name('setting.view');	
	Route::post('/','SettingController@store')->name('setting.store');
	Route::delete('/delete/{id}','SettingController@delete')->name('setting.delete')->where('id', '[0-9]+');	
	Route::put('/update','SettingController@update')->name('setting.update');	

});
