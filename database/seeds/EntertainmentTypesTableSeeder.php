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
            [
                'assessment_ammount'=>2000.0,
                'assessment_range_id' => 10,
            ],
            [
                'assessment_ammount'=>2200.0,
                'assessment_range_id' => 11,
            ],
            [
                'assessment_ammount'=>2400.0,
                'assessment_range_id' => 12,
            ],
            [
                'assessment_ammount'=>2600.0,
                'assessment_range_id' => 13,
            ],
            [
                'assessment_ammount'=>3000.0,
                'assessment_range_id' => 14,
            ],
        ]);
    }
}
