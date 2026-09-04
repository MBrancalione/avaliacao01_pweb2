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
            Schema::disableForeignKeyConstraints();

            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('assinaturaestado_id') //chave nestrangeira (foreing key (tem na documentação))
                ->nullable() //evita erros se já tiver coisa no banco //define q ela pode ser null
                ->constrained('assinatura_estados'); //tabela para fazer a relação com a categoria_id
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            //
        }
    };
