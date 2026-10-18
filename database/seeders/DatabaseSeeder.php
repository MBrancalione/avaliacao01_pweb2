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
            AssinaturaEstadoSeeder::class,
            PlanosSeeder::class,
            CatalogoSeeder::class,
            AvaliacaoSeeder::class,
            UserSeeder::class,
            ChamadoSeeder::class,
        ]);}
}
