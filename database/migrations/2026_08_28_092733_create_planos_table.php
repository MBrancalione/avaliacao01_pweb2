<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('planos', function (Blueprint $table) {
        $table->id();
        $table->string('nome_plano');
        $table->decimal('preco_mensal', 8, 2);
        $table->integer('limite_telas');
        $table->integer('resolucao_max');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planos');
    }
};
