<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtimProductClassEtimFeatureEtimValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etim_product_class_etim_feature_etim_value', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('ec_id',8);
            $table->char('ef_id',8);
            $table->char('ev_id', 8);
            $table->unsignedTinyInteger('sort_order');
            $table->timestamps();

            $table->unique(['ec_id', 'ef_id', 'ev_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etim_product_class_etim_feature_etim_value');
    }
}
