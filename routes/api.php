<?php

use App\Http\Controllers\VendaController;
use App\Http\Controllers\VendedorController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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
