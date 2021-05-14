<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtimProductClassEtimFeatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etim_product_class_etim_feature', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('change_code', 80);
            $table->unsignedTinyInteger('sort_order');
            $table->char('ec_id', 8);
            $table->char('ef_id', 8);
            $table->char('eu_id_metric', 8)->nullable();
            $table->char('eu_id_imperial', 8)->nullable();
            $table->timestamps();

            $table->unique(['id', 'ef_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etim_product_class_etim_feature');
    }
}
