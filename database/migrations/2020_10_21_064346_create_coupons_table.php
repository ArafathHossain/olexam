<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->longText('description')->nullable();
            $table->string('type')->default('percent')->comment('Discount Type Fix And Percent');
            $table->float('discount');
            $table->date('date');
            $table->integer('status')->default(1)->comment('Status 1 active or 0 inactive');
            $table->integer('user')->nullable()->comment('Coupons for limited users');
            $table->integer('min_buy')->nullable();
            $table->integer('coupon_use')->default(0)->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
