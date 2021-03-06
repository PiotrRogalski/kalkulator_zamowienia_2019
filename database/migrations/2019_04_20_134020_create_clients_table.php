<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('full_name');
            $table->string('phone_number')->nullable();
            $table->unsignedInteger('place_of_delivery_id')->nullable();
            $table->unsignedTinyInteger('default_distance')->nullable();

            $table->foreign('place_of_delivery_id')
                  ->references('id')->on('place_of_deliveries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
