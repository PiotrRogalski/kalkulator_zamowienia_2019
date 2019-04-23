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
            $table->string('name');
            $table->string('unit')->default('szt');
            $table->unsignedInteger('price')->default('0');
            $table->unsignedSmallInteger('number')->nullable();
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
        Schema::dropIfExists('services');
    }
}
