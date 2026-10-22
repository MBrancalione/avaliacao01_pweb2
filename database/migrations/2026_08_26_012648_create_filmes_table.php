<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*variáveis da tabela Filme*/
    public function up(): void
    {
        Schema::create('filmes', function (Blueprint $table) {
            $table->id();
            
            $table->string('titulo', 255);
            $table->string('sinopse', 255);
            $table->string('ano', 4);
            $table->string('classificacao', 255);
            $table->string('poster', 255)->nullable();
            //Chave Estrangeira Generp
            $table->string('genero_filme');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filmes'); //para apagar a tabela caso seja necessário
    }
};
