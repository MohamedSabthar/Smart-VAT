<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_tax', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('place'); 
            $table->string('event');                                                          
            $table->bigInteger('payer_id')->unsigned();                         // buisness/Shop owner
            $table->bigInteger('employee_id')->unsigned();
            $table->foreign('payer_id')->references('id')->on('vat_payers');                    //payer id is FK of vat_payers table
            $table->foreign('employee_id')->references('id')->on('users');                    //employee id is FK of users table
            $table->foreign('place')->references('id')->on('booking_tax_types');
            $table->foreign('event')->references('id')->on('booking_tax_types');
        
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
        Schema::dropIfExists('booking_tax');
    }
}
