<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vats', function (Blueprint $table) {
            $table->bigIncrements('id');            //id for VAT
            $table->string('name');                 //name of the VAT
            $table->double('vat%')->nullable();     //vat% some vat has assesment ammounts
            $table->double('fine%')->nullable();    //fine% some vat doesn't has fine
            $table->string('route');                //contain route link names used in laravel web.php routes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vats');
    }
}