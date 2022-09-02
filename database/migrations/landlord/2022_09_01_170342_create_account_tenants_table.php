<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTenantsTable extends Migration
{
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //$table->string('domain')->unique();
            $table->string('database')->unique();
            $table->string('status');
            $table->string('repositorio')->unique();
            $table->foreignId('id_usuario_criacao')->constrained('users');
            $table->foreignId('id_usuario_alteracao')->nullable()->constrained('users');
            $table->timestamps();
        });
    }
}
