<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTaxSubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_tax_sub_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sub_type_description');             //sub types of booking tax
            $table->bigInteger('parent_id')->unsigned();   // parent type id
            $table->boolean('is_weekend')->false(); 
            $table->boolean('floor')->false();                     // boolean value indicating whether its weekend day or not
            $table->double('ammount');                          // ammout for the type
            $table->foreign('parent_id')->references('id')->on('booking_tax_types');
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
        Schema::dropIfExists('booking_tax_sub_types');
    }
}
