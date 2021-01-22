<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecializacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especializacoes', function (Blueprint $table) {
            $table->increments('id_especializacao');
            $table->string('nome', 100);
            $table->string('imagem', 200);
            $table->text('descricao');
            $table->double('preco_parcela', 10, 2);
            $table->double('preco_total', 10, 2);
            $table->string('nome_curto', 50);
            $table->integer('qtd_horas_certificado')->default(0);
            $table->string('identificador_hotmart', 100);
            $table->string('video', 250);
            $table->enum('disponivel', ['S', 'N'])->default('S');
            $table->string('data_liberacao', 10);
            $table->softDeletes();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('titulo_chamada', 100)->nullable();
            $table->string('imagem_social', 100)->nullable();
            $table->string('cor_landing', 30)->nullable();
            $table->string('link_compra', 200)->nullable();
            $table->string('msg_comprar', 200)->nullable();
            $table->double('valor_ant', 10, 2)->nullable();
            $table->double('valor', 10, 2)->nullable();
            $table->integer('total_parcelas')->nullable();
            $table->double('valor_parcela', 10, 2)->nullable();
            $table->string('view_projeto_pratico', 100)->nullable();
            $table->integer('time_access')->nullable()->default(366)->comment('Tempo em dias que este curso estará disponível para a pessoa');
            $table->string('link_desconto', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('especializacoes');
    }
}
