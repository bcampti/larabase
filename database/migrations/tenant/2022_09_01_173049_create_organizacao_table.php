<?php

use Bcampti\Larabase\Enums\StatusEnum;
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
            $table->bigInteger('id_account');
            $table->text("nome");
            $table->text("razao_social")->nullable();
            $table->text("cnpj")->nullable();
            $table->text("endereco")->nullable();
            $table->text("bairro")->nullable();
            $table->text("cep")->nullable();
            $table->text("cidade")->nullable();
            $table->text("estado")->nullable();
            $table->text("email")->nullable();
            $table->text("telefone")->nullable();
            $table->text("status")->default(StatusEnum::ATIVO->value);
            $table->timestamp("created_at")->useCurrent();
            $table->foreignId('id_usuario_criacao')->constrained('usuario');
            $table->timestamp("updated_at")->nullable();
            $table->foreignId('id_usuario_alteracao')->nullable()->constrained('usuario');
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
