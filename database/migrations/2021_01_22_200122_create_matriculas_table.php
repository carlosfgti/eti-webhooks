<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->increments('id_matricula');
            $table->unsignedInteger('id_especializacao')->index('matriculas_id_especializacao_foreign');
            $table->unsignedInteger('id_user')->index('matriculas_id_user_foreign');
            $table->unsignedInteger('id_plano')->index('matriculas_id_plano_foreign');
            $table->enum('liberado', ['S', 'N'])->default('N');
            $table->string('hottok', 250)->nullable();
            $table->string('prod', 250)->nullable();
            $table->string('prod_name', 350)->nullable();
            $table->string('off', 250)->nullable();
            $table->string('price', 250)->nullable();
            $table->string('aff', 250)->nullable();
            $table->string('aff_name', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('name', 250)->nullable();
            $table->string('first_name', 250)->nullable();
            $table->string('last_name', 250)->nullable();
            $table->string('doc', 250)->nullable();
            $table->string('phone_local_code', 250)->nullable();
            $table->string('phone_number', 250)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('address_number', 250)->nullable();
            $table->string('address_country', 250)->nullable();
            $table->string('address_district', 250)->nullable();
            $table->string('address_comp', 250)->nullable();
            $table->string('address_city', 250)->nullable();
            $table->string('address_state', 250)->nullable();
            $table->string('address_zip_code', 250)->nullable();
            $table->string('transaction', 250)->nullable();
            $table->string('xcod', 250)->nullable();
            $table->string('src', 250)->nullable();
            $table->string('status', 250)->nullable();
            $table->string('payment_engine', 250)->nullable();
            $table->string('payment_type', 250)->nullable();
            $table->string('hotkey', 250)->nullable();
            $table->string('name_subscription_plan', 250)->nullable();
            $table->string('subscriber_code', 250)->nullable();
            $table->string('recurrency_period', 250)->nullable();
            $table->string('recurrency', 250)->nullable();
            $table->string('cms_marketplace', 250)->nullable();
            $table->string('cms_vendor', 250)->nullable();
            $table->string('cms_aff', 250)->nullable();
            $table->string('callback_type', 250)->nullable();
            $table->string('subscription_status', 250)->nullable();
            $table->string('transaction_ext', 250)->nullable();
            $table->string('sck', 10)->nullable();
            $table->string('purchase_date', 25)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('matriculas');
    }
}
