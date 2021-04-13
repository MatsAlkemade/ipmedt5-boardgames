<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGanzenbordTableStepsConsequences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ganzenbord_table_steps_consequences', function (Blueprint $table) {
            $table->integer('stappen')->default(0);
            $table->string('description')->default('Start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ganzenbord_table_steps_consequences');
    }
}
