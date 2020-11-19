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
  return view('welcome');
});

// ADMIN - Daftar Ulang
Route::get('/admin/santri/du', 'AdminController@semuaDaftarUlang');
Route::get('/admin/santri/du/tambah', 'AdminController@tambahDaftarUlang');
Route::post('/admin/santri/du/simpan', 'AdminController@simpanDaftarUlang');

// ADMIN - CRUD Santri
Route::get('/admin/santri', 'AdminController@semuaSantri');
Route::get('/admin/santri/tambah', 'AdminController@tambahSantri');
Route::post('/admin/santri/simpan', 'AdminController@simpanSantri');
Route::get('/admin/santri/{id}', 'AdminController@detailSantri');
Route::delete('/admin/santri/{id}', 'AdminController@hapusSantri');

// SANTRI - Data
Route::get('/santri', 'SantriController@index')->name('santri');

// AUTH - Login & Register
Route::namespace('Auth')->group(function () {
  Route::get('/login', 'LoginController@loginSantri')->name('login');
  Route::post('/login', 'LoginController@process_login')->name('login');
  Route::get('/register', 'LoginController@registerSantri')->name('register');
  Route::post('/register', 'LoginController@simpanRegisterSantri');
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
