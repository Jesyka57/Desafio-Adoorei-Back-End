<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\CelularController;

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

Route::get('/celulares', [CelularController::class, 'index']); // Listar todos os celulares
Route::get('/celulares/{celular}', [CelularController::class, 'show']); // Exibir um celular específico
Route::post('/celulares', [CelularController::class, 'store']); // Armazenar um novo celular
Route::put('/celulares/{celular}', [CelularController::class, 'update']); // Atualizar um celular
Route::delete('/celulares/{celular}', [CelularController::class, 'destroy']); // Excluir um celular

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
