<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*variáveis da tabela Catalogo*/
    public function up(): void
    {
        Schema::create('catalogos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->string('sinopse', 255); 
            $table->string('genero', 255);
            $table->string('ano', 4);
            $table->string('classificacao', 255);


            $table->timestamps(); //para criar os campos
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalogos');
    }
};
