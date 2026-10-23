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
    Schema::table('users', function (Blueprint $table) {
        $table->string('cep', 9)->nullable()->after('foto_perfil');
        $table->string('logradouro')->nullable()->after('cep');
        $table->string('numero', 20)->nullable()->after('logradouro');
        $table->string('complemento')->nullable()->after('numero');
        $table->string('bairro')->nullable()->after('complemento');
        $table->string('cidade')->nullable()->after('bairro');
        $table->string('estado', 2)->nullable()->after('cidade');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'estado']);
    });
}
};
