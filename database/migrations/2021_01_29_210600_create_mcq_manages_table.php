<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_manages', function (Blueprint $table) {
            $table->id();
            $table->integer('main_mcq_id')->unsigned()->nullable();
            $table->integer('package_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('admin_id')->unsigned()->nullable();
            $table->integer('set_admin')->default(0)->comment('0 for not , 1 for yes');
            $table->integer('set_answers')->default(0)->comment('0 for not , 1 for yes');
            $table->float('points')->nullable();
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
        Schema::dropIfExists('mcq_manages');
    }
}
