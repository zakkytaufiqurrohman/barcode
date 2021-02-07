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
    Route::get('/', 'HomeController@index');

    // waarmeking
    Route::name('waarmeking')->prefix('/waarmekings')->group(function () {
        Route::get('/', 'WaarmekingController@index');
        Route::post('/', 'WaarmekingController@store');
        Route::put('/', 'WaarmekingController@update');
        Route::delete('/', 'WaarmekingController@destroy');
        Route::get('/show', 'WaarmekingController@show')->name('.show');
        
        Route::get('/data', 'WaarmekingController@data')->name('.data');
        Route::get('/detail/{id}', 'WaarmekingController@detail')->name('.detail');


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
        Route::get('/detail/{id}', 'CovernotController@detail')->name('.detail');

        Route::get('/download/{id}', 'CovernotController@download')->name('.download');

    });

     // Legalisasi
     Route::name('legalisasi')->prefix('/legalisasis')->group(function () {
        Route::get('/', 'LegalisasiController@index');
        Route::post('/', 'LegalisasiController@store');
        Route::put('/', 'LegalisasiController@update');
        Route::delete('/', 'LegalisasiController@destroy');
        Route::get('/show', 'LegalisasiController@show')->name('.show');
        
        Route::get('/detail/{id}', 'LegalisasiController@detail')->name('.detail');

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
        Route::get('/detail/{id}', 'AktaPpatController@detail')->name('.detail');
        
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
        Route::get('/detail/{id}', 'AktaNotarisController@detail')->name('.detail');
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
        
        Route::get('/detail/{id}', 'AktaJaminanFidusiaController@detail')->name('.detail');
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
        Route::get('/detail/{id}', 'TandaTerimaController@detail')->name('.detail');


        Route::get('/download/{id}', 'TandaTerimaController@download')->name('.download');

    });

    // PPAT
    Route::name('ppat')->prefix('/ppats')->group(function () {
        Route::get('/', 'PpatController@index');
        Route::post('/', 'PpatController@store');
        Route::put('/', 'PpatController@update');
        Route::delete('/', 'PpatController@destroy');
        Route::get('/show', 'PpatController@show')->name('.show');
        Route::get('/detail/{id}', 'PpatController@detail')->name('.detail');

        Route::get('/data', 'PpatController@data')->name('.data');

        Route::get('/download/{id}', 'PpatController@download')->name('.download');

    });

    // Kwitansi
    Route::name('kwitansi')->prefix('/kwitansis')->group(function () {
        Route::get('/', 'KwitansiController@index');
        Route::post('/', 'KwitansiController@store');
        Route::put('/', 'KwitansiController@update');
        Route::delete('/', 'KwitansiController@destroy');
        Route::get('/show', 'KwitansiController@show')->name('.show');
        Route::get('/print/{id}', 'KwitansiController@print')->name('.print');
        
        Route::get('/data', 'KwitansiController@data')->name('.data');

        Route::get('/download/{id}', 'KwitansiController@download')->name('.download');

    });

    // tanda terima baru
    Route::name('tandaterima')->prefix('/tandaterimas')->group(function () {
        Route::get('/', 'TandaTerimav2Controller@index');
        Route::post('/', 'TandaTerimav2Controller@store');
        Route::put('/', 'TandaTerimav2Controller@update');
        Route::delete('/', 'TandaTerimav2Controller@destroy');
        Route::get('/show', 'TandaTerimav2Controller@show')->name('.show');
        Route::get('/print/{id}', 'TandaTerimav2Controller@print')->name('.print');
        
        Route::get('/data', 'TandaTerimav2Controller@data')->name('.data');

        Route::get('/download/{id}', 'TandaTerimav2Controller@download')->name('.download');

    });

    // reporforium
    Route::name('reporforium')->prefix('/reporforiums')->group(function () {
        Route::get('/', 'ReporforiumController@index');
        Route::post('/', 'ReporforiumController@store');
        Route::put('/', 'ReporforiumController@update');
        Route::delete('/', 'ReporforiumController@destroy');
        Route::get('/show', 'ReporforiumController@show')->name('.show');
        Route::get('/show_detail', 'ReporforiumController@showDetail')->name('.show_detail');
        Route::get('/detail/{id}', 'ReporforiumController@detail')->name('.detail');
        Route::post('/detail', 'ReporforiumController@storeDetail')->name('.dstore');
        Route::delete('/detail', 'ReporforiumController@destroyDetail')->name('.ddelete');
        Route::put('/detail', 'ReporforiumController@updateDetail')->name('.dedit');
        
        Route::get('/data', 'ReporforiumController@data')->name('.data');

        Route::get('/download/{id}', 'ReporforiumController@download')->name('.download');
        Route::post('/print', 'ReporforiumController@print')->name('.print');

    });

    // klaper
    Route::name('klaper')->prefix('/klapers')->group(function () {
        Route::get('/', 'KlaperController@index');
        Route::post('/', 'KlaperController@store');
        Route::put('/', 'KlaperController@update');
        Route::delete('/', 'KlaperController@destroy');
        Route::get('/show', 'KlaperController@show')->name('.show');
        Route::get('/detail/{id}', 'KlaperController@detail')->name('.detail');
        
        Route::get('/data', 'KlaperController@data')->name('.data');

        Route::get('/download/{id}', 'KlaperController@download')->name('.download');

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

        Route::post('/reset-password', 'UserController@reset')->name('.reset');
        Route::get('/data', 'UserController@data')->name('.data');

    });

    // password berkas
    Route::get('/password_berkas', 'PasswordBerkasController@index')->name('password_berkas');
    Route::put('/update_pw_berkas', 'PasswordBerkasController@update')->name('update_berkas');

    // setting header logo
    Route::get('/setting', 'SettingController@index')->name('setting');
    Route::post('/setting_insert', 'SettingController@store')->name('setting_store');


    /*
        baca qr code
    */
    //qr web lama
    // Route::get('/berkas/{id}', 'ReadQrController@readQR');
    // qr web baru
   
});
Route::get('/berkas/{nama}/{id}', 'ReadQrController@readQROld');
Route::post('/login_berkas', 'ReadQrController@login')->name('login_berkas');

Route::post('/login_berkas_repo', 'ReadQrController@logins')->name('login_berkas_repo');
Route::get('/berkas_reporforium/{id}', 'ReadQrController@readQRNew');