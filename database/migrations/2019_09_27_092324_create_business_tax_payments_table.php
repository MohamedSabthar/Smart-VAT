<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTaxPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_tax_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('payment');
            $table->longText('payment_description')->nullable();
            $table->double('due_payment');
            $table->bigInteger('shop_id')->unsigned();
            $table->bigInteger('payer_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('business_tax_shops');
            $table->foreign('payer_id')->references('id')->on('vat_payers');
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
        Schema::dropIfExists('buisness_tax_payments');
    }
}