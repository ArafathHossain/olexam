<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqUserAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_mcq_id')->nullable()->constrained('main_mcqs')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('sl')->nullable();
            $table->integer('question_id')->nullable();
            $table->string('questions_type')->nullable();
            $table->string('answers')->nullable()->comment('explode by ||');
            $table->string('answers_id')->nullable()->comment('explode by ||');
            $table->string('correct_answers')->nullable()->comment('explode by ||');
            $table->integer('points')->nullable();
            $table->foreignId('package_id')->nullable()->constrained('packages')->onDelete('cascade');
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
        Schema::dropIfExists('mcq_user_answers');
    }
}
