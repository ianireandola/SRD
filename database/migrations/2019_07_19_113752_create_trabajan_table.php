<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('proyecto_id')->unsigned();
            $table->bigInteger('seccion_id')->unsigned();
            $table->integer('horasEstimadas');
            $table->integer('presupuesto');

            $table->unique(['proyecto_id', 'seccion_id']);

            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->foreign('seccion_id')->references('id')->on('seccions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_trabajan');
    }
}
