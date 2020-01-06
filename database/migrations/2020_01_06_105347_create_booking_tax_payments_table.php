<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTaxPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_tax_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payer_id')->unsigned();   // vat payer id
            $table->bigInteger('employee_id')->unsigned();   // user id
            $table->double('payment');
            $table->double('key_money');
            $table->double('returned_money');
            $table->foreign('payer_id')->references('id')->on('vat_payers');  //employee id is FK of users table                  //payer id is FK of vat_payers table
            $table->foreign('employee_id')->references('id')->on('users');
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
        Schema::dropIfExists('booking_tax_payments');
    }
}