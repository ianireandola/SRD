<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('chapa')->unique();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('password_confirmation');
            $table->string('funcion');
            $table->string('comentario');
            $table->bigInteger('categoria_id')->unsigned();
            $table->bigInteger('fijoeventual_id')->unsigned();
            $table->bigInteger('seccion_id')->unsigned();
            $table->boolean('CPUportatil');
            $table->date('fechaCPUportatil');            
            $table->rememberToken();
            $table->timestamps();


            $table->foreign('seccion_id')->references('id')->on('seccions');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('fijoeventual_id')->references('id')->on('fijo_eventuals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }

    public $timestamps = false;

}
