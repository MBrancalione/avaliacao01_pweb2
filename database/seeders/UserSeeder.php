<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AssinaturaEstado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $estado = AssinaturaEstado::firstOrCreate(['status' => 'Ativa']);

        // Cria o Administrador garantido
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'), // Senha exata
                'assinaturaestado_id' => $estado->id,
                'is_admin' => true,
            ]
        );
        User::factory()->count(10)->create();
    }
}
