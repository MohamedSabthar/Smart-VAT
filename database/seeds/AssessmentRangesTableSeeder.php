<?php

use Illuminate\Database\Seeder;

class AssessmentRangesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Buisness tax ranges vat_id=1
        DB::table('assessment_ranges')->insert(
            [
            'start_value' => 0,
            'end_value' => 6000,
            'vat_id' => 1]
        );

        DB::table('assessment_ranges')->insert(
            [ 'start_value' => 6000,
            'end_value' => 12000,
            'vat_id' => 1]
        );

        DB::table('assessment_ranges')->insert(
            [ 'start_value' => 12000,
            'end_value' => 18750,
            'vat_id' => 1]
        );

        DB::table('assessment_ranges')->insert(
            [ 'start_value' => 18750,
            'end_value' => 75000,
            'vat_id' => 1]
        );

        DB::table('assessment_ranges')->insert(
            ['start_value' => 75000,
            'end_value' => 150000,
            'vat_id' => 1]
        );

        DB::table('assessment_ranges')->insert(
            [ 'start_value' => 15000,
            'vat_id' => 1]
        );
    }
}
