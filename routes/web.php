<?php

use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('empleados', EmpleadoController::class)->middleware('auth');

Route::get('empleados/{empleado}/activarInactivar', [EmpleadoController::class, 'activarInactivar'])
    ->name('empleados.activarInactivar')->middleware('auth');;

