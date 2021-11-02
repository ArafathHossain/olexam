<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnswerReviewToMcqUserAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mcq_user_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('mcq_user_answers', 'answer_review')) {
                $table->text('answer_review')->nullable()->after('points');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mcq_user_answers', function (Blueprint $table) {
            //
        });
    }
}
