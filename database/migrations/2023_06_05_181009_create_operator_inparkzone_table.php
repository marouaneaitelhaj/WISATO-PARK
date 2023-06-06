<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorInparkzoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operator_inparkzone', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operator_id');
            $table->unsignedBigInteger('parkzone_id');
            $table->foreign('operator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parkzone_id')->references('id')->on('parkzones')->onDelete('cascade');
            $table->unique(['operator_id', 'parkzone_id']);
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
        Schema::dropIfExists('operator_inparkzone');
    }
}
