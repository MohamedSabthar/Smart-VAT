<?php

use Illuminate\Database\Seeder;

class VatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vats')->insert([
            'name' => 'Buisness Tax',
            //vat and fine refered on seperate table
            'route'=> 'buisness'
        ]);

        DB::table('vats')->insert([
            'name' => 'Industrial Tax',
            'vat_percentage' => 15,
            'fine_percentage'=> 10,
            'route'=> 'industrial'
        ]);

        DB::table('vats')->insert([
            'name' => 'Licence Tax',
            'vat_percentage' => 15,
            'fine_percentage'=> 10,
            'route'=> 'licence'
        ]);

        DB::table('vats')->insert([
            'name' => 'Land Tax',
            'vat_percentage' => 15,
            'fine_percentage'=> 10,
            'route'=> 'land'
        ]);

        DB::table('vats')->insert([
            'name' => 'Advertizement Tax',
            //vat and fine refered on sperate table
            'route'=> 'advertizement'
        ]);
    }
}