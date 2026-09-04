<?php

namespace Database\Seeders;

use App\Models\AssinaturaEstado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssinaturaEstadoSeeder extends Seeder
{
    public function run(): void
    {
        AssinaturaEstado::factory()->count(10)->create();
    }
}
