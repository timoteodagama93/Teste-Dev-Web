<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respostas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('enquete_id')->foreign('enquete_id')->references('id')->on('enquetes');
         
            $table->string('alternativa1');
            $table->string('alternativa2');
            $table->string('alternativa3')->nullable();
            $table->string('alternativa4')->nullable();
            $table->string('alternativa5')->nullable();
            $table->string('alternativa6')->nullable();
            $table->string('alternativa7')->nullable();
            $table->string('alternativa8')->nullable();
            $table->string('alternativa9')->nullable();
            $table->string('alternativa10')->nullable();
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
        Schema::dropIfExists('respostas');
    }
}
