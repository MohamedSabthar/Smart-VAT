<?php

use Illuminate\Database\Seeder;

class AdvertisementTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('advertisement_tax')->insert([
            ['description'=>'Temporary advertisement',
            'vat_percentage'=>15,
            'fine_percentage' =>0],
            ['description'=>'Perment advertisement',
            'vat_percentage'=>15,
            'fine_percentage' =>0],
            ['description'=>'LED',
            'vat_percentage'=>15,
            'fine_percentage' =>10]

        ]);
    }
}
