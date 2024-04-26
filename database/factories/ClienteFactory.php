<?php

namespace Database\Factories;




use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{

    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'apellido' => $this->faker->lastName(),
            'documento' => $this->faker->randomNumber(),
            'numero_cuenta' => $this->faker->bankAccountNumber(),
            'direccion' => $this->faker->address(),
            'longitud' => $this->faker->longitude($min = -79.0, $max = -66.8), // Genera una longitud aleatoria dentro del rango de Colombia
            'latitud' => $this->faker->latitude($min = -4.2, $max = 12.5), // Genera una latitud aleatoria dentro del rango de Colombia
            'saldo' => $this->faker->randomFloat(2, 100, 10000), // Genera un número flotante aleatorio con 2 decimales
            'foto' => '',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('123'),
            'tipo' => 'cliente',
        ];
    }
}
