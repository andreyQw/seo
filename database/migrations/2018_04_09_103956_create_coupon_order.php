<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_order', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('coupon_id')->unsigned()->index();
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');

            $table->integer('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

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
        Schema::dropIfExists('coupon_order');
    }
}
