<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });*/
        Schema::create('vinos', function (Blueprint $table) {
            $table->bigIncrements('idVino');
            $table->string('nombre')->nullable();
            $table->string('grado')->nullable();
            $table->string('año')->nullable();
        });
        Schema::create('productores', function (Blueprint $table) {
            $table->bigIncrements('idProductor');
            $table->string('apellido')->nullable();
            $table->string('nombre')->nullable();
            $table->string('region')->nullable();
        });
        
        Schema::create('produccion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('cantidadBotellas')->nullable();
            $table->bigInteger('vinos_idVino')->unsigned();
            $table->foreign('vinos_idVino')->references('idVino')->on('vinos')->onDelete('cascade');
            $table->bigInteger('productores_idProductor')->unsigned();
            $table->foreign('productores_idProductor')->references('idProductor')->on('productores')->onDelete('cascade');

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
}
