<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExamTypeToLiveExams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_exams', function (Blueprint $table) {
            if (!Schema::hasColumn('live_exams', 'exam_type')) {
                $table->integer('exam_type')->nullable()->comment('0 for free, 1 for pro');
            }
            if (!Schema::hasColumn('live_exams', 'price')) {
                $table->float('price')->nullable();
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
        Schema::table('live_exams', function (Blueprint $table) {
            if (Schema::hasColumn('live_exams', 'exam_type')) {
                $table->dropColumn('exam_type');
            }
            if (Schema::hasColumn('live_exams', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
}
