<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtimModellingClassEtimFeatureEtimValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etim_modelling_class_etim_feature_etim_value', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('mc_id',8);
            $table->char('ef_id',8);
            $table->char('ev_id', 8);
            $table->unsignedTinyInteger('sort_order');
            $table->timestamps();

            $table->unique(['mc_id', 'ef_id', 'ev_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etim_modelling_class_etim_feature_etim_value');
    }
}
