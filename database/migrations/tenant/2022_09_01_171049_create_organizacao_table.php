<?php

use Bcamp\Larabase\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizacao', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->text("nome");
            $table->text("razao_social");
            $table->text("cnpj");
            $table->text("endereco");
            $table->text("bairro");
            $table->text("cep");
            $table->text("cidade");
            $table->text("estado");
            $table->text("email");
            $table->text("telefone");
            $table->text("status")->default(StatusEnum::ATIVO->value);
            $table->timestamp("created_at")->useCurrent();
            $table->foreignId('id_usuario_criacao')->nullable()->constrained('users');
            $table->timestamp("updated_at")->nullable();
            $table->foreignId('id_usuario_alteracao')->nullable()->constrained('users');
            $table->bigInteger("id_organizacao_migration");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizacao');
    }
};
