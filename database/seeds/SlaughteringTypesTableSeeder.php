<?php

use Illuminate\Database\Seeder;

class SlaughteringTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slaughtering_type')->insert([
            ['description'=>'Slaughtering with permit-Cow','amount'=>450],
            ['description'=>'Slaughtering without permit-Cow','amount'=>600],
            ['description'=>'Slaughtering in special occations-Cow','amount'=>350],
            ['description'=>'Slaughtering with permit-Goat','amount'=>500],
            ['description'=>'Slaughtering without permit-Goat','amount'=>650],
            ['description'=>'Slaughtering in special occations-Goat','amount'=>450],
            ['description'=>'Slaughtering with permit-Pig','amount'=>500],
            ['description'=>'Slaughtering without permit-Pig','amount'=>650],
            
        ]);
    }
}
