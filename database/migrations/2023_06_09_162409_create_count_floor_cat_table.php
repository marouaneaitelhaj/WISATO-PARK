<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountFloorCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('count_floor_cat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('floor_id');
            $table->unsignedBigInteger('category_id');
            $table->integer('count');
            // Add any other columns you may need

            $table->timestamps();

            // Define foreign key constraints if necessary
            $table->foreign('floor_id')->references('id')->on('floors');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('count_floor_cat');
    }
}
