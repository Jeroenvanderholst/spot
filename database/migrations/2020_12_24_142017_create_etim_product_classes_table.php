<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtimProductClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etim_product_classes', function (Blueprint $table) {
            $table->char('id', 8);
            $table->char('change_code', 80);
            $table->tinyInteger('version');
            $table->string('status', 80);
            $table->char('eg_id', 8);
            $table->timestamps();

            $table->unique(['id', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etim_product_classes');
    }
}
