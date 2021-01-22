<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nome', 100);
            $table->string('foto', 200)->nullable();
            $table->string('email', 100);
            $table->string('password', 200);
            $table->string('telefone', 200)->nullable();
            $table->string('dt_nascimento', 10)->nullable();
            $table->integer('cep')->nullable();
            $table->string('endereco', 200)->nullable();
            $table->integer('numero')->nullable();
            $table->string('bairro', 200)->nullable();
            $table->string('estado', 200)->nullable();
            $table->string('cidade', 200)->nullable();
            $table->text('cargos')->nullable();
            $table->text('experiencias')->nullable();
            $table->text('formacoes')->nullable();
            $table->text('especializacoes')->nullable();
            $table->text('certificacoes')->nullable();
            $table->text('contato')->nullable();
            $table->text('observacao')->nullable();
            $table->enum('tipo', ['usuario', 'professor', 'adm'])->nullable()->default('usuario');
            $table->enum('tipo_user', ['pfis', 'pjur'])->default('pfis');
            $table->string('empresa', 200)->nullable();
            $table->string('cnpj', 100)->nullable();
            $table->rememberToken();
            $table->string('password_resets', 100)->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
