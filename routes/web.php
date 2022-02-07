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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('notifikasi', 'NotificationController@index')->name('notifikasi');
Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::name('admin.')->prefix('admin')->namespace('Admin')->group(function () {
        Route::get('/', 'IndexController@index')->name('index');

        Route::get('/jurusan', 'JurusanController@index')->name('jurusan.index');
        Route::post('/jurusan', 'JurusanController@store')->name('jurusan.store');
        Route::delete('/jurusan/{id}', 'JurusanController@destroy')->name('jurusan.destroy');
        Route::put('/jurusan/{id}', 'JurusanController@update')->name('jurusan.update');

        Route::get('/tahun-ajaran', 'TahunAjaranController@index')->name('tahun-ajaran.index');
        Route::post('/tahun-ajaran', 'TahunAjaranController@store')->name('tahun-ajaran.store');
        Route::delete('/tahun-ajaran/{id}', 'TahunAjaranController@destroy')->name('tahun-ajaran.destroy');
        Route::put('/tahun-ajaran/{id}', 'TahunAjaranController@update')->name('tahun-ajaran.update');

        Route::get('/kelas/{id}', 'KelasController@show')->name('kelas.show');
        Route::get('/kelas', 'KelasController@index')->name('kelas.index');
        Route::post('/kelas', 'KelasController@store')->name('kelas.store');
        Route::delete('/kelas/{id}', 'KelasController@destroy')->name('kelas.destroy');
        Route::put('/kelas/{id}', 'KelasController@update')->name('kelas.update');

        Route::get('/profile', 'SiswaController@profile')->name('profile');
        Route::get('/siswa', 'SiswaController@index')->name('siswa.index');
        Route::get('/siswa/create', 'SiswaController@create')->name('siswa.create');
        Route::get('/siswa/{id}/edit', 'SiswaController@edit')->name('siswa.edit');
        Route::post('/siswa', 'SiswaController@store')->name('siswa.store');
        Route::delete('/siswa/{id}', 'SiswaController@destroy')->name('siswa.destroy');
        Route::put('/siswa/{id}', 'SiswaController@update')->name('siswa.update');
        Route::get('/siswa/{id}', 'SiswaController@show')->name('siswa.show');
        Route::get('/update-all-siswa', 'SiswaController@updateAll')->name('siswa.update-all');
        Route::post('/update-all-siswa-save', 'SiswaController@updateAllSave')->name('siswa.update-all-save');

        Route::get('/user', 'UserController@index')->name('user.index');
        Route::post('/user', 'UserController@store')->name('user.store');
        Route::delete('/user/{id}', 'UserController@destroy')->name('user.destroy');
        Route::put('/user/{id}', 'UserController@update')->name('user.update');

        Route::get('/bayar/create', 'PembayaranSiswaController@create')->name('bayar.create');
        Route::get('/bayar/{id}', 'PembayaranSiswaController@show')->name('bayar.show');
        Route::put('/bayar/upload/{id}', 'PembayaranSiswaController@update')->name('bayar.update');
        Route::post('/bayar', 'PembayaranSiswaController@store')->name('bayar.store');
        Route::get('/bayar', 'PembayaranSiswaController@index')->name('bayar.index');
        Route::delete('/bayar/{id}', 'PembayaranSiswaController@destroy')->name('bayar.destroy');
        Route::get('/list-pembayaran', 'PembayaranSiswaController@pembayaran')->name('daftar.bayar');

        Route::get('/pembayaran/print/{id}', 'PembayaranController@print')->name('pembayaran.print');
        Route::post('/pembayaran/{id}', 'PembayaranController@store')->name('pembayaran.store');
        Route::get('/pembayaran/create/{id}', 'PembayaranController@create')->name('pembayaran.create');
        Route::get('/pembayaran/{id}', 'PembayaranController@show')->name('pembayaran.show');
        Route::get('/pembayaran', 'PembayaranController@index')->name('pembayaran.index');
        Route::get('/pembayaran/{id}/update', 'PembayaranController@update')->name('pembayaran.update');
        Route::post('/pembayaran/{id}/reject', 'PembayaranController@reject')->name('pembayaran.reject');

        Route::get('/laporan/pembayaran', 'ReportController@pembayaran')->name('laporan.pembayaran');
        Route::get('/laporan/tunggakan', 'ReportController@tunggakan')->name('laporan.tunggakan');
        Route::get('/laporan/kelas', 'ReportController@kelas')->name('laporan.kelas');

        Route::get('/tunggakan', 'TunggakanController@index')->name('tunggakan.index');
        Route::get('/tunggakan/notif/{id}', 'TunggakanController@notif')->name('tunggakan.notif');
    });
});
