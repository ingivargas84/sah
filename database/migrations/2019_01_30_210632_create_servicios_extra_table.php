<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosExtraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios_extra', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_servicio');
            $table->boolean('estado')->default(1);
            $table->decimal('precio');
            $table->string('descripcion');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedInteger('tipo_id');
            $table->foreign('tipo_id')->references('id')->on('tipo_servicios_extra')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios_extra');
    }
}
