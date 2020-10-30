<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaAsignacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_asignaciones', function (Blueprint $table) {

            $table->primary('no_guia', 'id_ruta');

            $table->string('no_guia',20);
            $table->unsignedBigInteger('id_ruta');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_agencia');
            $table->string('estado',10)->nullable();
            $table->timestamps();

            $table->foreign('no_guia')
                ->references('no_guia')
                ->on('detalle_envios')
                ->ondDelete('cascade');

            $table->foreign('id_ruta')
                ->references('id')
                ->on('rutas')
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
        Schema::dropIfExists('guia_asignaciones');
    }
}
