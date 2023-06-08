<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkzonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkzones', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('quartier_id');
            $table->foreign('quartier_id')->references('id')->on('quartiers')->onDelete('cascade');
            $table->string('lng');
            $table->string('lat');
            $table->string('mode');
            $table->string('type');
            $table->string('remarks')->nullable();
            $table->boolean('in_use')->default(false);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *a
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parkzones');
    }
}
