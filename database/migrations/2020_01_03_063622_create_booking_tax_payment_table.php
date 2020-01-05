<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTaxPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_tax_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('payment');
            $table->bigInteger('shop_id')->unsigned();
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('shop_rent_tax'); // a tax payment for a industrial shop
            $table->foreign('payer_id')->references('id')->on('vat_payers');    // a tax payment by a vat payer
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_tax_payment');
    }
}
