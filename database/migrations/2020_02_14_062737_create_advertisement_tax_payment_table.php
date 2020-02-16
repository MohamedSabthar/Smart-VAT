<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementTaxPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_tax_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->string('type');
            $table->bigInteger('square_feet');
            $table->bigInteger('price');
            $table->bigInteger('final_payment');
            $table->bigInteger('payer_id')->unsigned();                         // buisness/Shop owner
            $table->bigInteger('employee_id')->unsigned();
            $table->foreign('payer_id')->references('id')->on('vat_payers');                    //payer id is FK of vat_payers table
            $table->foreign('employee_id')->references('id')->on('users');                    //employee id is FK of users table
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
        Schema::dropIfExists('advertisement_tax_payment');
    }
}
