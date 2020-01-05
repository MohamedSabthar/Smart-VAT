<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenseTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('description');
            $table->double('assessment_ammount');
            $table->bigInteger('assessment_range_id')->unsigned();
            $table->foreign('assessment_range_id')->references('id')->on('assessment_ranges');
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
        Schema::dropIfExists('license_type');
    }
}
