<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('assinatura_estados', function (Blueprint $table) {
            $table->id();
            $table->string('status');               
            $table->date('data_vencimento');        
            $table->string('codigo_transacao')->unique(); 
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('assinatura_estados');
    }
};
