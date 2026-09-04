<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Avaliacao;


class AvaliacaoSeeder extends Seeder
{
    public function run(): void
    {
        Avaliacao::factory()->count(5)->create();
    }
}
