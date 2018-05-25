<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_project', function (Blueprint $table) {
            $table->integer('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->integer('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_project');
    }
}
