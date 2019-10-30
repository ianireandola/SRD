<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLetraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_letra', function (Blueprint $table) {
            $table->bigInteger('letra_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->primary(['letra_id', 'user_id']);

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
        Schema::dropIfExists('user_letra');
    }
}
