<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\SalasController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\HorariosClasesController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['guest:usuarios,personal'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.show');
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
});


Route::middleware(['auth:personal', 'admin'])->group(function() {

    Route::get('/mostrarUsuarios', [UsuariosController::class, 'mostrarUsuarios']);
    Route::get('/crearUsuarioForm', [UsuariosController::class, 'crearUsuarioForm']);
    Route::post('/crearUsuario', [UsuariosController::class, 'crearUsuario'])->name('crearUsuario');

    Route::get('/mostrarSalas', [SalasController::class, 'mostrarSalas']);
    Route::get('/crearSalaForm', [SalasController::class, 'crearSalaForm']);
    Route::post('/crearSala', [SalasController::class, 'crearSala'])->name('crearSala');
    Route::get('/editarSalaForm/{id}', [SalasController::class, 'editarSalaForm']);

    Route::get('/mostrarClases', [ClasesController::class, 'mostrarClases']);
    Route::get('/crearClaseForm', [ClasesController::class, 'crearClaseForm']);
    Route::post('/crearClase', [ClasesController::class, 'crearClase'])->name('crearClase');

    Route::get('/mostrarPersonal', [PersonalController::class, 'mostrarPersonal']);
    Route::get('/crearPersonalForm', [PersonalController::class, 'crearPersonalForm']);
    Route::post('/crearPersonal', [PersonalController::class, 'crearPersonal'])->name('crearPersonal');

    Route::get('/mostrarHorarios', [HorariosController::class, 'mostrarHorarios']);
    Route::post('/crearHorarioForm', [HorariosController::class, 'crearHorarioModal']);
    Route::post('/crearHorario', [HorariosController::class, 'crearHorario'])->name('crearHorario');
    Route::post('/duplicarHorarioForm', [HorariosController::class, 'duplicarHorarioModal']);
    Route::post('/duplicarHorario', [HorariosController::class, 'duplicarHorario'])->name('duplicarHorario');
    Route::get('/editarHorarioForm/{id}', [HorariosController::class, 'editarHorarioForm']);
    Route::get('/eliminarHorarioModal', [HorariosController::class, 'eliminarHorarioForm']); //revisary crear
    Route::post('/eliminarHorarioForm', [HorariosController::class, 'eliminarHorarioModal']);
    Route::post('/eliminarHorario', [HorariosController::class, 'eliminarHorario'])->name('eliminarHorario');

    Route::post('/crearClaseHorario', [HorariosClasesController::class, 'crearClaseHorario'])->name('crearClaseHorario');
    Route::post('/eliminarClaseHorarioForm', [HorariosClasesController::class, 'eliminarClaseHorarioModal']);
    Route::post('/eliminarClaseHorario', [HorariosClasesController::class, 'eliminarClaseHorario'])->name('eliminarClaseHorario');
    Route::get('/verHorario/{id}', [HorariosClasesController::class, 'mostrarClasesHorario']);
});

Route::get('/mostrarReservasClases', [ReservasController::class, 'mostrarReservasClases']);

Route::middleware(['auth:usuarios,personal'])->group(function() {
    // REVISAR!!
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/mostrarReservasServicios', [ReservasController::class, 'mostrarReservasServicios']);
    Route::post('/usuarioReservaForm', [ReservasController::class, 'usuarioReservaModal']);
    Route::post('/crearReservaClaseForm', [ReservasController::class, 'crearReservaClaseForm'])->name('crearReservaClaseForm');
    Route::post('/reservaClaseForm', [ReservasController::class, 'reservaClaseForm']);
    Route::post('/crearReservaClase', [ReservasController::class, 'crearReservaClase'])->name('crearReservaClase');
    Route::post('/eliminarReservaClase', [ReservasController::class, 'eliminarReservaClase'])->name('eliminarReservaClase');
});