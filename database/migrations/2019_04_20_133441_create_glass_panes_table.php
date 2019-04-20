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
            $table->bigIncrements('id');


            $table->string('order_system_number');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('advance');
            $table->unsignedSmallInteger('distance');
            $table->unsignedTinyInteger('percentage_discount');
            $table->unsignedBigInteger('total_penny_order_sum');
            $table->date('created_at');
            $table->date('deadline_at');
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
