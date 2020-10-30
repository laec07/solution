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

/*
DB::listen(function($query){
  //Imprimimos la consulta ejecutada
  echo "<pre> {$query->sql } </pre>";
});
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('/administrador', 'AdminController');
Route::resource('/mensajero', 'MensajeroController');

Route::resource('/usuarios','UserController');
Route::get('usuarios/{user}/estado', 'UserController@update_estado')->name('usuarios.update-estado');

Route::resource('/envios','EnviosController' );
Route::get('envios/{user}/estado', 'EnviosController@update_estado')->name('envios.update-estado');

Route::resource('/enviosoficina','EnviosoficinaController' );

Route::resource('/enviosdetalles','EnviodetalleController');

Route::resource('/enviosrecepcion','EnviosrecepcionController');
Route::get('enviosrecepcion/{user}/estado', 'EnviosrecepcionController@update_estado')->name('enviosrecepcion.update-estado');


Route::resource('/asignacionguias','AsignacionguiasController');
Route::resource('/enviosasignacion','EnviosasignacionController');
Route::get('enviosasignacion/{user}/estado', 'EnviosasignacionController@update_estado')->name('enviosasignacion.update-estado');

Route::resource('/revision','RevisionController');

Route::resource('/entregas','EntregasController');
//Liquidaciones
Route::resource('/liquidaciones','LiquidacionesController');
Route::resource('/liquidacionescierre','LiquidacionescierreController');

Route::get('/liquidacionespiloto/{user}/pdf','LiquidacionespilotoController@createPDF');
Route::resource('/liquidacionespiloto','LiquidacionespilotoController');


Route::resource('/liquidacionclientes','LiquidacionclientesController');
Route::resource('/depositos','DepositosController');

//Reportes
Route::resource('/reportgeneral','ReportgeneralController');
Route::resource('/rastreador','RastreadorController');

//mantenimientos
Route::resource('/clientes','ClientesController');
Route::resource('/rutas','RutasController');
Route::resource('/tarifas','TarifasController');
Route::resource('/cuentaclientes','CuentaclientesController');


