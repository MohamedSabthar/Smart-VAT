<?php

use Illuminate\Database\Seeder;

class BookingTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booking_tax_type')->insert([
            ['place' => 'Town Hall','event' =>'Weeding Function','date'=> '','time'=>'period not exceeding 06 hours','additional_time'=>1,'assessment_range_id' => 1 ],
        ]);
    }
}
