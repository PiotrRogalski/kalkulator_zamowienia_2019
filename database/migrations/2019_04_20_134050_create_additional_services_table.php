<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_services', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('glass_pane_id');
            $table->unsignedInteger('price');
            $table->text('description')->nullable();
            $table->softDeletes();

            $table->foreign('glass_pane_id')
                  ->references('id')->on('glass_panes')
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
        Schema::dropIfExists('additional_services');
    }
}
