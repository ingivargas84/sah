<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres')->nullable();
            $table->string('telefono')->nullable();
            $table->string('color')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->boolean('estado')->default(1);

            $table->integer('pago')->nullable()->default(0);

            $table->unsignedInteger('habitacion_id');
            $table->foreign('habitacion_id')->references('id')->on('habitacion')->onDelete('cascade');
            

            $table->unsignedInteger('estado_id')->default(1)->nullable();
            $table->foreign('estado_id')->references('id')->on('estado_reservacion')->onDelete('cascade');
            
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
        Schema::dropIfExists('reservaciones');
    }
}
