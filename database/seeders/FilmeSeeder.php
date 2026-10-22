<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents; //serve para evitar que os eventos do modelo sejam disparados durante a execução do seeder
use Illuminate\Database\Seeder;
use App\Models\Filme;

class FilmeSeeder extends Seeder
{
    public function run(): void
    {
        //define os arquivos para popular o banco de dados
        Filme::factory()
        ->count(10)
        ->create();
    }
}
