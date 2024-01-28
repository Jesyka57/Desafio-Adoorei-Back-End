<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Celular;
use App\Models\Venda;
use App\Models\VendaProduto;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

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
        //try {
            $venda_amount = 0;
            $venda_existente = Venda::find($request->id_venda);
            if($request->id_venda === $venda_existente)
                throw new Exception("A venda já existe", 400);
            $venda = new Venda();
            $venda->venda_id = $request->id_venda;
            $venda->save();
            foreach ($request->products as $product)
            {
                $celular = Celular::find($product['product_id']);

                if ($celular==null) {
                    $venda->delete();
                    throw new Exception("O Produto informado não existe", 400);
                }

                if ($celular->amount >= $product['amount']) {

                    $produto_venda = new VendaProduto();
                    $produto_venda->venda_id = $request->id_venda;
                    $produto_venda->product_id = $product['product_id'];
                    $produto_venda->nome = $product['nome'];
                    $produto_venda->price = $product['price'];
                    $produto_venda->amount = $product['amount'];
                    $venda_amount = $product['amount'] + $product['amount'];
                    $produto_venda->save();

                    $celular->amount -= $product['amount'];
                    $celular->save();
                } else {
                    $venda->delete();
                    return response()->json(['error' => 'Quantidade insuficiente para a venda'], 400);
                }
                    
            }
                $venda->amount = $venda_amount;
                $venda->save();

                // Retorne a resposta da API
                return response()->json([
                    'sales_id' => $venda->id,
                    'amount' => $venda->amount,
                    'products' =>  $produto_venda,
                ]);
        //} catch (\Exception $e) {
            //return response()->json(['error' => 'Erro ao vender produto: ' . $e->getMessage()], 500);
        //}
    }
    public function editarVenda($id,Request $request){
        $venda = VendaProduto::where('venda_id',$id);
        if($venda){
            foreach ($request->products as $product)
            {
                $celular = Celular::find($product['product_id']);

                if ($celular==null) {
                    throw new Exception("O Produto informado não existe", 400);
                }

                if ($celular->amount >= $product['amount']) {

                    $produto_venda = new VendaProduto();
                    $produto_venda->venda_id = $venda->venda_id;
                    $produto_venda->product_id = $product['product_id'];
                    $produto_venda->nome = $product['nome'];
                    $produto_venda->price = $product['price'];
                    $produto_venda->amount = $product['amount'];
                    $venda_amount = $product['amount'] + $product['amount'];
                    $produto_venda->save();

                    $celular->amount -= $product['amount'];
                    $celular->save();
                } else {
                    $venda->delete();
                    return response()->json(['error' => 'Quantidade insuficiente para a venda'], 400);
                }
                    
            }
                $venda->amount = $venda_amount;
                $venda->save();

        } else {
            return response()->json(['error' => 'Erro ao adicionar o produto'], 400);
        }
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
            $venda_produtos = VendaProduto::where('venda_id',$id);
            foreach ($venda_produtos as $key => $venda_produto) {
                $celular = Celular::where('id',$venda_produto->product_id);
                $celular->amount += $venda_produto->amount;
                $celular->save(); 
            }
            $venda->delete();
            return response()->json(['message' => 'Venda cancelada com sucesso.']);
        } else {
            return response()->json(['error' => 'Venda não encontrada.'], 404);
        }
    }
}
