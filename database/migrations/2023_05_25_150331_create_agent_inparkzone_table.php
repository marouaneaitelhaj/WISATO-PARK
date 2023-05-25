<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentInparkzoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_inparkzone', function (Blueprint $table) {
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('parkzone_id');
            
            $table->primary(['agent_id', 'parkzone_id']);
            
            
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parkzone_id')->references('id')->on('parkzones')->onDelete('cascade');
            
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
        Schema::dropIfExists('agent_inparkzone');
    }
}
