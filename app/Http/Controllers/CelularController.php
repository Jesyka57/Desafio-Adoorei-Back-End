<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Celular;

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
     *         required=true
     *     ),
     *     @OA\Response(response="201", description="Celular adicionado com sucesso"),
     *     @OA\Response(response="422", description="Erro de validação"),
     * )
     */
    public function store(Request $request)
    {
        return response()->json($celular);
    }

    /**
     * @OA\Get(
     *     path="/api/celulares/{celular}",
     *     summary="Exibir um celular específico",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="celular",
     *         in="path",
     *         description="ID do celular",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(response="200", description="Exibir um celular específico"),
     *     @OA\Response(response="404", description="Celular não encontrado"),
     * )
     */
    public function show(string $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'amount' => 'required|integer',
            'description' => 'required',
        ]);

        $celular = Celular::create($request->all());

        return response()->json($celular, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/celulares/{celular}",
     *     summary="Atualizar um celular",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="celular",
     *         in="path",
     *         description="ID do celular",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\RequestBody(
     *         required=true
     *     ),
     *     @OA\Response(response="200", description="Celular atualizado com sucesso"),
     *     @OA\Response(response="404", description="Celular não encontrado"),
     *     @OA\Response(response="422", description="Erro de validação"),
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'amount' => 'required|integer',
            'description' => 'required',
        ]);

        $celular->update($request->all());

        return response()->json($celular, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/celulares/{celular}",
     *     summary="Excluir um celular",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="celular",
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
            return response()->json(['message' => 'Produto Retirado!']);
        } else {
            return response()->json(['message' => 'Produto não encontrado']);
        }

    }
}
