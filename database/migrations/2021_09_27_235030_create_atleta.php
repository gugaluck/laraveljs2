<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtleta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbatleta', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 60);
            $table->decimal('peso', 10, 2);
            $table->decimal('altura', 10, 2);
            $table->unsignedBigInteger('id_time');
            $table->foreign('id_time')->references('id')->on('tbtime');
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
        Schema::dropIfExists('tbatleta');
    }
}
