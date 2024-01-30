<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Celular;
use App\Models\Venda;
use App\Models\VendaProduto;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use Illuminate\Validation\Rule;

class CelularController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/celulares",
     *     summary="Listar todos os celulares",
     *     tags={"Produtos"},
     *     @OA\Response(response="200", description="Listar todos os celulares"),
     * )
     */
    public function index()
    {
        $celulares = Celular::all();
        return response()->json($celulares);
    }

    /**
     * @OA\Post(
     *     path="/api/celulares",
     *     summary="Armazenar um novo celular",
     *     tags={"Produtos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="celulares", type="array", @OA\Items(
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="price", type="number"),
     *                 @OA\Property(property="amount", type="integer"),
     *                 @OA\Property(property="description", type="string")
     *             ))
     *         )
     *     ),
     *     @OA\Response(response="201", description="Celulares adicionados com sucesso"),
     *     @OA\Response(response="422", description="Erro de validação"),
     * )
     */
    public function store(Request $request)
    {
        foreach ($request->celulares as $celularData) {
            $celular_existente = Celular::where('name', $celularData['name'])->first();

            if ($celular_existente) {
                throw new Exception("O celular informado já existe", 400);
            }

            $celular = new Celular();
            $celular->name = $celularData['name'];
            $celular->price = $celularData['price'];
            $celular->amount = $celularData['amount'];
            $celular->description = $celularData['description'];
            $celular->save();
        }

        return response()->json(['message' => 'Celulares adicionados com sucesso'],201);
    }

    /**
     * @OA\Get(
     *     path="/api/celulares/{id}",
     *     summary="Exibir um celular específico",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do celular",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(response="200", description="Exibir um celular específico"),
     *     @OA\Response(response="404", description="Celular não encontrado"),
     * )
     */
    public function show($id)
    {
        $celular = Celular::find($id);

        if (!$celular) {
            return response()->json(['error' => 'Celular não encontrado'], 404);
        }

        return response()->json($celular);
    }

    /**
    * @OA\Put(
    *     path="/api/celulares/{id}",
    *     summary="Atualizar um celular",
    *     tags={"Produtos"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID do celular",
    *         required=true,
    *         @OA\Schema(type="integer"),
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="name", type="string"),
    *             @OA\Property(property="price", type="number"),
    *             @OA\Property(property="amount", type="integer"),
    *             @OA\Property(property="description", type="string")
    *         )
    *     ),
    *     @OA\Response(response="200", description="Celular atualizado com sucesso"),
    *     @OA\Response(response="404", description="Celular não encontrado"),
    *     @OA\Response(response="422", description="Erro de validação"),
    * )
    */
    public function update(Request $request, $id)
    {
        $celular_existente = Celular::where('id', $id)->first();
        if($celular_existente->name === $request->name)
            throw new Exception("O celular informado já existe", 400);

        $celular = Celular::find($id);
        $celular->name = $request->input('name', $celular->name);
        $celular->price = $request->input('price', $celular->price);
        $celular->amount = $request->input('amount', $celular->amount);
        $celular->description = $request->input('description', $celular->description);
        
        $celular->save();

        return response()->json(['message' => 'Celular atualizado com sucesso']);
    }

    /**
     * @OA\Delete(
     *     path="/api/celulares/{id}",
     *     summary="Excluir um celular",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do celular",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(response="204", description="Celular excluído com sucesso"),
     *     @OA\Response(response="404", description="Celular não encontrado"),
     * )
     */
    public function destroy($id)
    {
        $celular = Celular::find($id);
        if ($celular) {
            $celular->delete();
            return response()->json(['message' => 'Produto Retirado!'], 204);
        } else {
            return response()->json(['message' => 'Produto não encontrado']);
        }

    }
}
