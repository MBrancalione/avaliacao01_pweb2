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
        ]);
        
        //cria o estado padrão do admin
        $estado = AssinaturaEstado::factory()->create(['status' => 'Ativa',]);


        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'assinaturaestado_id' => $estado->id,
            'is_admin' => true,]);

    }
}
