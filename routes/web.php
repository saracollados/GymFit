<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\SalasController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\HorariosClasesController;
use App\Http\Controllers\HorariosServiciosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Log;

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

// Rutas para usuarios no autenticados
Route::middleware(['guest:usuarios,personal'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.show');
});

// Rutas para administradores
Route::middleware(['admin'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'verDashboard']);

    Route::get('/mostrarUsuarios', [UsuariosController::class, 'mostrarUsuarios']);
    Route::get('/crearUsuarioForm', [UsuariosController::class, 'crearUsuarioForm']);
    Route::post('/crearUsuario', [UsuariosController::class, 'crearUsuario'])->name('crearUsuario');
    Route::post('/eliminarUsuarioForm', [UsuariosController::class, 'eliminarUsuarioForm']);
    Route::post('/eliminarUsuario', [UsuariosController::class, 'eliminarUsuario'])->name('eliminarUsuario');
    Route::post('/restablecerContraseñaUsuario', [UsuariosController::class, 'restablecerContraseña'])->name('restablecerContraseñaUsuario');
    
    Route::get('/mostrarSalas', [SalasController::class, 'mostrarSalas']);
    Route::get('/crearSalaForm', [SalasController::class, 'crearSalaForm']);
    Route::post('/crearSala', [SalasController::class, 'crearSala'])->name('crearSala');
    Route::get('/editarSala/{id}', [SalasController::class, 'editarSalaForm']);
    Route::post('/editarSala', [SalasController::class, 'editarSala'])->name('editarSala');
    Route::post('/eliminarSalaForm', [SalasController::class, 'eliminarSalaForm']);
    Route::post('/eliminarSala', [SalasController::class, 'eliminarSala'])->name('eliminarSala');
    
    Route::get('/mostrarClases', [ClasesController::class, 'mostrarClases']);
    Route::get('/crearClaseForm', [ClasesController::class, 'crearClaseForm']);
    Route::post('/crearClase', [ClasesController::class, 'crearClase'])->name('crearClase');
    Route::post('/eliminarClaseForm', [ClasesController::class, 'eliminarClaseForm']);
    Route::post('/eliminarClase', [ClasesController::class, 'eliminarClase'])->name('eliminarClase');
    Route::get('/editarClase/{id}', [ClasesController::class, 'editarClaseForm']);
    Route::post('/editarClase', [ClasesController::class, 'editarClase'])->name('editarClase');
    
    Route::get('/mostrarPersonal', [PersonalController::class, 'mostrarPersonal']);
    Route::get('/crearPersonalForm', [PersonalController::class, 'crearPersonalForm']);
    Route::post('/crearPersonal', [PersonalController::class, 'crearPersonal'])->name('crearPersonal');
    Route::post('/eliminarPersonalForm', [PersonalController::class, 'eliminarPersonalForm']);
    Route::post('/eliminarPersonal', [PersonalController::class, 'eliminarPersonal'])->name('eliminarPersonal');
    Route::post('/restablecerContraseñaPersonal', [PersonalController::class, 'restablecerContraseña'])->name('restablecerContraseñaPersonal');
    
    Route::get('/mostrarHorarios', [HorariosController::class, 'mostrarHorarios']);
    Route::post('/crearHorarioForm', [HorariosController::class, 'crearHorarioModal']);
    Route::post('/crearHorario', [HorariosController::class, 'crearHorario'])->name('crearHorario');
    Route::post('/duplicarHorarioForm', [HorariosController::class, 'duplicarHorarioModal']);
    Route::post('/duplicarHorario', [HorariosController::class, 'duplicarHorario'])->name('duplicarHorario');
    Route::post('/editarHorarioModal', [HorariosController::class, 'editarHorarioModal']);
    Route::post('/editarHorario', [HorariosController::class, 'editarHorario'])->name('editarHorario');
    Route::get('/editarHorarioForm/{id}', [HorariosController::class, 'editarHorarioForm']);
    Route::post('/eliminarHorarioForm', [HorariosController::class, 'eliminarHorarioModal']);
    Route::post('/eliminarHorario', [HorariosController::class, 'eliminarHorario'])->name('eliminarHorario');
    Route::post('/guardarHorario', [HorariosController::class, 'guardarHorario'])->name('guardarHorario');

    Route::post('/crearClaseHorario', [HorariosClasesController::class, 'crearClaseHorario'])->name('crearClaseHorario');
    Route::post('/eliminarClaseHorarioForm', [HorariosClasesController::class, 'eliminarClaseHorarioModal']);
    Route::post('/eliminarClaseHorario', [HorariosClasesController::class, 'eliminarClaseHorario'])->name('eliminarClaseHorario');
    Route::get('/verHorario/{id}', [HorariosClasesController::class, 'mostrarClasesHorario']);
});

// Rutas para administradore y entrenadores

// Rutas para administradores, fisioterapeutas y nutricionistas
Route::middleware(['adminServicios'])->group(function() {
    Route::get('/mostrarHorariosServicios', [HorariosServiciosController::class, 'mostrarHorariosServicios'])->name('mostrarHorariosServicios');
    Route::post('/crearServicioHorario', [HorariosServiciosController::class, 'crearServicioHorario'])->name('crearServicioHorario');
    Route::post('/eliminarServicioHorarioForm', [HorariosServiciosController::class, 'eliminarServicioHorarioModal']);
    Route::post('/eliminarServicioHorario', [HorariosServiciosController::class, 'eliminarServicioHorario'])->name('eliminarServicioHorario');
    Route::post('/usuarioReservaForm', [ReservasController::class, 'usuarioReservaModal']);
});

// Rutas para administradores, entrenadores y usuarios
Route::middleware(['adminClasesUsuarios'])->group(function() {
    Route::get('/mostrarReservasClases', [ReservasController::class, 'mostrarReservasClases']);
    Route::post('/crearReservaClaseForm', [ReservasController::class, 'crearReservaClaseForm'])->name('crearReservaClaseForm');
    Route::post('/reservaClaseForm', [ReservasController::class, 'reservaClaseForm']);
    Route::post('/crearReservaClase', [ReservasController::class, 'crearReservaClase'])->name('crearReservaClase');
    Route::post('/eliminarReservaClase', [ReservasController::class, 'eliminarReservaClase'])->name('eliminarReservaClase');
    Route::post('/eliminarReservaClaseForm', [ReservasController::class, 'eliminarReservaClaseForm']);
    Route::post('/eliminarReservaClaseList', [ReservasController::class, 'eliminarReservaClaseList'])->name('eliminarReservaClaseList');
});

// Rutas para administradores, fisioterapeutas, nutricionistas y usuarios
Route::middleware(['adminServiciosUsuarios'])->group(function() {
    Route::get('/mostrarReservasServicios', [ReservasController::class, 'mostrarReservasServicios']);
    Route::post('/crearReservaServicioForm', [ReservasController::class, 'crearReservaServicioForm'])->name('crearReservaServicioForm');
    Route::post('/reservaServicioForm', [ReservasController::class, 'reservaClaseForm']);
    Route::post('/crearReservaServicio', [ReservasController::class, 'crearReservaServicio'])->name('crearReservaServicio');
    Route::post('/eliminarReservaServicio', [ReservasController::class, 'eliminarReservaServicio'])->name('eliminarReservaServicio');
    Route::post('/eliminarReservaServicioForm', [ReservasController::class, 'eliminarReservaClaseForm']);
    Route::post('/eliminarReservaServicioList', [ReservasController::class, 'eliminarReservaClaseList'])->name('eliminarReservaServicioList');
});

// Rutas para administradores y usuarios
Route::middleware(['adminUsuarios'])->group(function() {
    Route::post('/editarPerfilUsuario', [UsuariosController::class, 'editarUsuarioForm'])->name('editarPerfilUsuario');
    Route::post('/editarUsuario', [UsuariosController::class, 'editarUsuario'])->name('editarUsuario');
});

// Rutas para entrenadores
Route::middleware(['clases'])->group(function () {
    Route::post('/mostrarHorarioPersonalClases', [HorariosClasesController::class, 'mostrarHorarioPersonalClases'])->name('mostrarHorarioPersonalClases');
    Route::get('/mostrarHorarioPersonalClases', [HorariosClasesController::class, 'mostrarHorarioPersonalClases']);
});

// Rutas para usuarios
Route::middleware(['auth:usuarios'])->group(function () {
    Route::post('/miPerfilUsuario', [UsuariosController::class, 'verUsuario'])->name('miPerfilUsuario');
    Route::get('/miPerfilUsuario', [UsuariosController::class, 'verUsuarioGet']);
});

// Rutas para a administradores, entrenadores, fisioterapeutas y nutricionistas
Route::middleware(['auth:personal'])->group(function () {
    Route::post('/miPerfilPersonal', [PersonalController::class, 'verPersonal'])->name('miPerfilPersonal');
    Route::get('/miPerfilPersonal', [PersonalController::class, 'verPersonalGet']);
    Route::post('/editarPerfilPersonal', [PersonalController::class, 'editarPersonalForm'])->name('editarPerfilPersonal');
    Route::post('/editarPersonal', [PersonalController::class, 'editarPersonal'])->name('editarPersonal');
});

// Rutas para a administradores, entrenadores, fisioterapeutas, nutricionistas y usuarios
Route::middleware(['auth:usuarios,personal'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// mostrarHorarioPersonalClases

// Manejo de excepciones para rutas que solo admiten POST
Route::fallback(function () {
    if (request()->method() !== 'POST') {
        return back()->with('error', 'No tienes permiso para acceder a esa página.');
    } else {
        throw new MethodNotAllowedHttpException([], 'The GET method is not supported for this route.');
    }
});
