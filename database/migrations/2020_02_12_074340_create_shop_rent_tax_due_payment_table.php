<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopRentTaxDuePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_rent_tax_due_payment', function (Blueprint $table) {
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('shop_id')->unsigned();
            $table->double('due_ammount')->default(0);
            $table->primary(['payer_id','shop_id']);
            $table->foreign('shop_id')->references('id')->on('shop_rent_tax'); // a tax payment for a buisness
            $table->foreign('payer_id')->references('id')->on('vat_payers');    // a tax payment by a vat payer
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_rent_tax_due_payment');
    }
}
