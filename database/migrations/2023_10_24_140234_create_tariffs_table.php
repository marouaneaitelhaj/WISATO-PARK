<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('total_amount', 8, 2);
            $table->decimal('amount', 8, 2);
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->dateTime('validate_start_date'); // Added validate_start_date column
            $table->dateTime('validate_end_date'); // Added validate_end_date column
            $table->foreignId('quartier_id')->nullable()->constrained('quartiers'); // Added quartier_id foreign key
            $table->foreignId('parkzone_id')->nullable()->constrained('parkzones')->onDelete('cascade'); // Added parkzone_id foreign key
            $table->decimal('shadow_amount', 8, 2)->nullable(); // Added shadow_amount column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariffs');
    }
}
