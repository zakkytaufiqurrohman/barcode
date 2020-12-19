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
    Route::get('/create-waarmeking', 'WaarmekingController@create')->name('create-waarmeking');
    Route::get('{id}/edit-waarmeking', 'WaarmekingController@edit')->name('.edit-waarmeking');
    Route::post('/', 'WaarmekingController@store');
    Route::put('/update-waarmeking/{id}', 'WaarmekingController@update')->name('.update-waarmeking');
    Route::delete('/', 'WaarmekingController@destroy')->name('.delete-waarmeking');
    
    Route::get('/data', 'WaarmekingController@data')->name('.data');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
