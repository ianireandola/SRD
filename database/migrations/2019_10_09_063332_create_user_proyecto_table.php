<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_proyectos', function (Blueprint $table) {
            $table->bigInteger('proyecto_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->primary(['proyecto_id', 'user_id']);

            $table->foreign('proyecto_id')->references('id')->on('proyectos');
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
        Schema::dropIfExists('user_proyectos');
    }
}
