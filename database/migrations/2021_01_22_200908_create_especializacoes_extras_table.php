<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecializacoesExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especializacoes_extras', function (Blueprint $table) {
            $table->increments('id_espe_extra');
            $table->unsignedInteger('id_especializacao')->index('especializacoes_extras_id_especializacao_foreign');
            $table->unsignedInteger('id_espe_bonus')->index('especializacoes_extras_id_espe_bonus_foreign');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('especializacoes_extras');
    }
}
