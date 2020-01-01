<?php

use Illuminate\Database\Seeder;

class EntertainmentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entertainment_types')->insert([
            [ 'description'=>'tickets for cricket events',
            'vat_percentage'=>25],
            [ 'description'=>'tickets for musical show',
            'vat_percentage'=>25],
            [ 'description'=>'tickets for other events',
            'vat_percentage'=>15]
        ]);
    }
}
