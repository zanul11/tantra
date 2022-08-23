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


Route::get('/', 'AuthController@index');

// Route::get('login', ['as' => 'login', 'uses' => 'FrontController@index']);
Route::get('login', ['as' => 'login', 'uses' => 'AuthController@index']);
Route::get('/auth', 'AuthController@show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/auth/logout', 'AuthController@logout');
    Route::get('/dashboard', 'DashboardController@index');

    //USER
    Route::get('ss-user', 'UserController@getServerSide')->name('ss.user');
    Route::post('user/delete/{user}', 'UserController@delete');
    Route::resource('user', 'UserController');

    //PERUSAHAAN
    Route::get('ss-perusahaan', 'PerusahaanController@getServerSide')->name('ss.perusahaan');
    Route::resource('perusahaan', 'PerusahaanController');
    Route::resource('pajak', 'PajakController');

    Route::get('ss-pengadaan', 'PengadaanController@getServerSide')->name('ss.pengadaan');
    Route::resource('pengadaan', 'PengadaanController');
    Route::resource('ongkos', 'OngkosController');

    Route::post('laporan/filter', 'LaporanController@filter');
    Route::get('ss-laporan', 'LaporanController@getServerSide')->name('ss.laporan');
    Route::resource('laporan', 'LaporanController');
});
