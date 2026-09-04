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
        // busca um estado ou ccria um
        $estado = AssinaturaEstado::first() ?? AssinaturaEstado::factory()->create();

        $this->call([
            AssinaturaEstadoSeeder::class,
            PlanosSeeder::class,
            CatalogoSeeder::class,
            AvaliacaoSeeder::class,
            UserSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'assinaturaestado_id' => $estado->id,
            'is_admin' => true,]);

    }
}
