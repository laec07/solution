<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidaciones', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('id_agencia');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_cliente');
            $table->decimal('total_paquete',8,2)->nullable();
            $table->decimal('total_mensajeria',8,2)->nullable();
            $table->decimal('total_liquidar',8,2)->nullable();
            $table->string('estado',2)->nullable();
            $table->timestamps();



            $table->foreign('id_agencia')
                ->references('id')
                ->on('agencias')
                ->ondDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->ondDelete('cascade');

            $table->foreign('id_cliente')
                ->references('id')
                ->on('clientes')
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
        Schema::dropIfExists('liquidaciones');
    }
}
