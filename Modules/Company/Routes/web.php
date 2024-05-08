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
	'prefix' => config('usermanagement.admin_prefix').'/company'
], function () {		
	Route::get('/', 'CompanyController@index')->name('company.index');
    Route::get('create','CompanyController@create')->name('company.create');
		Route::get('edit/{company}','CompanyController@edit')->name('company.edit');
		Route::post('list','CompanyController@list')->name('company.list');
		Route::post('/','CompanyController@store')->name('company.store');
		Route::put('{company}','CompanyController@update')->name('company.update');
		Route::delete('delete/{company}','CompanyController@delete')->name('company.delete');	
});
