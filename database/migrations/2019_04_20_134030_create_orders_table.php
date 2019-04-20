<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('order_system_number');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('advance')->nullable();
            $table->unsignedSmallInteger('distance')->nullable();
            $table->unsignedTinyInteger('percentage_discount')->nullable();
            $table->unsignedBigInteger('total_penny_order_sum')->nullable();
            $table->date('created_at');
            $table->date('deadline_at');

            $table->foreign('client_id')
                  ->references('id')->on('clients')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
