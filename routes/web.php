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


/**Rutas para manejo de archivos */
Route::get('/', 'FileController@fileView')->name('inicio');
Route::post('/upload-file', 'FileController@uploadFile');
