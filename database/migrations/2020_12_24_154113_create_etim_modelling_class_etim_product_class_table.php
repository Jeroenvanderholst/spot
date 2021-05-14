<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtimModellingClassEtimProductClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etim_modelling_class_etim_product_class', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('ec_id',8);
            $table->char('mc_id', 8);
            $table->tinyInteger('version');
            $table->timestamps();

            $table->unique(['ec_id' ,'mc_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etim_modelling_class_etim_product_class');
    }
}
