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
        Route::post('/', 'WaarmekingController@store');
        Route::put('/', 'WaarmekingController@update');
        Route::delete('/', 'WaarmekingController@destroy');
        Route::get('/show', 'WaarmekingController@show')->name('.show');
        
        Route::get('/data', 'WaarmekingController@data')->name('.data');

        Route::get('/download/{id}', 'WaarmekingController@download')->name('.download');

    });

     // covernot
     Route::name('covernot')->prefix('/covernots')->group(function () {
        Route::get('/', 'CovernotController@index');
        Route::post('/', 'CovernotController@store');
        Route::put('/', 'CovernotController@update');
        Route::delete('/', 'CovernotController@destroy');
        Route::get('/show', 'CovernotController@show')->name('.show');
        
        Route::get('/data', 'CovernotController@data')->name('.data');

        Route::get('/download/{id}', 'CovernotController@download')->name('.download');

    });


    
    // user
    Route::name('user')->prefix('/users')->group(function () {
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');
        Route::get('/show', 'UserController@show')->name('.show');
        Route::put('/', 'UserController@update');
        Route::delete('/', 'UserController@destroy');
        
        Route::get('/data', 'UserController@data')->name('.data');

    });

    /*
        baca qr code
    */
    //qr web lama
    // Route::get('/berkas/{id}', 'ReadQrController@readQR');
    // qr web baru
    Route::get('/berkas/{nama}/{id}', 'ReadQrController@readQROld');
});
