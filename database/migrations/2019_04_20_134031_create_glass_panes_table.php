<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlassPanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('glass_panes', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('glass_model_id');
            $table->unsignedInteger('width');
            $table->unsignedInteger('height');
            $table->unsignedInteger('cut_model_id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('price');

            $table->foreign('order_id')
                  ->references('id')->on('orders')
                  ->onDelete('cascade');

            $table->foreign('glass_model_id')
                  ->references('id')->on('glass_models');
            $table->foreign('cut_model_id')
                  ->references('id')->on('cut_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('glass_panes');
    }
}
