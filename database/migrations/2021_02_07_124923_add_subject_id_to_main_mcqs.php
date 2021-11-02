<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubjectIdToMainMcqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('main_mcqs', function (Blueprint $table) {
            if (!Schema::hasColumn('main_mcqs', 'subject_id')) {
                $table->integer('subject_id')->nullable();
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
        Schema::table('main_mcqs', function (Blueprint $table) {
            if (Schema::hasColumn('main_mcqs', 'subject_id')) {
                $table->dropColumn('subject_id');
            }
        });
    }
}
