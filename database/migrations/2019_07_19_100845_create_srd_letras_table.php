<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrdLetrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srd_letras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('letra_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->date('fecha');
            $table->float('cantidadHoras');
            $table->boolean('viaje')->nullable();

            $table->unique(['letra_id', 'user_id', 'fecha']);

            $table->foreign('letra_id')->references('id')->on('letras');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('srd_letras');
    }
}
