<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('chapa')->unique();
            $table->string('nombre');
            $table->string('password');
            $table->string('password_confirmation');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }

    public $timestamps = false;

    /**
     * Password (123456): $2y$10$w6B577YqwWlmaqA9WmHYQ.PNHVmgdkX47F9HOjsQOae3yrRZMI4Si
     */
}
