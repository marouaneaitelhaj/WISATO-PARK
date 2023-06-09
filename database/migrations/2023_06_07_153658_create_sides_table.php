<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parkzone_id');
            $table->foreign('parkzone_id')->references('id')->on('parkzones')->onDelete('cascade');
            $table->string('side');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->unique(['parkzone_id', 'side']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sides');
    }
}
