<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnswerReviewToMcqAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mcq_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('mcq_answers', 'answer_review')) {
                $table->text('answer_review')->nullable()->after('answer_points');
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
        Schema::table('mcq_answers', function (Blueprint $table) {
            //
        });
    }
}
