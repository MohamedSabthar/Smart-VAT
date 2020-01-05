<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVatsOldPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vats_old_percentages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->double('vat_percentage')->nullable();     //vat% some vat has assesment ammounts
            $table->double('fine_percentage')->nullable();    //fine% some vat doesn't has fine
            $table->date('due_date')->nullable(); // automatic mail notifications send on this data
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
        Schema::dropIfExists('vats_old_percentages');
    }
}
