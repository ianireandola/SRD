<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLetrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('dedicacion_id')->unsigned();
            $table->string('nombre');
            $table->text('descripcion');

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
        Schema::dropIfExists('letras');
    }
}
