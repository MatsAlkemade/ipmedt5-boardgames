<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirtySecondsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thirty_seconds_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_1');
            $table->string('question_2');
            $table->string('question_3');
            $table->string('question_4');
            $table->string('question_5');
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
        Schema::dropIfExists('thirty_seconds_questions');
    }
}
