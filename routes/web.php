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
    return view('layouts.app');
});
// waarmaking
Route::name('waarmeking')->prefix('/waarmekings')->group(function () {
    Route::get('/', 'WaarmekingController@index');
    Route::post('/', 'WaarmekingController@store');
    Route::put('/', 'WaarmekingController@update');
    Route::delete('/', 'WaarmekingController@destroy');
    
    Route::get('/data', 'WaarmekingController@data')->name('.data');
});