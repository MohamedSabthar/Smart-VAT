<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubLicenceTaxClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_licence_tax_clubs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('club_name');                                    // Club name
            $table->double('anual_worth');                                  // anual worth of the club licence
            $table->string('phone', 12);                                    // user's telephone number
            $table->string('registration_no')->unique();                              // club licence issued registration no
            $table->string('door_no');
            $table->string('street');
            $table->string('city');
            $table->string('address')->virtualAs('concat(door_no,", ",street,", ",city)');    //derived attribute Addrerss
            $table->bigInteger('payer_id')->unsigned();                        // club licence owner
            $table->bigInteger('employee_id')->unsigned();
            $table->foreign('payer_id')->references('id')->on('vat_payers');   //payer id is FK of vat_payers table
            $table->foreign('employee_id')->references('id')->on('users');     //employee id is FK of users table

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
        Schema::dropIfExists('club_licence_tax_clubs');
    }
}
