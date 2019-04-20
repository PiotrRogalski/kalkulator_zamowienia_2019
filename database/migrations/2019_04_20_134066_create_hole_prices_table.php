<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hole_prices', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedSmallInteger('diameter_from');
            $table->unsignedSmallInteger('diameter_to');
            $table->unsignedSmallInteger('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hole_prices');
    }
}
