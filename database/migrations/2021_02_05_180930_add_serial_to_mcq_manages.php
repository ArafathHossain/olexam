<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSerialToMcqManages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mcq_manages', function (Blueprint $table) {
            if (!Schema::hasColumn('mcq_manages', 'serial_number')) {
                $table->string('serial_number')->nullable()->after('id');
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
        Schema::table('mcq_manages', function (Blueprint $table) {
            if (Schema::hasColumn('mcq_manages', 'serial_number')) {
               $table->dropColumn('serial_number') ;
            }
        });
    }
}
