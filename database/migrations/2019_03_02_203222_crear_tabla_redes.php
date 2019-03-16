<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaRedes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipoRed');
            $table->string('nombreRed');
            $table->string('passwordRed');
            $table->boolean('estadoRed');
            $table->string('latitud');
            $table->string('longitud');
            $table->unsignedInteger('idUser');
           
        });
        Schema::table('redes', function($table) {
            $table->foreign('idUser')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redes');
    }
}
