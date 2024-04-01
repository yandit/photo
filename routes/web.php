<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
})->name('homepage');

Route::get('/test', function () {
    return view('google-drive.index');
});

Route::get('/crop/{source}/x_{x?},y_{y?},w_{w},h_{h},disk_{disk?}/{path}', 'App\Http\Controllers\GetImageController@crop')->where('path', '.*')->name('getimage.crop');
Route::get('/upload/{slug?}', 'App\Http\Controllers\UploadController@index')->name('upload.index');
Route::post('/upload/{slug?}', 'App\Http\Controllers\UploadController@store')->name('upload.store');
Route::put('/upload/edit/{upload}','App\Http\Controllers\UploadController@update')->name('upload.update');
Route::post('/upload/frame-selection/{frame}','App\Http\Controllers\UploadController@frameSelection')->name('upload.frameselection');
Route::delete('/upload/{upload}/destroy', 'App\Http\Controllers\UploadController@destroy')->name('upload.destroy');
Route::post('/pin-check', 'App\Http\Controllers\UploadController@pin_check')->name('upload.pin_check');

Route::group([
	'prefix' => 'list-image'
], function () {		
	Route::match(['get', 'post'], '/{slug}', 'App\Http\Controllers\ListImageController@index')->name('list-image.index');
    Route::post('/{slug}/store', 'App\Http\Controllers\ListImageController@store')->name('list-image.store');
});

Route::group([
	'prefix' => 'checkout'
], function () {		
	Route::match(['get', 'post'],'/order-details/{slug?}', 'App\Http\Controllers\CheckoutController@order_details')->name('checkout.order-details');
});
