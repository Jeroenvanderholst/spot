<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtimFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etim_features', function (Blueprint $table) {
            $table->char('id', 8);
            $table->string('language', 8);
            $table->char('abbreviation', 15);
            $table->string('description', 80); 
            $table->timestamps();

            $table->unique(['id','language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etim_features');
    }
}
