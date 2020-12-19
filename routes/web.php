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
Route::middleware('guest')->group(function () {

Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login');
});
// waarmaking
Route::middleware('auth')->group(function () {
    // logout
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    // home
    Route::get('/', function () {
        return view('home');
    });

    // waarmeking
    Route::name('waarmeking')->prefix('/waarmekings')->group(function () {
        Route::get('/', 'WaarmekingController@index');
        Route::get('/create-waarmeking', 'WaarmekingController@create')->name('create-waarmeking');
        Route::get('{id}/edit-waarmeking', 'WaarmekingController@edit')->name('.edit-waarmeking');
        Route::post('/', 'WaarmekingController@store');
        Route::put('/', 'WaarmekingController@update');
        Route::delete('/', 'WaarmekingController@destroy');
        Route::get('/show', 'WaarmekingController@show')->name('.show');
        
        Route::get('/data', 'WaarmekingController@data')->name('.data');
    });
});
