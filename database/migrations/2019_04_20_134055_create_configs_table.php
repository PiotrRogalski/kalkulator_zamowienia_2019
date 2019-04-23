<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('distance_km_price')->default('200');
            $table->unsignedInteger('free_delivery_from_price')->default('0')->nullable();
            $table->unsignedInteger('free_delivery_distance')->nullable();
            $table->text('company_metadata');
            $table->text('last_company_metadata');
            $table->unsignedSmallInteger('standard_order_time')->default('14');
            $table->unsignedSmallInteger('time_of_order_limitation')->default('365');
            $table->string('printing_unit_glass_dimension')->default('mm');
            $table->string('unit_glass_dimension')->default('cm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
