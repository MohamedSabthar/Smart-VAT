<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandTaxPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('land_tax_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('payment');
            $table->bigInteger('land_id')->unsigned();
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('land_id')->references('id')->on('land_taxes');  //tax payment for a perticular land
            $table->foreign('payer_id')->references('id')->on('vat_payers'); // a tax payment by a vat payer
            $table->foreign('user_id')->references('id')->on('users');    // an employee enters the record
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
        Schema::dropIfExists('land_tax_payments');
    }
}
