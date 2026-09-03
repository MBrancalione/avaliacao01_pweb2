<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catalogo;

class CatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //define os arquivos para popular o banco de dados
        Catalogo::factory()
        ->count(10)
        ->create();
    }
}
