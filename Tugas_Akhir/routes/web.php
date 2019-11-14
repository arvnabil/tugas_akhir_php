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
    return view('welcome');
});

Route::post('/simpanData', 'Biodata@store');
Route::get('/hapusData/{id}', 'Biodata@hapus');
Route::post('/ubahData', 'Biodata@update');
Route::get('/bacaData/{id}', 'Biodata@getDetail');
Route::get('/semuaData', 'Biodata@getData');