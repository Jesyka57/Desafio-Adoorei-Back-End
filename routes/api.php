<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendaController;

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

Route::get('/produtos', [VendaController::class, 'listarProdutosDisponiveis']);
Route::post('/vendas', [VendaController::class, 'cadastrarVenda']);
Route::put('/vendas/{id}', [VendaController::class,'editarVenda']);
Route::get('/vendas', [VendaController::class, 'consultarVendasRealizadas']);
Route::get('/vendas/{id}', [VendaController::class, 'consultarVendaEspecifica']);
Route::delete('/vendas/{id}', [VendaController::class, 'cancelarVenda']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
