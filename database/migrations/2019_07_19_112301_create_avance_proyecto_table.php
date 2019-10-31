<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvanceProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avance_proyecto', function (Blueprint $table) {
            $table->bigInteger('hito_id')->unsigned();
            $table->bigInteger('proyectoPadre_id')->unsigned();
            $table->integer('NTP');

            $table->primary(['hito_id', 'proyectoPadre_id']);

            $table->foreign('hito_id')->references('id')->on('hitos');
            $table->foreign('proyectoPadre_id')->references('id')->on('proyecto_padres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_avance_proyecto');
    }
}
