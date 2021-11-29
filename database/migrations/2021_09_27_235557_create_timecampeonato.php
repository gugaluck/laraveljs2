<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimecampeonato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbtimecampeonato', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timcodigo');
            $table->foreign('timcodigo')->references('id')->on('tbtime');
            $table->unsignedBigInteger('camcodigo');
            $table->foreign('camcodigo')->references('id')->on('tbcampeonato');
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
        Schema::dropIfExists('tbtimecampeonato');
    }
}
