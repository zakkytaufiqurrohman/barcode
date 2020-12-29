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

     // Legalisasi
     Route::name('legalisasi')->prefix('/legalisasis')->group(function () {
        Route::get('/', 'LegalisasiController@index');
        Route::post('/', 'LegalisasiController@store');
        Route::put('/', 'LegalisasiController@update');
        Route::delete('/', 'LegalisasiController@destroy');
        Route::get('/show', 'LegalisasiController@show')->name('.show');
        
        Route::get('/data', 'LegalisasiController@data')->name('.data');

        Route::get('/download/{id}', 'LegalisasiController@download')->name('.download');

    });

    // Akta PPAT
    Route::name('akta-ppat')->prefix('/akta-ppats')->group(function () {
        Route::get('/', 'AktaPpatController@index');
        Route::post('/', 'AktaPpatController@store');
        Route::put('/', 'AktaPpatController@update');
        Route::delete('/', 'AktaPpatController@destroy');
        Route::get('/show', 'AktaPpatController@show')->name('.show');
        
        Route::get('/data', 'AktaPpatController@data')->name('.data');

        Route::get('/download/{id}', 'AktaPpatController@download')->name('.download');

    });

    // Akta Notaris
    Route::name('akta-notaris')->prefix('/akta-notariss')->group(function () {
        Route::get('/', 'AktaNotarisController@index');
        Route::post('/', 'AktaNotarisController@store');
        Route::put('/', 'AktaNotarisController@update');
        Route::delete('/', 'AktaNotarisController@destroy');
        Route::get('/show', 'AktaNotarisController@show')->name('.show');
        
        Route::get('/data', 'AktaNotarisController@data')->name('.data');

        Route::get('/download/{id}', 'AktaNotarisController@download')->name('.download');

    });

    // Akta Jaminan Fidusia
    Route::name('akta-jaminan-fidusia')->prefix('/akta-jaminan-fidusias')->group(function () {
        Route::get('/', 'AktaJaminanFidusiaController@index');
        Route::post('/', 'AktaJaminanFidusiaController@store');
        Route::put('/', 'AktaJaminanFidusiaController@update');
        Route::delete('/', 'AktaJaminanFidusiaController@destroy');
        Route::get('/show', 'AktaJaminanFidusiaController@show')->name('.show');
        
        Route::get('/data', 'AktaJaminanFidusiaController@data')->name('.data');

        Route::get('/download/{id}', 'AktaJaminanFidusiaController@download')->name('.download');

    });

    // Tanda Terima
    Route::name('tanda-terima')->prefix('/tanda-terimas')->group(function () {
        Route::get('/', 'TandaTerimaController@index');
        Route::post('/', 'TandaTerimaController@store');
        Route::put('/', 'TandaTerimaController@update');
        Route::delete('/', 'TandaTerimaController@destroy');
        Route::get('/show', 'TandaTerimaController@show')->name('.show');
        
        Route::get('/data', 'TandaTerimaController@data')->name('.data');

        Route::get('/download/{id}', 'TandaTerimaController@download')->name('.download');

    });

    // PPAT
    Route::name('ppat')->prefix('/ppats')->group(function () {
        Route::get('/', 'PpatController@index');
        Route::post('/', 'PpatController@store');
        Route::put('/', 'PpatController@update');
        Route::delete('/', 'PpatController@destroy');
        Route::get('/show', 'PpatController@show')->name('.show');
        
        Route::get('/data', 'PpatController@data')->name('.data');

        Route::get('/download/{id}', 'PpatController@download')->name('.download');

    });


    
    // user
    Route::name('user')->prefix('/users')->group(function () {
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');
        Route::get('/show', 'UserController@show')->name('.show');
        Route::put('/', 'UserController@update');
        Route::delete('/', 'UserController@destroy');
        Route::get('/edit-profile', 'UserController@profile')->name('.profile');
        Route::get('/edit-password', 'UserController@password')->name('.password');
        Route::patch('/', 'UserController@edit');
        Route::patch('/update-password', 'UserController@updatePassword')->name('.update-password');

        
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
