<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Obtener información del usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Operaciones de clientes (consignación y retiro) con autenticación
Route::middleware('auth:sanctum')->post('/clientes/consignacion', [ClientesController::class, 'consignacion']);
Route::middleware('auth:sanctum')->post('/clientes/retirar', [ClientesController::class, 'retirar']);

// Recursos API para clientes y usuarios
Route::apiResource("v1/clientes", ClientesController::class);
Route::apiResource("v1/usuarios", UserController::class);

// Autenticación de clientes
Route::post('/clientes/login', [ClientesController::class, 'login']);

// Operaciones de clientes (consignación y retiro)
Route::post('/clientes/consignacion', [ClientesController::class, 'consignacion']);
Route::post('/clientes/retirar', [ClientesController::class, 'retirar']);

// Autenticación de usuarios
Route::post('/login', [UserController::class, 'login']);

// Obtener datos de cliente específico
Route::get('/clientes/cargar/{id}', [ClientesController::class, 'cargarDatos']);
