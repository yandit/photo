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
	'prefix' => config('usermanagement.admin_prefix').'/customer'
], function () {		
	Route::get('/', 'CustomerController@index')->name('customer.index');
    Route::get('create','CustomerController@create')->name('customer.create');
		Route::get('edit/{customer}','CustomerController@edit')->name('customer.edit');
		Route::post('list','CustomerController@list')->name('customer.list');
		Route::post('/','CustomerController@store')->name('customer.store');
		Route::put('{customer}','CustomerController@update')->name('customer.update');
		Route::delete('delete/{customer}','CustomerController@delete')->name('customer.delete');	
});
