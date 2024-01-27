<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Celular;
use App\Models\Venda;

class VendaController extends Controller
{
    //
    public function listarProdutosDisponiveis()
    {
        $celulares = Celular::all();
        return response()->json($celulares);
    }

    public function cadastrarVenda(Request $request)
    {
        // Valide os dados do pedido conforme necessário
        $request->validate([
            'products' => 'required|array',
        ]);

        // Crie a venda no banco de dados
        $venda = Venda::create([
            'amount' => $this->calcularValorTotal($request->products),
        ]);

        // Associe os produtos à venda
        $venda->produtos()->attach($request->products);

        // Retorne a resposta da API
        return response()->json([
            'sales_id' => $venda->id,
            'amount' => $venda->amount,
            'products' => $venda->produtos,
        ]);
    }

    public function consultarVendasRealizadas()
    {
        $vendas = Venda::all();
        return response()->json($vendas);
    }

    public function consultarVendaEspecifica($id)
    {
        $venda = Venda::with('produtos')->find($id);
        return response()->json($venda);
    }

    public function cancelarVenda($id)
    {
        $venda = Venda::find($id);
        if ($venda) {
            $venda->delete();
            return response()->json(['message' => 'Venda cancelada com sucesso.']);
        } else {
            return response()->json(['error' => 'Venda não encontrada.'], 404);
        }
    }

    private function calcularValorTotal($products)
    {
        $total = 0;

        foreach ($products as $product) {
            $celular = Celular::find($product['product_id']);
            $total += $celular->price * $product['amount'];
        }

        return $total;
    }
}
