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
            $table->boolean('assinged_to_court')->default(0);       //if vat payer doesn't pay the amount on time then he will be assigned to court
            $table->bigInteger('shop_id')->unsigned();
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('business_tax_shops'); // a tax payment for a buisness
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
        Schema::dropIfExists('buisness_tax_payments');
    }
}