<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holes', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('glass_pane_id');
            $table->unsignedInteger('number')->default('1');
            $table->unsignedInteger('diameter')->default('1');
            $table->string('unit')->default('szt');
            $table->unsignedInteger('price');
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
        Schema::dropIfExists('holes');
    }
}
