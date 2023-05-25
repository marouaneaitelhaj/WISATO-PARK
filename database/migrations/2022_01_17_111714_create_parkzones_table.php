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
            $table->string('lng');
            $table->string('lat');
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
