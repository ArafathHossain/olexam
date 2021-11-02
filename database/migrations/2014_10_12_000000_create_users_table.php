<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('photo')->default('images/user/user.png');
            $table->string('password');
            $table->integer('status')->default(1);
            $table->longText('about')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->integer('zip')->nullable();
            $table->string('grad')->nullable();
            $table->string('favourite_subject')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
