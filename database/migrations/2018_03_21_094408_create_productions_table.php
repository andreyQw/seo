<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            $table->integer('partner_id')->unsigned()->index();
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->boolean('del_partner_id')->nullable();
            $table->boolean('rsos')->nullable();
            $table->string('keywords')->nullable();
            $table->string('priority')->default('Low');
            $table->string('client_approved')->nullable();
            $table->string('topic_approved')->nullable();
            $table->string('content_written')->nullable();
            $table->integer('writer_id')->unsigned()->nullable();
            $table->foreign('writer_id')->references('id')->on('writers')->onDelete('cascade');
            $table->integer('editor_id')->unsigned()->nullable();
            $table->foreign('editor_id')->references('id')->on('editors')->onDelete('cascade');
            $table->string('content_edited')->nullable();
            $table->string('content_status')->nullable();
            $table->string('bio_status')->nullable();
            $table->string('archor_status')->nullable();
            $table->string('content')->nullable();
            $table->string('content_personalized')->nullable();
            $table->string('live')->nullable();
            $table->string('live_link')->nullable();
            $table->string('overall')->nullable();
            $table->string('payment')->default('Awaiting');
            $table->integer('order_id')->unsigned()->nullable();
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
        Schema::dropIfExists('productions');
    }
}
