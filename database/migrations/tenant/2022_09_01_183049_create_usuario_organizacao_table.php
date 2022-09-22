<?php

use Bcampti\Larabase\Enums\StatusUsuarioEnum;
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
        Schema::create('usuario_organizacao', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId('id_usuario')->constrained('usuario');
            $table->foreignId('id_organizacao')->constrained('organizacao');
            $table->text("cargo");
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
        Schema::dropIfExists('usuario_organizacao');
    }
};
