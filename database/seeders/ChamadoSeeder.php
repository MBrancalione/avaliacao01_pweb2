<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents; //serve para evitar que os eventos do modelo sejam disparados durante a execução do seeder
use Illuminate\Database\Seeder;
use App\Models\Chamado;

class ChamadoSeeder extends Seeder
{
    public function run(): void
    {
        //define os arquivos para popular o banco de dados
        Chamado::factory()
        ->count(5)
        ->create();
    }
}
