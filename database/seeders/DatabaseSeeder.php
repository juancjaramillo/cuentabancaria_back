<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Proceso;
use App\Models\Cliente;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

      // Crear usuarios aleatorios
      User::factory()->times(3)->create();

      // Crear usuario fijo
      User::factory()->fixedCredentials()->create();


        Cliente::factory()->times(15)->create();
        Proceso::factory()->times(8)->create()->each(function($proceso){
          $proceso->clientes () ->sync(
            Cliente::all()->random(3)
          );
        });    
    }
}
