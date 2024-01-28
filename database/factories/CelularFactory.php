<?php


namespace Database\Factories;

use App\Models\Celular;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Celular>
 */
class CelularFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * 
     */
    //protected $model = Celular::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 500, 10000),
            'description' => $this->faker->sentence
        ];
    }
}
