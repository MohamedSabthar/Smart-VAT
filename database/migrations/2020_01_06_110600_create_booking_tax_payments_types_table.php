<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTaxPaymentsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_tax_payments_types', function (Blueprint $table) {
            $table->bigInteger('payment_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned();
            $table->bigInteger('sub_id')->unsigned();
            $table->primary(['payment_id','parent_id','sub_id']);
            $table->foreign('payment_id')->references('id')->on('booking_tax_payments');
            $table->foreign('parent_id')->references('id')->on('booking_tax_types');
            $table->foreign('sub_id')->references('id')->on('booking_tax_sub_types');

            
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
        Schema::dropIfExists('booking_tax_payments_types');
    }
}