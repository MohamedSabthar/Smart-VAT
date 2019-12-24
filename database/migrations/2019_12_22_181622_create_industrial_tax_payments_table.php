<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustrialTaxPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industrial_tax_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('payment');
            $table->bigInteger('shop_id')->unsigned();
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('industrial_tax_shops'); // a tax payment for a industrial shop
            $table->foreign('payer_id')->references('id')->on('vat_payers');    // a tax payment by a vat payer
            $table->foreign('user_id')->references('id')->on('users');          // an employee enteres the record
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
        Schema::dropIfExists('industrial_tax_payments');
    }
}
