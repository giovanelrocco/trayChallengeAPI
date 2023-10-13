<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\VendaController;
use App\Http\Controllers\API\VendedorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::post('/login', [AuthController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/vendedor', [VendedorController::class, 'index']);
    Route::post('/vendedor', [VendedorController::class, 'create']);
    Route::get('/vendedor/{id}', [VendedorController::class, 'show']);
    Route::put('/vendedor/{id}', [VendedorController::class, 'update']);
    Route::patch('/vendedor/{id}', [VendedorController::class, 'update']);
    Route::delete('/vendedor/{id}', [VendedorController::class, 'delete']);

    Route::get('/venda', [VendaController::class, 'index']);
    Route::post('/venda', [VendaController::class, 'create']);
    Route::get('/venda/{id}', [VendaController::class, 'show']);
    Route::get('/vendedor/{vendedor_id}/venda', [VendaController::class, 'indexByVendedor']);
});
