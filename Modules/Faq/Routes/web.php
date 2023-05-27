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
	'prefix' => config('usermanagement.admin_prefix').'/faq'
], function () {		
	Route::get('/', 'FaqController@index')->name('faq.index');
    Route::get('create','FaqController@create')->name('faq.create');
		Route::get('edit/{faq}','FaqController@edit')->name('faq.edit');
		Route::post('list','FaqController@list')->name('faq.list');
		Route::post('/','FaqController@store')->name('faq.store');
		Route::put('{faq}','FaqController@update')->name('faq.update');
		Route::delete('delete/{faq}','FaqController@delete')->name('faq.delete');	
});
