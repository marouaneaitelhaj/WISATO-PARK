<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryWiseParkzoneSlotNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_wise_parkzone_slot_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parkzone_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('slot_number');
            // now the foreign key
            $table->foreign('parkzone_id')->references('id')->on('parkzones')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_wise_parkzone_slot_numbers');
    }
}
