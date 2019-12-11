<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectoPadresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_padres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('identificador');
            $table->string('nombre');
            $table->enum('estado', ['Activo', 'Cerrado', 'Bloqueado']);
            $table->string('Q_Proyecto');
            $table->string('planificacion')->nullable();
            $table->string('safety')->nullable();
            $table->string('homologaciones')->nullable();
            $table->bigInteger('tipoProyecto_id')->unsigned();
            $table->bigInteger('nacion_id')->unsigned();
            $table->bigInteger('dedicacion_id')->unsigned();

            $table->foreign('tipoProyecto_id')->references('id')->on('tipo_proyectos');
            $table->foreign('nacion_id')->references('id')->on('nacions');
            $table->foreign('dedicacion_id')->references('id')->on('dedicacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto_padres');
    }
}
