<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('main_mcq_id')->unsigned()->nullable();
            $table->string('sl')->nullable();
            $table->integer('question_id');
            $table->string('questions_type');
            $table->longText('questions_title')->nullable();
            $table->string('options')->nullable()->comment('explode by ||');
            $table->string('options_id')->nullable()->comment('explode by ||');
            $table->string('answers')->nullable()->comment('explode by ||');
            $table->string('answers_id')->nullable()->comment('explode by ||');
            $table->string('answer_points')->nullable();
            $table->timestamps();
            $table->foreign('main_mcq_id')->references('id')->on('main_mcqs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mcq_answers');
    }
}
