<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorsInParksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operators_in_parks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_wise_floor_slot_id');
            $table->unsignedBigInteger('operator_id');

            // Define foreign key constraints
            $table->foreign('category_wise_floor_slot_id')
                ->references('id')
                ->on('category_wise_floor_slots')
                ->onDelete('cascade');

            $table->foreign('operator_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('operators_in_parks');
    }
}
