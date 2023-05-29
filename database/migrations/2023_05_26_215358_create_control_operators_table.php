<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_operators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operator');
            $table->unsignedBigInteger('agent');
            $table->string('status');
            $table->text('remark')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('operator')->references('id')->on('users');
            $table->foreign('agent')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_operators');
    }
}
