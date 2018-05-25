<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NicheProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niche_project', function (Blueprint $table) {

            $table->integer('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            $table->integer('niche_id')->unsigned()->index();
            $table->foreign('niche_id')->references('id')->on('niches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('niche_project');
    }
}
