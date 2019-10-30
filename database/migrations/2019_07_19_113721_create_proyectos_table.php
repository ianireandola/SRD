<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('proyectoPadre_id')->unsigned();
            $table->string('nombre');
            $table->text('descripcion');
            $table->enum('estado', ['Activo', 'Cerrado', 'Bloqueado']);
            $table->integer('cantidadActual');
            $table->integer('cantidadTotal');
            $table->string('Ed_PF');
            $table->date('ultimaRevision');
            $table->string('fabricacion');

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
        Schema::dropIfExists('proyectos');
    }
}
