<?php

use App\Http\Controllers\ConsumoController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\PlanillaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing.principal');

Route::view('/dashboard', 'dashboard.dashboard')->name('dashboard');

Route::get('/planilla', [PlanillaController::class, 'index'])->name('planilla.index');
Route::post('/planilla', [PlanillaController::class, 'store'])->name('planilla.store');

Route::post('/consumo', [ConsumoController::class, 'store'])->name('consumo.store');

// Esta es la ruta que te faltaba
Route::post('/planilla/finalizar', [PlanillaController::class, 'finalizar'])->name('planilla.finalizar');

Route::get('/historial', [PlanillaController::class, 'historial'])->name('planilla.historial');

Route::post('/habitacion/liberar', [HabitacionController::class, 'liberar'])->name('habitacion.liberar');

// editar
Route::get('/editar/{planilla}', [PlanillaController::class, 'edit'])->name('planilla.editar');

Route::put('/planilla/{planilla}', [PlanillaController::class, 'update'])->name('planilla.update');

// eliminar
Route::delete('/planilla/{planilla}', [PlanillaController::class, 'destroy'])->name('planilla.destroy');
