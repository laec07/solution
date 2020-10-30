<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envios', function (Blueprint $table) {
            $table->bigIncrements('no_envio');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_agencia');
            $table->decimal('total_envio',8,2)->nullable();
            $table->decimal('total_mensajeria',8,2)->nullable();
            $table->string('observaciones',200)->nullable();
            $table->string('estado',10)->nullable();
            $table->date('fecha_recoleccion')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->ondDelete('cascade');

            $table->foreign('id_agencia')
                ->references('id')
                ->on('agencias')
                ->ondDelete('cascade');



            $table->timestamps();


        });

        Schema::create('detalle_envios', function (Blueprint $table) {
            
            $table->string('no_guia',20);
            $table->unsignedBigInteger('no_envio');
            $table->unsignedBigInteger('id_tipo_vehi');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_tarifa');
            $table->string('destinatario',100);
            $table->string('telefono',16);
            $table->string('direccion',200);
            $table->integer('piezas')->nullable();
            $table->decimal('total_paquete',8,2)->nullable();
            $table->string('estado',10)->nullable();
            $table->date('fecha_entregar')->nullable();
            $table->string('observaciones',200)->nullable();
            $table->timestamps();


            $table->foreign('no_envio')
                ->references('no_envio')
                ->on('envios')
                ->ondDelete('cascade');

            $table->foreign('id_tipo_vehi')
                ->references('id')
                ->on('tipo_vehiculos')
                ->ondDelete('cascade');

            $table->foreign('id_cliente')
                ->references('id')
                ->on('clientes')
                ->ondDelete('cascade');

            $table->foreign('id_tarifa')
                ->references('id')
                ->on('tarifarios')
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
        Schema::dropIfExists('envios');
    }
}
