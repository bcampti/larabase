<?php

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
        Schema::create('user_invitation', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->text("name");
            $table->text("email");
            $table->text("cargo");
	        $table->bigInteger('id_organizacao');
            $table->foreignId('id_account')->constrained('account');
            
	        $table->timestamp("created_at")->useCurrent();
	        $table->foreignId('id_usuario_criacao')->constrained('users');
	        $table->timestamp("updated_at")->nullable();
	        $table->foreignId('id_usuario_alteracao')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_invitation');
    }
};
