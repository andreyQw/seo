<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');

            $table->string('name');
            $table->text('description')->nullable();

            $table->integer('discount_id')->unsigned();
            $table->foreign('discount_id')->references('id')->on('discounts');

            $table->integer('amount');
            $table->date('expiry_date')->nullable();
            $table->boolean('free_shipping')->default(false);
            $table->integer('usage_coupon')->default(0);
            $table->integer('usage_user')->default(0);
            $table->integer('max_spend')->default(0);
            $table->integer('min_spend')->default(0);
            $table->boolean('use_only')->default(false);
//            $table->boolean('sale_items')->default(true);
            $table->string('email_restrict')->nullable();
            $table->boolean('status')->default(true);

            $table->softDeletes();
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
