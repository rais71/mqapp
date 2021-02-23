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

// Route::get('/', function () {
//   return view('welcome');
// });

Route::get('/beranda', 'HomeController@index')->name('beranda');
Route::get('/', 'HomeController@index')->name('home');

// ADMIN - Daftar Ulang
Route::get('/admin/santri/du', 'AdminController@semuaDaftarUlang')->name('du');
Route::get('/admin/santri/du/tambah', 'AdminController@tambahDaftarUlang');
Route::post('/admin/santri/du/simpan', 'AdminController@simpanDaftarUlang');
Route::delete('/admin/santri/du/hapus_terpilih', 'AdminController@hapusTerpilihDaftarUlang');
Route::post('/admin/santri/du/import', 'AdminController@importDaftarUlang');
Route::get('/admin/santri/du/import/file_contoh', 'AdminController@importDownloadContoh');
Route::get('/admin/santri/du/export', 'AdminController@exportDaftarUlang');

// ADMIN - CRUD Santri
Route::get('/admin/santri', 'AdminController@semuaSantri');
Route::get('/admin/santri/tambah', 'AdminController@tambahSantri');
Route::post('/admin/santri/simpan', 'AdminController@simpanSantri');
Route::get('/admin/santri/{id}', 'AdminController@detailSantri');
Route::delete('/admin/santri/{id}', 'AdminController@hapusSantri');

// SANTRI - Data
Route::get('/santri/data_lihat', 'SantriController@lihatData');
Route::get('/santri/data_isi', 'SantriController@isiData');
Route::post('/santri/data_isi', 'SantriController@simpanSantri');

// KALENDER AKADEMIK
Route::get('/kaldik', 'PagesController@lihatKaldik')->name('kaldik');
Route::post('/kaldik/simpan', 'PagesController@simpanKaldik')->name('kaldik.simpan');
Route::get('/kaldik/data', 'PagesController@dataKaldik')->name('kaldik.data');
Route::delete('/kaldik/{id}', 'PagesController@hapusAcara');

// KALENDER AKADEMIK
Route::get('/pengumuman', 'PagesController@lihatPengumuman')->name('pengumuman');

// AUTH - Login & Register
Route::namespace('Auth')->group(function () {
  Route::get('/login', 'LoginController@login')->name('login');
  Route::post('/login', 'LoginController@process_login');
  Route::get('/register', 'LoginController@register')->name('register');
  Route::post('/register', 'LoginController@simpanRegister');
  Route::post('/logout', 'LoginController@logout')->name('logout');
});

// JSON - Handle Dropdown Lokasi
Route::get('/json-provinsi', 'AdminController@provinsi');
Route::get('/json-kabupaten', 'AdminController@kabupaten');
Route::get('/json-kecamatan', 'AdminController@kecamatan');

// Route::get('/tes', 'LokasiController@index');

// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
