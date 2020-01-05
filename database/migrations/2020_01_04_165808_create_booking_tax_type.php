<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTaxType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_tax_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('place');
            $table->string('event');
            $table->double('assessment_ammount');
            $table->bigInteger('assessment_range_id')->unsigned();
           // $table->foreign('assessment_range_id')->references('id')->on('assessment_ranges');
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
        Schema::dropIfExists('booking_tax_type');
    }
}
