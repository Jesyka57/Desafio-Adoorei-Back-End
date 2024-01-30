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
    /**
     * @OA\Get(
     *     path="/api/produtos",
     *     tags={"Vendas"},
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
     *     tags={"Vendas"},
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
         try {
             $venda_amount = 0;
     
             // Verifica se a venda já existe pelo ID
             $venda_existente = Venda::find($request->_id);
             if ($venda_existente) {
                 throw new \Exception("A venda já existe", 400);
             }
     
             // Cria a venda
             $venda = new Venda();
             $venda->venda_id = $request->_id;
             $venda->save();
     
             foreach ($request->products as $product) {
                 $celular = Celular::find($product['product_id']);
     
                 // Verifica se o celular existe
                 if (!$celular) {
                     $venda->delete();
                     throw new \Exception("O Produto informado não existe", 400);
                 }
     
                 // Verifica se há quantidade suficiente no estoque
                 if ($celular->amount >= $product['amount']) {
                     $produto_venda = new VendaProduto();
                     $produto_venda->venda_id = $venda->id; // Use o ID da venda recém-criada
                     $produto_venda->product_id = $product['product_id'];
                     $produto_venda->nome = $product['nome'];
                     $produto_venda->price = $product['price'];
                     $produto_venda->amount = $product['amount'];
                     $produto_venda->save();
     
                     $celular->amount -= $product['amount'];
                     $celular->save();
     
                     $venda_amount += $product['amount'];
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
                 'products' =>  VendaProduto::where('venda_id', $venda->id)->get(),
             ]);
         } catch (\Exception $e) {
             return response()->json(['error' => 'Erro ao vender produto: ' . $e->getMessage()], 500);
         }
    }
    /**
     * @OA\Put(
     *     path="/api/vendas/{id}",
     *     summary="Edita uma venda",
     *     description="Edita uma venda existente e adiciona produtos a ela.",
     *     operationId="editarVenda",
     *     tags={"Vendas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da venda a ser editada",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados da venda e produtos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="products", type="array", @OA\Items(
     *                 @OA\Property(property="product_id", type="integer", description="ID do produto"),
     *                 @OA\Property(property="nome", type="string", description="Nome do produto"),
     *                 @OA\Property(property="price", type="number", format="float", description="Preço do produto"),
     *                 @OA\Property(property="amount", type="integer", description="Quantidade do produto")
     *             )),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Venda editada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="sales_id", type="integer", description="ID da venda editada"),
     *             @OA\Property(property="amount", type="number", format="float", description="Quantidade total da venda"),
     *             @OA\Property(property="products", type="array", @OA\Items(
     *                 @OA\Property(property="venda_id", type="integer", description="ID da venda do produto"),
     *                 @OA\Property(property="product_id", type="integer", description="ID do produto"),
     *                 @OA\Property(property="nome", type="string", description="Nome do produto"),
     *                 @OA\Property(property="price", type="number", format="float", description="Preço do produto"),
     *                 @OA\Property(property="amount", type="integer", description="Quantidade do produto")
     *             )),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Erro ao adicionar o produto ou quantidade insuficiente",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Mensagem de erro")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno no servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Mensagem de erro")
     *         )
     *     ),
     * )
     */
    public function editarVenda(Request $request,$id){  
        $venda = VendaProduto::where('venda_id', $id)->first();
        $venda_amount = 0;
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
     *     tags={"Vendas"},
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
     *     tags={"Vendas"},
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
     *     tags={"Vendas"},
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
