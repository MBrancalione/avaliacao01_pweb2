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
        $estado = AssinaturaEstado::firstOrCreate(['status' => 'Ativa'],
        [
            'data_vencimento' => now()->addYear(),
            'codigo_transacao' => 'TRX-' . fake()->unique()->regexify('[A-Za-z0-9]{10}'),
            'plano_id' => \App\Models\Planos::All()->random()->id,
        ]);

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
        User::factory()->count(5)->create();
    }
}
