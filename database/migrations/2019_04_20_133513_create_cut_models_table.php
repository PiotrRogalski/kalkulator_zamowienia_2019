<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCutModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cut_models', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('name');
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('material_type_id')->nullable();
            $table->unsignedInteger('thickness_from')->nullable();
            $table->unsignedInteger('thickness_to')->nullable();
            $table->string('unit')->default('szt');
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
        Schema::dropIfExists('cut_models');
    }
}
