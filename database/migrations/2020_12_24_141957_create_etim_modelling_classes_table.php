<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtimModellingClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etim_modelling_classes', function (Blueprint $table) {
            $table->char('id', 8);
            $table->char('change_code', 80);              
            $table->tinyInteger('version');
            $table->string('status', 80);
            $table->string('pdf', 255);
            $table->timestamps();

            $table->unique(['id','version']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etim_modelling_classes');
    }
}
