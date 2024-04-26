<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proceso>
 */
class ProcesoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'valor' => $this->faker->randomFloat(2, 100, 10000),
            'tipo_transaccion' => $this->faker->randomElement([0, 1]), // Genera aleatoriamente 0 o 1
             
        ];
    }
}
