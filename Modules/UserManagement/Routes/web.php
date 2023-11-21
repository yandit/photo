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

use Modules\UserManagement\Http\Middleware\UserManagementMiddleware;

Route::get('activate/{code}','UserManagementController@activateForm')->name('activate.form');
Route::post('activate/{code}','UserManagementController@activateWithPassword')->name('activate');


Route::group(['middleware' => ['web'], 'prefix' => config('usermanagement.admin_prefix')], function () {
	Route::get('login','UserManagementController@login')->name('admin.login');
	Route::get('logout','UserManagementController@logout')->name('admin.logout');
	Route::post('login','UserManagementController@doLogin')->name('admin.dologin');

	Route::get('forgot-password','UserManagementController@forgotPasswordForm')->name('admin.forgotpassword');
	Route::post('forgot-password','UserManagementController@forgotPasswordSubmit')->name('admin.forgotpassword.submit');

	Route::get('reset-password/{code}','UserManagementController@resetPasswordForm')->name('admin.reset_password.form');
	Route::post('reset-password/{code}','UserManagementController@resetPasswordSubmit')->name('admin.reset_password.submit');

	Route::group(['prefix'=> 'usermanagement', 'middleware'=> config('usermanagement.middleware')],function(){

		Route::group(['prefix'=> 'admin'], function(){
			Route::get('/', 'UserManagementController@index')->name('admin.index');
			Route::get('create','UserManagementController@create')->name('admin.create');
			Route::get('{user}/edit','UserManagementController@edit')->name('admin.edit');
			Route::post('list','UserManagementController@list')->name('admin.list');
			Route::post('/','UserManagementController@store')->name('admin.store');
			Route::put('{user}','UserManagementController@update')->name('admin.update');
			Route::delete('delete/{user}','UserManagementController@delete')->name('admin.delete');	
			Route::get('profile','UserManagementController@profile')->name('admin.profile');
			Route::post('profile','UserManagementController@updateProfile')->name('admin.profile_update');
		});
	
		Route::group(['prefix'=> 'role'], function(){
			// roles
			Route::get('/','RoleController@index')->name('role.index');
			Route::get('/create','RoleController@create')->name('role.create');
			Route::get('{role}/edit','RoleController@edit')->name('role.edit');
			Route::post('/list','RoleController@list')->name('role.list');
			Route::post('/','RoleController@store')->name('role.store');
			Route::put('/{role}','RoleController@update')->name('role.update');
			Route::delete('/delete/{role}','RoleController@delete')->name('role.delete');
		});

		Route::get('rmanagement','RoleManagementController@index')->name('rolemanagement.create');
		Route::post('rmanagement','RoleManagementController@store')->name('rolemanagement.store');
	});

});
