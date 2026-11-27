<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminCuentaController;
use App\Http\Controllers\PreRegistroController;

// Rutas de acceso (Login / Logout) y servicios públicos
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/pre-inscripcion', [PreRegistroController::class, 'create'])->name('pre-registro.create');
Route::post('/pre-inscripcion', [PreRegistroController::class, 'store'])->name('pre-registro.store');
Route::post('/consulta-datos-tecnicos', [PreRegistroController::class, 'consultaTecnica'])->name('consulta.tecnica');

// Rutas protegidas para el administrador
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index']);

    Route::put('/admin/cuenta', [AdminCuentaController::class, 'update'])->name('admin.cuenta.update');

    Route::post('/pre-registros/{preRegistro}/aprobar', [PreRegistroController::class, 'aprobar'])->name('pre-registros.aprobar');
    Route::post('/pre-registros/{preRegistro}/rechazar', [PreRegistroController::class, 'rechazar'])->name('pre-registros.rechazar');

    Route::get('/vehiculos/{vehiculo}/carnet', [VehiculoController::class, 'carnet'])->name('vehiculos.carnet');
    Route::post('/vehiculos/{vehiculo}/carnet/imprimir', [VehiculoController::class, 'registrarImpresion'])->name('vehiculos.carnet.imprimir');
    Route::resource('vehiculos', VehiculoController::class);

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
});