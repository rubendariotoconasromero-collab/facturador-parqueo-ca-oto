<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UsuarioSiatController;

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

Route::view('/', 'login')->name('login');
Route::view('/registro', 'register')->name('registro');
Route::view('/privada', 'secret')->name('privada');

Route::post('/validar_registro', [LoginController::class, 'register'])->name('validar_registro');
Route::post('/inicia_sesion', [LoginController::class, 'login'])->name('inicia_sesion');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/Conex/TraerDosDatos', [ApiController::class, 'obtenerDatos']);

//Route::get('/Conex/TaerDatos', [ApiController::class, 'obtenerDatos']);
Route::get('/Conex/TaerDatos', [ApiController::class, 'obtenerDatosNumero']);
Route::get('/Conex/TaerDatosPlaca', [ApiController::class, 'obtenerDatosPlaca']);
Route::get('/Conex/TaerDatosImporteTicket', [ApiController::class, 'obtenerDatosImporteTicket']);
Route::get('/Conex/TaerDatosImportePlaca', [ApiController::class, 'obtenerDatosImportePlaca']);


Route::post('/usuarios/guardar', [UsuarioSiatController::class, 'guardarUsuario']);
Route::post('/usuarios/modificar', [UsuarioSiatController::class, 'guardarUsuario']);
Route::get('/usuarios/buscar', [UsuarioSiatController::class, 'buscarUsuario']);
Route::post('/usuarios/activar', [UsuarioSiatController::class, 'activar']);
Route::post('/usuarios/desactivar', [UsuarioSiatController::class, 'desactivar']);

Route::get('/factura/existe_ticket', [ApiController::class, 'buscarTicket']);







