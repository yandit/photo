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
});

Route::get('/crop/x_{x?},y_{y?},w_{w},h_{h}/{path}', 'App\Http\Controllers\GetImageController@crop')->where('path', '.*')->name('getimage.crop');
Route::get('/upload/{slug?}', 'App\Http\Controllers\UploadController@index')->name('upload.index');
Route::post('/upload/{slug?}', 'App\Http\Controllers\UploadController@store')->name('upload.store');
Route::post('/pin-check', 'App\Http\Controllers\UploadController@pin_check')->name('upload.pin_check');
