<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Celular;
use App\Models\Venda;
use App\Models\VendaProduto;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 * @QA\Server(url="http://localhost/api"),
 * @OA\Info(title="Docker Example", version="0.0.0.1"),
 */
class VendaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/produtos",
     *     tags={"Produtos"},
     *     summary="Obtém a lista de todos os produtos",
     *     @OA\Response(response=200, description="Operação executada com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Proibido"),
     * )
     */
    public function listarProdutosDisponiveis()
    {
        $celulares = Celular::all();
        return response()->json($celulares);
    }
    /**
     * @OA\Post(
     *     path="/api/vendas",
     *     tags={"Produtos"},
     *     summary="Criação de uma nova venda",
     *     @OA\Parameter(
    *      description="ID da venda",
    *      in="path",
    *      name="id_venda",
    *      required=true,
    *      @OA\Schema(type="int"),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="JSON para a criação da venda",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="product_id", type="int"),
     *                     @OA\Property(property="nome", type="string"),
     *                     @OA\Property(property="price", type="float"),
     *                     @OA\Property(property="amount", type="int")
     *                 )
     *             )
     *         ),
     *     ),
     *     @OA\Response(response=400, description="A venda já existe"),
     *     @OA\Response(response=422, description="Dados não processados")
     * )
     */

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
    /**
     * @OA\Get(
     *     path="/api/vendas",
     *     tags={"Produtos"},
     *     summary="Obtém a lista de todas as vendas realizadas",
     *     @OA\Response(response=200, description="Operação executada com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Proibido"),
     * )
     */
    public function consultarVendasRealizadas()
    {
        $vendas = Venda::all();
        return response()->json($vendas);
    }

    /**
     * @OA\Get(
     *     path="/api/vendas/{id}",
     *     tags={"Produtos"},
     *     summary="Obtém uma venda especifica",
     *     @OA\Response(response=200, description="Operação executada com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Proibido"),
     * )
     */
    public function consultarVendaEspecifica($id)
    {
        $venda = Venda::with('produtos')->find($id);
        return response()->json($venda);
    }
    /**
     * @OA\Delete(
     *     path="/api/vendas/{id}",
     *     tags={"Produtos"},
     *     summary="Cancela uma venda especifica",
     *     @OA\Parameter(
     *         description="Id da venda",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=204, description="Operação executada com sucesso"),
     *     @OA\Response(response=403, description="Proibido")
     * )
     */
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
