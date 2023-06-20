<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parkzone_id');
            $table->string('image');
            $table->timestamps();

            $table->foreign('parkzone_id')->references('id')->on('parkzones')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('galleries');
    }
}
