<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToParkzonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parkzones', function (Blueprint $table) {
            // $table->tinyInteger('level')->after('name')->default(0);
            // $table->string('remarks')->after('level')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parkzones', function (Blueprint $table) {
            // $table->dropColumn('level');
            $table->dropColumn('remarks');
        });
    }
}
