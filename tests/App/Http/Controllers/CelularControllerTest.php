<?php

namespace Tests\App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory; 

class CelularControllerTest extends TestCase
{
    use RefreshDatabase;

    #php artisan test --filter=CelularControllerTest::testIndex
    public function testIndex()
    {
        $response = $this->get('/api/celulares');
        $response->assertStatus(200);
    }

    #php artisan test --filter=CelularControllerTest::testStore
    public function testStore()
    {
        $data = [
            'celulares' => [
                [
                    'name' => 'Celular Test 1',
                    'price' => 99.99,
                    'amount' => 10,
                    'description' => 'Test Description 1',
                ],
                [
                    'name' => 'Celular Test 2',
                    'price' => 129.99,
                    'amount' => 5,
                    'description' => 'Test Description 2',
                ],
            ],
        ];

        $response = $this->postJson('/api/celulares', $data);
        $response->assertStatus(201);
    }

    #php artisan test --filter=CelularControllerTest::testShow
    public function testShow()
    {
        $celular = Factory::factoryForModel(\App\Models\Celular::class)->create();

        $response = $this->get('/api/celulares/' . $celular->id);

        $response->assertStatus(200);
        
        $response->assertJson([
            'id' => $celular->id,
            'name' => $celular->name,
            'price' => $celular->price,
            'amount' => $celular->amount,
            'description' => $celular->description,
        ]);
    }

    #php artisan test --filter=CelularControllerTest::testUpdate
    public function testUpdate()
    {
        $celular = Factory::factoryForModel(\App\Models\Celular::class)->create();

        $data = [
            'name' => 'Updated Celular',
            'price' => 79.99,
            'amount' => 5,
            'description' => 'New description',
        ];

        $response = $this->put('/api/celulares/' . $celular->id, $data);

        $response->assertStatus(200);
        
    }

    #php artisan test --filter=CelularControllerTest::testDestroy
    public function testDestroy()
    {
        $celular = Factory::factoryForModel(\App\Models\Celular::class)->create();

        $response = $this->delete('/api/celulares/' . $celular->id);
        $response->assertStatus(204);
    }
}
