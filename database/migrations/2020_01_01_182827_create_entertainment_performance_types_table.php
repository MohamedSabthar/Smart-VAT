<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntertainmentPerformanceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entertainment_performance_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');          //description about the performance type
            $table->double('amount');               // basic payment
            $table->double('additional_amount');      //ammount per additional day
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
        Schema::dropIfExists('entertainment_performance_types');
    }
}
