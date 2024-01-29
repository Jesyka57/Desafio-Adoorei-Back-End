<?php

namespace Tests\App\Http\Controllers;

use Tests\TestCase;
use App\Models\Celular;
use App\Models\Venda;
use App\Models\VendaProduto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VendaControllerTest extends TestCase
{
    use RefreshDatabase;
    #php artisan test --filter=VendaControllerTest::testListarProdutosDisponiveis
    public function testListarProdutosDisponiveis()
    {

        $response = $this->get('/api/produtos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                // Define the expected JSON structure for your response
                // (You need to adjust this based on your actual JSON structure)
            ])
            ->assertJson($response->json()); // Assert that the response JSON is not null
    }

    public function testCadastrarVenda()
    {
        // You may need to seed the database with sample data here
        // For example, you can use factories to create Celular records

        $requestData = [
            // Provide sample data for creating a new venda
        ];

        $response = $this->json('POST', '/api/vendas', $requestData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                // Define the expected JSON structure for your response
            ]);
    }

    // You can add more test methods for other controller actions
    // such as testEditarVenda, testConsultarVendasRealizadas, etc.
}