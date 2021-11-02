<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('class_id')->unsigned()->nullable();
            $table->bigInteger('subject_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->integer('package_type')->default(0)->comment('Type 0 free and Type 1 Pro');
            $table->string('free_mcq')->nullable();
            $table->float('org_price')->nullable();
            $table->float('sale_price')->nullable();
            $table->longText('description');
            $table->string('photo')->nullable()->default('package.jpg');
            $table->string('video')->nullable();
            $table->string('skill_level')->nullable();
            $table->string('mediam')->default('English')->nullable();
            $table->string('features')->nullable()->comment('Implode by ||');
            $table->integer('view')->default(0);
            $table->integer('popular_package')->default(0);
            $table->integer('featured_package')->default(0);
            $table->timestamps();
            // foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('student_classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
