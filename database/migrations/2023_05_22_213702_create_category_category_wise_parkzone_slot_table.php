<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryCategoryWiseParkzoneSlotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_category_wise_parkzone_slot', function (Blueprint $table) {
            $table->id();
            $table->string('slot_number');
            $table->unsignedBigInteger('slot_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('slot_id')
                ->references('id')
                ->on('category_wise_parkzone_slots')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

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
        Schema::dropIfExists('category_category_wise_parkzone_slot');
    }
}
