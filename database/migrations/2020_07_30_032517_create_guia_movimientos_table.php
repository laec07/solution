<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_movimientos', function (Blueprint $table) {
            $table->primary('id_movimiento', 'no_guia');
            
            $table->unsignedBigInteger('id_movimiento');
            $table->string('no_guia',20);
            $table->unsignedBigInteger('user_id');
            $table->date('fecha');
            $table->datetime('hora');
            $table->string('estado',10)->nullable();
            $table->unsignedBigInteger('id_agencia');
            $table->timestamps();


            $table->foreign('id_movimiento')
                ->references('id')
                ->on('movimientos')
                ->ondDelete('cascade');

            $table->foreign('no_guia')
                ->references('no_guia')
                ->on('detalle_envios')
                ->ondDelete('cascade');                

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->ondDelete('cascade');

            $table->foreign('id_agencia')
                ->references('id')
                ->on('agencias')
                ->ondDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guia_movimientos');
    }
}
