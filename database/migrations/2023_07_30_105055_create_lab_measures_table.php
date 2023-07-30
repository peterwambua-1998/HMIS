<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_measures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('measure_name');
            $table->string('warning_below')->nullable();
            $table->string('warning_after')->nullable();
            $table->string('unit_of_measurement')->nullable();
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
        Schema::dropIfExists('lab_measures');
    }
}
