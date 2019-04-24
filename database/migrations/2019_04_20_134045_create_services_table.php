<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('glass_pane_id');
            $table->unsignedInteger('service_list_id');
            $table->unsignedSmallInteger('quantity')->nullable();

            $table->foreign('glass_pane_id')
                  ->references('id')->on('glass_panes')
                  ->onDelete('cascade');

            $table->foreign('service_list_id')
                  ->references('id')->on('service_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
