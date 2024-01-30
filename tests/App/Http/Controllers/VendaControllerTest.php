<?php

namespace Tests\App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Celular;
use App\Models\Venda;
use App\Models\VendaProduto;

class VendaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Celular::factory()->create([
            'id' => 1,
            'name' => 'Produto1',
            'price' => 10.99,
            'amount' => 5,
        ]);

        Celular::factory()->create([
            'id' => 2,
            'name' => 'Produto2',
            'price' => 15.99,
            'amount' => 10,
        ]);
    }

    #php artisan test --filter=VendaControllerTest::testListarProdutosDisponiveis
    public function testListarProdutosDisponiveis()
    {
        $response = $this->get('/api/produtos');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }
    #php artisan test --filter=VendaControllerTest::testCadastrarVenda
    public function testCadastrarVenda()
    {
        // Define os dados para a venda
            $data = [
                '_id' => 10,
                'products' => [
                    [
                        'product_id' => 1,
                        'nome' => 'Produto1',
                        'price' => 10.99,
                        'amount' => 2,
                    ],
                ],
            ];

            $response = $this->postJson('/api/vendas', $data);

            $response->assertStatus(200);
    }

    #php artisan test --filter=VendaControllerTest::testEditarVendaInvalidData
    public function testEditarVendaInvalidData()
    {
        $response = $this->json('PUT', '/api/vendas/{id}', [
            'products' => [
                [
                    'product_id' => 1,
                ],
            ],
        ]);
    
        $response->assertStatus(400)
            ->assertJson([
                'error' => 'Erro ao adicionar o produto',
            ]);
    }

    #php artisan test --filter=VendaControllerTest::testConsultarVendasRealizadas
    public function testConsultarVendasRealizadas()
    {
        $response = $this->json('GET', '/api/vendas');

        $response->assertStatus(200)
            ->assertJson([
            ]);
    }

    #php artisan test --filter=VendaControllerTest::testConsultarVendaEspecifica
    public function testConsultarVendaEspecifica()
    {
        $response = $this->json('GET', '/api/vendas/{id}');

        $response->assertStatus(200)
            ->assertJson([
            ]);
    }

    #php artisan test --filter=VendaControllerTest::testCancelarVenda
    public function testCancelarVendaSaleNotFound()
    {
        // Choose a sale ID that does not exist
        $nonExistentSaleId = 9999;

        try {
            $response = $this->json('DELETE', "/api/vendas/{$nonExistentSaleId}");
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Venda não encontrada.',
            ]);
    }
}