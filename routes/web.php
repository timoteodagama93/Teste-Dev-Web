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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('nova_enquete', 'EnquetesController@nova_enquete')->name('nova');
Route::post('editar_enquete', 'EnquetesController@editar_enquete');
Route::get('listar_enquetes', 'EnquetesController@listar_enquetes');