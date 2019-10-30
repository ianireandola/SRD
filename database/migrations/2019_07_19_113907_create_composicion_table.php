<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComposicionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composicion', function (Blueprint $table) {
            $table->bigInteger('proyecto_id')->unsigned();
            $table->bigInteger('tipoElemento_id')->unsigned();

            $table->primary(['proyecto_id', 'tipoElemento_id']);

            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->foreign('tipoElemento_id')->references('id')->on('tipo_elementos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_composicion');
    }
}
