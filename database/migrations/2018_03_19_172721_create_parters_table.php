<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 150);
            $table->string('company_name', 150);
            $table->string('paypal_id', 200);
            $table->string('domain', 100);

            $table->integer('bsi_id')->unsigned();
            $table->foreign('bsi_id')->references('id')->on('bsis');

            $table->integer('niche_id')->unsigned();
            $table->foreign('niche_id')->references('id')->on('niches');

            $table->float('cost');
            $table->integer('month_placements');
            $table->integer('dr');
            $table->integer('tf');
            $table->integer('cf');
            $table->integer('da');
            $table->integer('traffic');
            $table->integer('ref_domains');
            $table->text('description')->nullable();
            $table->string('photo');
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
        Schema::dropIfExists('partners');
    }
}
