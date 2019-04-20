<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlassModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('glass_models', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('name');
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('material_type_id')->nullable();
            $table->unsignedInteger('thickness')->nullable();
            $table->string('unit')->default('m2');
            $table->unsignedInteger('price');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('glass_models');
    }
}
