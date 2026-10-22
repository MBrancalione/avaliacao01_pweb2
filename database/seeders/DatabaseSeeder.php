<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AssinaturaEstado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlanosSeeder::class,
            GeneroFilmeSeeder::class,
            FilmeSeeder::class,
            UserSeeder::class,
            AvaliacaoSeeder::class,
            ChamadoSeeder::class,
            AssinaturaEstadoSeeder::class,
        ]);
 
        }
}
