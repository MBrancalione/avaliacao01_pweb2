<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avaliacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filme_id')->constrained('filmes')->onDelete('cascade'); // Chave estrangeira para o catálogo
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Chave estrangeira para o catálogo
            $table->integer('nota');
            $table->text('comentario')->nullable();
            $table->boolean('spoiler')->default(false);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacao');
    }
};
