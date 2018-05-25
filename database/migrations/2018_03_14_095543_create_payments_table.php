<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_charge_id');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->string('type_payment');
            $table->float('amount');
//            $table->string('balance_transaction');
            $table->string('currency');
//            $table->integer('created');

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
        Schema::dropIfExists('payments');
    }
}
