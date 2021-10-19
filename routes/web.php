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

//Requisições POST
Route::post('nova_enquete', 'EnquetesController@nova_enquete');
Route::post('nova_alternativa', 'RespostasController@nova_alternativa');
Route::post('editar_enquete', 'EnquetesController@editar_enquete');
Route::post('guardar_enquete', 'EnquetesController@guardar_enquete');
Route::post('respondendo_enquete', 'EnquetesController@respondendo_enquete');


//Requisições GET
Route::get('apagar_enquete/{enquete_id}', 'EnquetesController@apagar_enquete');
Route::get('apagar_resposta/{resposta_id}', 'RespostasController@apagar_resposta');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('listar_enquetes', 'EnquetesController@listar_enquetes');
Route::get('user_enquetes', 'EnquetesController@user_enquetes');
Route::get('respostas_enquete/{enquete_id}', 'RespostasController@respostas_enquete');
Route::get('editar_enquete/{enquete_id}', 'EnquetesController@editar_enquete');