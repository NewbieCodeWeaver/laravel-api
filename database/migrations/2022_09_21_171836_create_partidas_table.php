<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('valor_dado1');
            $table->tinyInteger('valor_dado2');
            $table->tinyInteger('resultado');
            $table->tinyInteger('porcentaje_exito');
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable();;
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partidas');
    }
}
