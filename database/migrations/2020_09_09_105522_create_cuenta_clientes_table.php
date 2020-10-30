<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentaClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->string('no_cuenta',200);
            $table->unsignedBigInteger('id_banco');
            $table->string('estado',10);                    

                $table->foreign('id_cliente')
                ->references('id')
                ->on('clientes')
                ->ondDelete('cascade');            

                $table->foreign('id_banco')
                ->references('id')
                ->on('bancos')
                ->ondDelete('cascade');

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
        Schema::dropIfExists('cuenta_clientes');
    }
}
