<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Celular;
use App\Models\Venda;
use App\Models\VendaProduto;

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
        $venda_amount = 0;
        $venda = new Venda();
        $venda->sales_id = $request->id_venda;
        $venda->save();
        foreach ($request->products as $product)
        {
            $produto_venda = new VendaProduto();
            $produto_venda->venda_id = $request->id_venda;
            $produto_venda->product_id = $product['product_id'];
            $produto_venda->nome = $product['nome'];
            $produto_venda->price = $product['price'];
            $produto_venda->amount = $product['amount'];
            $venda_amount++;
            $produto_venda->save();
        }
        $venda->amount = $venda_amount;
        $venda->save();

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
