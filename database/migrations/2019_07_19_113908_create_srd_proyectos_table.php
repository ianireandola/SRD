<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrdProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srd_proyectos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('proy_id')->unsigned();
            $table->bigInteger('us_id')->unsigned();
            $table->bigInteger('acc_id')->unsigned()->nullable();
            $table->bigInteger('el_id')->unsigned()->nullable();
            $table->date('fecha');
            $table->float('cantidadHoras');
            $table->boolean('viaje')->nullable();
            $table->boolean('nivel2');

            $table->unique(['proy_id', 'us_id', 'fecha', 'acc_id', 'el_id']);

            $table->foreign('proy_id')->references('id')->on('proyectos');
            $table->foreign('us_id')->references('id')->on('users');
            $table->foreign('acc_id')->references('id')->on('accion2s');
            $table->foreign('el_id')->references('id')->on('elementos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('srd_proyectos');
    }
}
