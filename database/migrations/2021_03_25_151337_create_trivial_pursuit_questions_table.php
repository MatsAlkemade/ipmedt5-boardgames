<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrivialPursuitQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trivial_pursuit_questions', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->text('question');
            $table->string('answer');
            $table->string('game');
            $table->foreign('game')->references('name')->on('trivial_pursuit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trivial_pursuit_questions');
    }
}
